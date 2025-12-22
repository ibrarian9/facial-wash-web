<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Score;
use App\Models\UserRecommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController
{
    public function index()
    {
        $criterias = Criteria::all();
        $lastPreferences = UserRecommendation::where('user_id', Auth::id())
            ->latest()
            ->first();
        return view('spk_user.recommendation_form', compact('criterias', 'lastPreferences'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'weights' => 'required|array'
        ]);

        $alternatives = Alternative::all();
        $criterias = Criteria::all();
        $scores = Score::all();

        if ($scores->isEmpty()) {
            return back()->with('error', 'Data produk belum lengkap diisi oleh Admin. Tidak bisa mencari rekomendasi.');
        }

        $userWeight = $request->input('weights');
        $totalUserWeight = array_sum($userWeight);
        $normalizedWeights = [];

        foreach ($criterias as $c) {
            $weight = $userWeight[$c->id] ?? 1;
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

        if (count($recommendations) > 0) {
            UserRecommendation::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'respondent_name' => Auth::user()->name,
                    'top_product_name' => $recommendations[0]['name'],
                    'score' => $recommendations[0]['score'],
                    'input_criteria' => $request->except(['_token']),
                    'full_result_data' => $recommendations
                ]
            );
        }

        return view('spk_user.recommendation_result', compact(
            'recommendations',
            'alternatives',
            'criterias',
            'matrix',
            'normalizedWeights',
            'vectorS',
            'totalS'
        ));
    }
}
