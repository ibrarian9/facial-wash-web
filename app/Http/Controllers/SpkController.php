<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Score;
use App\Models\UserRecommendation;
use Illuminate\Http\Request;

class SpkController
{
    public function index()
    {
        return view('spk.index');
    }

    public function report()
    {
        $histories = UserRecommendation::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $groupedResults = $histories->groupBy('top_product_name');

        $stats = $histories->groupBy('top_product_name')->map->count();

        return view('spk.recommendation_report', compact('groupedResults', 'stats'));
    }

    // --- ANALISA ---
    public function analysis()
    {
        $alternatives = Alternative::all();
        $criterias = Criteria::all();
        $scores = Score::all();
        $matrix = [];
        foreach ($scores as $s) {
            $matrix[$s->alternative_id][$s->criteria_id] = $s->value;
        }
        return view('spk.analysis', compact('alternatives', 'criterias', 'matrix'));
    }

    public function storeAnalysis(Request $request)
    {
        $inputs = $request->input('nilai');

        $priceCriteria = Criteria::where('code', 'C1')->first();
        $priceCriteriaId = $priceCriteria ? $priceCriteria->id : null;

        foreach ($inputs as $altId => $criteriaValues) {
            foreach ($criteriaValues as $critId => $val) {
                if ($val === null) continue;
                if ($critId == $priceCriteriaId) {
                    $price = (int) $val;
                    if ($price < 50000) $val = 1;
                    elseif ($price <= 100000) $val = 3;
                    else $val = 5;
                }
                Score::updateOrInsert(
                    ['alternative_id' => $altId, 'criteria_id' => $critId],
                    ['value' => $val, 'updated_at' => now()]
                );
            }
        }
        return redirect()->route('spk.calculation')->with('success', 'Data tersimpan.');
    }

    // --- FITUR RESET NILAI (BARU) ---
    public function resetAnalysis()
    {
        Score::truncate(); // Hapus semua data nilai
        return redirect()->route('spk.analysis')->with('success', 'Semua data penilaian telah direset.');
    }

    // --- PERHITUNGAN ---
    public function calculation()
    {
        $criterias = Criteria::all();
        $alternatives = Alternative::all();
        $scores = Score::all();

        if ($alternatives->isEmpty() || $criterias->isEmpty()) return redirect()->route('spk.index');

        $totalWeight = $criterias->sum('weight');
        $normalizedWeights = [];
        foreach ($criterias as $c) {
            $norm = $c->weight / $totalWeight;
            $pangkat = ($c->type == 'cost') ? -$norm : $norm;
            $normalizedWeights[$c->id] = ['name' => $c->name, 'code' => $c->code, 'value' => $norm, 'pangkat' => $pangkat];
        }

        $vectorS = [];
        $totalS = 0;
        foreach ($alternatives as $a) {
            $S = 1;
            foreach ($criterias as $c) {
                $scoreRow = $scores->where('alternative_id', $a->id)->where('criteria_id', $c->id)->first();
                $val = $scoreRow ? $scoreRow->value : 1;
                $pow = pow($val, $normalizedWeights[$c->id]['pangkat']);
                $S *= $pow;
            }
            $vectorS[$a->id] = $S;
            $totalS += $S;
        }

        $vectorV = [];
        foreach ($alternatives as $a) {
            $V = ($totalS > 0) ? ($vectorS[$a->id] / $totalS) : 0;
            $vectorV[] = ['code' => $a->code, 'name' => $a->name, 's_val' => $vectorS[$a->id], 'v_val' => $V];
        }
        usort($vectorV, function ($a, $b) {
            return $b['v_val'] <=> $a['v_val'];
        });

        return view('spk.calculation', compact('criterias', 'normalizedWeights', 'vectorV', 'totalWeight'));
    }

    public function responden()
    {
        $data = UserRecommendation::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $criterias = Criteria::all();

        return view('spk.responden', [
            'title'     => 'Laporan Responden',
            'reports'   => $data,
            'criterias' => $criterias
        ]);
    }

    public function respondenDetail($id)
    {
        $history = UserRecommendation::with('user')->findOrFail($id);
        $savedWeights = $history->input_criteria['weights'] ?? [];

        if (empty($savedWeights)) {
            return back()->with('error', 'Data bobot user tidak ditemukan/corrupt.');
        }

        $alternatives = Alternative::all();
        $criterias = Criteria::all();
        $scores = Score::all();

        $totalUserWeight = array_sum($savedWeights);
        $normalizedWeights = [];

        foreach ($criterias as $c) {
            $weight = $savedWeights[$c->id] ?? 1;
            $norm = $weight / $totalUserWeight;
            $pangkat = ($c->type == 'cost') ? -$norm : $norm;

            $normalizedWeights[$c->id] = [
                'awal' => $weight,
                'norm' => $norm,
                'pangkat' => $pangkat
            ];
        }

        $vectorS = [];
        $totalS = 0;
        $matrix = [];

        foreach ($alternatives as $a) {
            $S = 1;
            foreach ($criterias as $c) {
                $scoreRow = $scores->where('alternative_id', $a->id)
                    ->where('criteria_id', $c->id)
                    ->first();
                $val = $scoreRow ? $scoreRow->value : 1;
                $matrix[$a->id][$c->id] = $val;

                $pow = pow($val, $normalizedWeights[$c->id]['pangkat']);
                $S *= $pow;
            }
            $vectorS[$a->id] = $S;
            $totalS += $S;
        }

        $recommendations = [];
        foreach ($alternatives as $a) {
            $V = ($totalS > 0) ? ($vectorS[$a->id] / $totalS) : 0;

            $recommendations[] = [
                'id' => $a->id,
                'code' => $a->code,
                'name' => $a->name,
                'score' => $V * 100,
                'vector_v' => $V,
                'vector_s' => $vectorS[$a->id]
            ];
        }

        usort($recommendations, function ($a, $b) {
            return $b['score'] <=> $a['score'];
        });

        return view('spk.responden-detail', [
            'title' => 'Detail Perhitungan Responden',
            'history' => $history, // Data user & waktu
            'recommendations' => $recommendations,
            'alternatives' => $alternatives,
            'criterias' => $criterias,
            'matrix' => $matrix,
            'normalizedWeights' => $normalizedWeights,
            'vectorS' => $vectorS,
            'totalS' => $totalS
        ]);
    }
}
