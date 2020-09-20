<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Models\User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $comment
 * @property \Carbon\Carbon|null $deleted_at
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Models\User whereUpdatedAt($value)
 */

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    protected $guarded = [
        'id', 'created_at', 'updated_at'
    ];

    // protected $hidden = [
    //     'password', 'remember_token'
    // ];
}
