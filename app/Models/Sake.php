<?php

namespace App\Models;

use Illuminate\Support\Facades\Log;
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
     * joinしたテーブルからsakes.idでデータを取得する
     *
     * @param int $sake_id
     * @return Illuminate\Database\Eloquent\Collection
     */
    public static function getSakeDatasFromId($sake_id){
        $joined_sakes = static::getJoinedSakeData();
        return $joined_sakes->where('sakes.id', $sake_id);
    }

    /**
     *
     * sakes, personal_evaluations, maker_evaluationsをjoinし
     * 表示用カラムを取得する
     *
     * @return \Illuminate\Database\Eloquent\Collection $joined_sakes
     */
    public static function getJoinedSakeData(){
        $joined_sakes = Sake::join('personal_evaluations','sakes.id','=','personal_evaluations.sake_id')
        ->join('maker_evaluations','sakes.id','=','maker_evaluations.sake_id')
        ->select('sakes.id','name','name_kana','kura','prefecture',
        'sweetness','acidity','richness','cost_performance','recommend_point',
        'sake_degree','amino_acid_degree');

        return $joined_sakes;
    }

    /**
     * 名前からアイテムをあいまい検索
     *
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getSakeFromName($name){
        $sakes = static::getJoinedSakeData();

        return $sakes->where('name', 'like', "%$name%")->get();
    }

    /**
     * メーカーの評価からアイテムを検索
     *
     * @param string $class //sake_degreeかamino_acid_degreeのいずれか
     * @param int $maker_evaluation
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getSakeFromMakerEv($class ,$evaluation){
        $joined_sakes = static::getJoinedSakeData();
        return $joined_sakes->where($class, $evaluation)->get();
    }

    /**
     * 個人の評価からアイテムを検索
     *
     * @param array $personal_ev
     * @return \Illuminate\Database\Eloquent\Collection $sakes
     */
    public static function getSakeFromPersonalEv($personal_ev) {
        $sakes = static::getJoinedSakeData();
        foreach($personal_ev as $key => $value){
            if (!empty($value)) {
                $sakes = $sakes->where($key, $value);
            }
        }
        return $sakes;
    }

    /**
     * ID配列からアイテムを検索
     *
     * @param array $ids
     * @return \Illuminate\Database\Eloquent\Collection $sakes
     */
    public static function getSakeDatasFromIds($ids) {
        $sakes = static::getJoinedSakeData()->whereIn('sakes.id', $ids);
        return $sakes;
    }
}
