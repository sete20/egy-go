<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Due extends Model
{
   protected $guarded=[];
   public function captain(){
       return $this->belongsTo(Captain::class);
   }
}
