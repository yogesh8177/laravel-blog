<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PostMeta extends Model
{
    //
    protected $table="post_meta";

    public function Posts(){
    	return $this->belongsTo("App\Posts","id");
    } 

    public function Author(){
    	return $this->hasOne("App\Authors","id","author_id")->select('display_name');
    }
}
