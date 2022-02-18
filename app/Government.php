<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    protected $table = 'governments';
    protected $guarded = [];

    public function branch()
    {
        return $this->hasMany(Branch::class);
    }
}
