<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class invoices extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $dates = ['delete-at'];


    public function section(){
        return $this->belongsTo('App\sections');
    }

    public function  Value_Status()
    {
    }


}
