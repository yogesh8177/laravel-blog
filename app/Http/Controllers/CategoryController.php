<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CategoryPostMap as CategoryPostMap;
use App\Category as Category;
use App\Posts as Posts;
use DB;

class CategoryController extends Controller
{
    //

    public function searchById(Request $request,$id){

    	$page = $request->input('page') != null ? $request->input('page') : 0;
    	$pageSize = 10;
    	
 		$rows = DB::table('category_post_map')
 					->join('posts','category_post_map.post_id','=','posts.id')
 					->join('post_meta','posts.id','=','post_meta.post_id')
 					->join('authors','post_meta.author_id','=','authors.id')
 					->join('category','category_post_map.category_id','=','category.id')
 					->where('posts.post_type','=','publish')
 					->where('category_post_map.category_id','=',$id)
 					->select('posts.id','post_meta.featured_image','posts.post_title','posts.created_at','category.id','category.category_name','category_post_map.post_id','category_post_map.category_id','authors.display_name')
 					->orderBy('posts.created_at','DESC')
 					->take($pageSize)
 					->skip($page * $pageSize)->get();
//print_r($rows[4]);
    	return view('category.posts',['rows'=>$rows,'page' => $page]);
    }

    public function createview(Request $request){

    	return view('category.createview');
    }

    public function create(Request $request){

    	$category = new Category();
    	$category->category_name = $request->input('category');
    	$category->category_description = $request->input('description');

    	$category->save();

    	return "Created";
    }
}
