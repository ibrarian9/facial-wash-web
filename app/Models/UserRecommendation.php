<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRecommendation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'respondent_name',
        'top_product_name',
        'score',
        'input_criteria',
        'full_result_data'
    ];

    protected $casts = [
        'input_criteria' => 'array',
        'full_result_data' => 'array',
        'score' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
