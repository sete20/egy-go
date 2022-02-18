<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatePrice extends Model
{
    protected $table='states_price';
    protected $guarded=[];
    public function state(){
        return $this->belongsTo(State::class);
    }
}
