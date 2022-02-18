<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $guarded = [];
    public function country()
    {
        return $this->hasOne('App\Country', 'id', 'country_id');
    }
    public function branch()
    {
        return $this->hasOne(Branch::class, 'government_id');
    }
    public function price(){
        return $this->hasOne(StatePrice::class);
    }
}
