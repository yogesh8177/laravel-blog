<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Posts as Posts;
use App\PostMeta as PostMeta;
use App\Authors as Authors;
use App\Comments as Comments;
use App\Category as Category;
use App\CategoryPostMap as CategoryPostMap;
use App\TagPostMap as TagPostMap;
use App\Tags as Tags;
use DB;

class TagsController extends Controller
{
    //

    public function searchById(Request $request, $id){
    	
        $page = $request->input('page') !=null ? $request->input('page') : 0;
        $pageSize = 10;

    	$posts = DB::table('tag_post_map')
    				->join('posts','tag_post_map.post_id','=','posts.id')
    				->join('post_meta','posts.id','=','post_meta.post_id')
    				->join('authors','post_meta.author_id','=','authors.id')
    				->join('tags','tags.id','=','tag_post_map.tag_id')
    				->where('tag_post_map.tag_id','=',$id)
    				->where('posts.post_type','=','publish')
    				->orderBy('posts.created_at','DESC')
                    ->take($pageSize)
                    ->skip($page * $pageSize)
    				->get(['posts.post_title','posts.created_at','post_meta.author_id','post_meta.featured_image','authors.display_name','tag_post_map.tag_id','tags.tag_name']);

    	return view('tags.posts',['posts'=>$posts,'page' => $page]);
    }
}
