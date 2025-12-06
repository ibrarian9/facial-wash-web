<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Score;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SpkController extends Controller
{
    public function index()
    {
        return view('spk.index');
    }

    public function criteria()
    {
        $criterias = Criteria::all();
        return view('spk.criteria', compact('criterias'));
    }

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
        $validator = Validator::make($request->all(), [
            'nilai' => 'required|array',
            'nilai.*.*' => 'required|numeric|min:1',
        ], [
            'nilai.required' => 'Data penilaian tidak ditemukan.',
            'nilai.*.*.required' => 'Semua kolom penilaian (Harga & Kriteria lain) wajib diisi!',
            'nilai.*.*.min' => 'Nilai tidak boleh 0 atau kosong.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('error', 'Terdapat kolom yang belum diisi. Mohon lengkapi semua data.');
        }

        $inputs = $request->input('nilai');

        $priceCriteria = Criteria::where('code', 'C1')->first();
        $priceCriteriaId = $priceCriteria ? $priceCriteria->id : null;

        foreach ($inputs as $altId => $criteriaValues) {
            foreach ($criteriaValues as $critId => $val) {

                if ($critId == $priceCriteriaId) {
                    $price = (int) $val;
                    if ($price < 50000) {
                        $val = 1;
                    } elseif ($price >= 50000 && $price <= 100000) {
                        $val = 3;
                    } else {
                        $val = 5;
                    }
                }

                Score::updateOrInsert(
                    ['alternative_id' => $altId, 'criteria_id' => $critId],
                    ['value' => $val, 'updated_at' => now()]
                );
            }
        }

        return redirect()->route('spk.calculation')->with('success', 'Data analisa berhasil disimpan. Harga telah dikonversi otomatis ke bobot nilai.');
    }


    public function calculation()
    {
        $criterias = Criteria::all();
        $alternatives = Alternative::all();
        $scores = Score::all();

        $totalWeight = $criterias->sum('weight');

        $normalizedWeights = [];
        foreach ($criterias as $c) {
            $norm = $c->weight / $totalWeight;
            $pangkat = ($c->type == 'cost') ? -$norm : $norm;

            $normalizedWeights[$c->id] = [
                'name' => $c->name,
                'code' => $c->code,
                'value' => $norm,
                'pangkat' => $pangkat
            ];
        }

        $vectorS = [];
        $totalS = 0;

        foreach ($alternatives as $a) {
            $S = 1;
            foreach ($criterias as $c) {
                $scoreRow = $scores->where('alternative_id', $a->id)
                    ->where('criteria_id', $c->id)
                    ->first();

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
            $vectorV[] = [
                'code' => $a->code,
                'name' => $a->name,
                's_val' => $vectorS[$a->id],
                'v_val' => $V
            ];
        }

        usort($vectorV, function ($a, $b) {
            return $b['v_val'] <=> $a['v_val'];
        });

        return view('spk.calculation', compact('criterias', 'normalizedWeights', 'vectorV', 'totalWeight'));
    }
}
