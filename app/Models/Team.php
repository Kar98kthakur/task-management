<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'name',
        'invite_code',
    ];

    public function users(){
        return $this->belongsToMany(User::class)->withPivot('role')->withTimestamps();
    }
}
