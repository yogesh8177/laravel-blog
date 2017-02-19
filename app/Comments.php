<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comments extends Model
{
    //
    protected $table = "comments";

    function post(){
    	return $this->belongsTo("App\Posts","id");
    }
}
