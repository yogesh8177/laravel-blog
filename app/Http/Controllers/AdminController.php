<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Posts as Posts;


class AdminController extends Controller
{
    //

    public function index(){

    	return view('admin.index');
    }

    public function view(Request $request){

    	$page = $request->input('page') != null ? $request->input('page') : 0;
    	$posts = Posts::with('PostMeta')->orderBy('created_at','DESC')->take(10)->skip(10 * $page)->get(['id','post_title','created_at']);

    	return view('admin.view',['posts'=>$posts,'page'=>$page]);
    }
}
