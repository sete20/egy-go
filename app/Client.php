<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Client extends Model
{
    protected $guarded = [];

    public function userClient(){
      return $this->hasOne('App\UserClient', 'client_id' , 'id');
    }
    public function addressess(){
      return $this->hasMany('App\AddressClient', 'client_id' , 'id');
    }
    public function packages(){
      return $this->hasMany('App\ClientPackage', 'client_id' , 'id');
    }
    public function state(){
        return $this-> BelongsTo(State::class);
    }


}
