<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Models\Sake
 *
 * @property int $id
 * @property string $name
 * @property string $name_kana
 * @property int $prefecture
 * @property string $kura
 * @property string $memo
 * @property int $personal_preference_id
 * @property int $maker_evaluation_id
 * @property string $comment
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\Sake whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\Sake whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\Sake whereNameKana($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\Sake wherePrefecture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\Sake whereKura($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\Sake whereMemo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\Sake wherePersonalPreferenceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\Sake whereMakerEvaluationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereUpdatedAt($value)
 */

 class Sake extends Model
{
    use SoftDeletes;

    protected $table = 'sakes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    /**
     * @param int $sake_id
     * @return App\Models\Sake|null $joined_sake
     */
    public static function getJoinedData($sake_id){
        $joined_sake = Sake::join('personal_evaluations','sakes.id','=','personal_evaluations.sake_id')
        ->join('maker_evaluations','sakes.id','=','maker_evaluations.sake_id')
        ->where('sakes.id', $sake_id)
        ->select('sakes.id','name','name_kana','kura','prefecture',
        'sweetness','acidity','richness','cost_performance','recommend_point',
        'sake_degree','amino_acid_degree')
        ->first();

        return ($joined_sake);
    }

}
