<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    //
    protected $table = "posts";

    function PostMeta(){
    	return $this->hasOne('App\PostMeta','post_id');
    }

    function Comments(){
    	return $this->hasMany("App\Comments","post_id")->where('approve','=',1)->orderBy('created_at','DESC');
    }

    function Category(){
    	return $this->hasMany("App\CategoryPostMap",'post_id')->select('category_id');
    }

    function Tags(){
    	return $this->hasMany("App\TagPostMap",'post_id');
    }

}
