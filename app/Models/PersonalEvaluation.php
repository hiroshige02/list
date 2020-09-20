<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Models\PersonalEvaluation
 *
 * @property int $id
 * @property int $sake_id
 * @property int $sweetness
 * @property int $sour_taste
 * @property int $richness
 * @property int $cost_performance
 * @property int $recommend_point
 * @property string $comment
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\PersonalEvaluation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\PersonalEvaluation whereSakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\PersonalEvaluation whereSweetness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\PersonalEvaluation whereSourTaste($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\PersonalEvaluation whereRichness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\PersonalEvaluation whereCostPerformance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\PersonalEvaluation whereRecommendPoint($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereUpdatedAt($value)
 *
 */

class PersonalEvaluation extends Model
{
    protected $table = 'personal_evaluations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
