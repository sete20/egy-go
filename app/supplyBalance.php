<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class supplyBalance extends Model
{
   protected $table= 'supply_balances';
   protected $guarded=[];
   public function user(){
       return $this->belongsTo(User::class);
   }
}
