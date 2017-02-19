<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Comments as Comments;
use App\Posts as Posts;

class CommentsController extends Controller
{
    //

    public function create(Request $request){

    	$id = $request->input('id');
    	if(isset($id)){
    		$comment = new Comments();
    		$comment->post_id = $id;
    		$comment->comment_content = $request->input('comment');
    		$comment->author = $request->input('author');
    		$comment->email = $request->input('email');

    		$comment->save();
    		//Posts::where('id','=',$id)->increment('comment_count');

    		return "Comment posted";
    	}
    	return "error";
    }

    public function edit(Request $request, $id){

        $comments = Comments::where('post_id','=',$id)->get();

        return view('comments.edit',['comments' => $comments,'post_id' => $id]);
    }

    //approve comment
    public function approve(Request $request){

        $id = $request->input('id');
        $post_id = $request->input('post_id');

    	if(isset($id)){
            $approve = $request->input('approve');

            if($approve == "approve"){
                Comments::where('id','=',$id)->update(['approve' => 1]);
                Posts::where('id','=',$post_id)->increment('comment_count');
                return "Approved";
            }
            else if($approve == "disapprove"){
                Comments::where('id','=',$id)->update(['approve' => 0]);
                Posts::where('id','=',$post_id)->where('comment_count','>=',0)->decrement('comment_count');
                return "Disapproved";    
            }
    		
    	}

    	return "error";
    }
    //Remove comment
    public function remove(Request $request){

        $id = $request->input('id');
        $post_id = $request->input('post_id');
        $comment = Comments::find($id);
    	if(isset($id)){
            if($comment->approve == 1){
                Posts::where('id','=',$post_id)->where('comment_count','>=',0)->decrement("comment_count");
            }
            Comments::destroy($id);
    		return "Deleted";
    	}
    	return "error";
    }

}
