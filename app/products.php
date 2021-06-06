<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use  App\sections;
class products extends Model
{
   protected  $guarded = [];

   public function section(){
       return $this->belongsTo('App\sections');
   }
}
