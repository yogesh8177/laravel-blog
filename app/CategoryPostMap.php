<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryPostMap extends Model
{
    //
    protected $table = "category_post_map";
    public $timestamps = false;

    protected $fillable = array('post_id','category_id');
   
   	public function Category(){
   		return $this->hasOne("App\Category","id","category_id")->select('category_name');
   	}

   	public function Post(){
   		return $this->hasOne('App\Posts','id','post_id')->orderBy('created_at','DESC');
   	}
}
