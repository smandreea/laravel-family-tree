<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public const FEMALE = 1;
    public const MALE = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "first_name",
        "middle_name",
        "last_name",
        "gender",
        "relationship",
        "related_member"
    ];

    protected $table = 'users';

    protected $with = ['children'];

    /**
     * @return mixed
     */
    public function children()
    {
        return $this->hasMany(FamilyMember::class, 'parent_id', 'id');
    }

}
