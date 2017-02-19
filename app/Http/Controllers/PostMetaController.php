<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use App\PostMeta as PostMeta;
use App\Authors as Authors;

class PostMetaController extends Controller
{
    //
    public function create(Request $request,$id){

        $authors = Authors::all(['id','display_name']);
    	$postmeta = PostMeta::where('post_id','=',$id)->first();
    	$filePath = public_path()."/Images/".$id."/";
    	if(File::exists($filePath)){
    		$files = File::allFiles($filePath);
    		return view('postmeta.create',['authors' => $authors,'postmeta'=>$postmeta,'id'=>$id,'files'=>$files]);
    	}
    	return view('postmeta.create',['authors' => $authors,'postmeta'=>$postmeta,'id'=>$id,'files'=>null]);
    	
    }

    public function edit(Request $request){

    	$id = $request->input('id');

    	if($request->hasFile('featured_image')){
    		if($request->file('featured_image')->isValid()){
    			//File::makeDirectory(public_path()."/Images/".$id);
    			$savePath = "/Images/".$id."/";
    			$filename = $request->file('featured_image')->getClientOriginalName();
    			$request->file('featured_image')->move(public_path().$savePath,$filename);
    			PostMeta::where('post_id','=',$id)->update(['featured_image' => $savePath.$filename]);
    		}
    	}else{
    		return "No image sent";
    	}

    	return Redirect::to("/post/postmeta/".$id);
    }

    public function deleteFeaturedImage(Request $request){

    	$filename = $request->input('filename');
    	if(isset($filename)){
    		$filePath = public_path()."/Images/".$request->input('id')."/".$filename;
    		if(File::exists($filePath)){
    			File::delete($filePath);
    			return 'Image deleted';
    		}else{
    			return 'No image to delete';
    		}
    		
    	}

    	return "error";
    }


    public function updateFeaturedImage(Request $request){

    	$id = $request->input('id');
    	if(isset($id)){
    		$filePath = "/Images/".$id."/".$request->input('filename');
    		PostMeta::where('post_id','=',$id)->update(['featured_image' => $filePath]);

    		return "Updated";
    	}

    	return "error";
    }

    public function updateAuthor(Request $request){

        $id = $request->input('postmeta_id');
        $author_id = $request->input('author_id');
        if(isset($id)){
            PostMeta::where('id','=',$id)->update(['author_id' => $author_id]);
            return "Updated";
        }

        return "Error";
    }

}
