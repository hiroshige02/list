<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Models\PersonalEvaluation
 *
 * @property int $id
 * @property int $sake_id
 * @property int $sake_degree
 * @property int $acidity
 * @property string $comment
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\MakerEvaluation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\MakerEvaluation whereSakeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\MakerEvaluation whereSakeDegree($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\MakerEvaluation whereAcidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereUpdatedAt($value)
 *
 *
 */

class MakerEvaluation extends Model
{
    protected $table = 'maker_evaluations';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];
}
