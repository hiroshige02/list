<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
    use SoftDeletes;

    protected $table = 'personal_evaluations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    // /**
    // この程度ならメソッド化不要？
    //  * 酒IDと結びつく個人評価を返す
    //  *
    //  * @param int $sake_id
    //  * @return \App\Models\user\PersonalEvaluation
    //  */
    // public static function getEvaluationFromSakeId($sake_id){
    //     return PersonalEvaluation::whereSakeId($sake_id);
    // }


}
