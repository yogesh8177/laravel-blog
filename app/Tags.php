<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    //
    protected $table = "tags";
    protected $fillable = array('tag_name');
}
