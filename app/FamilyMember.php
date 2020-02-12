<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    public const CHILD = 1;
    public const PARENT = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        "user_id",
        "parent_id",
    ];

    protected $table = 'family_members';

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }
}
