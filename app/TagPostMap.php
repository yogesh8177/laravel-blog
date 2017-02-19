<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TagPostMap extends Model
{
    //
    protected $table = "tag_post_map";
    public $timestamps = false;
    protected $fillable = array('tag_id','post_id');

    public function Post(){
    	return $this->hasOne("App\Posts","id","post_id");
    }

    public function Tag(){
    	return $this->hasOne("App\Tags",'id','tag_id')->select('tag_name');
    }
}
