<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $table = "branchs";
    protected $guarded = [];
    public function userBranch()
    {
        return $this->hasOne('App\UserBranch', 'branch_id', 'id');
    }
    public function state()
    {
        return $this->belongsTo(State::class, 'government_id');
    }
}
