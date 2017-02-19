<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Authors as Authors;


class AuthorsController extends Controller
{
    //

    public function createview(Request $request){

    	return view('authors.createview');
    }

    public function create(Request $request){

    	$author = new Authors();
    	$author->first_name = $request->input('firstname');
    	$author->last_name = $request->input('lastname');
    	$author->display_name = $request->input('displayname');
    	$author->email = $request->input('email');
    	$author->description = $request->input('description');
    	$author->mobile = $request->input('mobile');
    	//$author->url = $request->input('url');

    	$author->save();
    	return "Author created";
    }
}
