<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Http\Requests;
use DB;
use App\Posts as Posts;
use App\PostMeta as PostMeta;
use App\Authors as Authors;
use App\Comments as Comments;
use App\Category as Category;
use App\CategoryPostMap as CategoryPostMap;
use App\TagPostMap as TagPostMap;
use App\Tags as Tags;

class PostsController extends Controller
{
    //
    function __construct(){

    }

    public function index(Request $request){

        $page = $request->input('page') != null ? $request->input('page') : 0;
        $pageSize = 10;

    	$posts = Posts::with('PostMeta','Comments')->where('posts.post_type','=','publish')->orderBy('created_at','DESC')->take($pageSize)->skip($page * $pageSize)->get();
    	
    	return view("posts.index",['posts'=> $posts,'page' => $page]);
    }

    //Get post by id to view post
    public function getPost(Request $request, $id){

    	$post = Posts::find($id);
    	$tagIds = $this->getTagIds($post);
    	$tags = Tags::select('tag_name','id')->findMany($tagIds);

    	return view('posts.view',['post'=>$post,'tags'=>$tags]);
    }

    //search by title
    public function search(Request $request){

        $page = $request->input('page') != null ? $request->input('page') : 0;
        $pageSize = 10;
    	$key = $request->input('key');

    	if($key == ""){
    		return view("posts.search",['key'=>"",'posts'=> null, 'page' => $page]);
    	}
    	$posts = Posts::with('PostMeta','Comments')
        ->where('posts.post_title','LIKE',$key.'%')
        ->take($pageSize)
        ->skip($page * $pageSize)
        ->get();
  		
    	return view("posts.search",['key'=>$key,'posts'=> $posts,'page' => $page]);
    }
    //get for create view
    public function createview(Request $request){
    	$categories = Category::all();
        $authors = Authors::get(['id','display_name']);
    	return view('posts.createview',['categories'=>$categories, 'authors' => $authors]);
    }

    //post for create post
    public function create(Request $request){

    	$post = new Posts();
    	$post->post_title = $request->input('post_title');
    	$post->post_content = $request->input('post_content');
    	$post->slug = $request->input('slug');
    	$post->post_type = $request->input('post_type');

    	$post->save();
    	$post_id = $post->id;

    	$categoryArray = $request->input('category');
 		$data = array();
 		foreach ($categoryArray as $category) {
 			array_push($data, ['post_id' => $post_id,'category_id' => $category]);
 		}
 		CategoryPostMap::insert($data);

    	$this->addTags($request, $post_id);

        $postmeta = new PostMeta();
        $postmeta->post_id = $post_id;
        $postmeta->author_id = $request->input('author');
    	$postmeta->save();

    	return Redirect::to('/post/create');
    }
    //HTTP GET edit view
    public function editView(Request $request, $id){

    	$post = Posts::with('Category','Tags')->find($id);
    	$categories = Category::all();
    	if($post == null){
    		return "No post";
    	}
    	$post_category = $this->getPostCategories($post);
    	$tagIds = $this->getTagIds($post);

    	$tagArray = Tags::select('tag_name','id')->findMany($tagIds);

    	return view('posts.editpost',['post'=>$post,'categories'=>$categories,'post_category'=>$post_category,'tags'=>$tagArray]);
    }

    public function editPost(Request $request){
    	Posts::where('id','=',$request->input('id'))->update(['post_title' => $request->input('post_title'),
    			'post_content' => $request->input('post_content'),
    			'post_type' => $request->input('post_type'),
    			'slug' => $request->input('slug')
    		]);


    	$this->addCategories($request);

    	$this->addTags($request, $request->input('id'));

    	return "Updated";
    }

    public function deletePost(Request $request){

    	$id = $request->input('id');
    	Posts::destroy($id);
    	PostMeta::where('post_id','=',$id)->delete();
    	Comments::where('post_id','=',$id)->delete();
    	CategoryPostMap::where('post_id','=',$id)->delete();
    	TagPostMap::where('post_id','=',$id)->delete();
    	return "Post deleted!";
    }

    public function deleteTag(Request $request)
    {
    	$tag_id = $request->input('tag_id');
    	$post_id = $request->input('post_id');
    	TagPostMap::where('tag_id','=',$tag_id)->where('post_id','=',$post_id)->delete();
    	return "Tag deleted";
    }


    private function addTags(Request $request, $post_id){
    	$tags = $request->input('tag');

    	if($tags!=""){
    		$tagArray = explode(',', $tags);

	    	foreach ($tagArray as $tag) {
	    		$row = Tags::firstOrNew(['tag_name'=>trim($tag)]);
	    		$row->save();
	    		TagPostMap::firstOrCreate(['tag_id'=>$row->id, 'post_id'=>$post_id]);
	    	}
	    	return $tagArray;
    	}
    	
    }

    private function addCategories(Request $request){
    	$categoryArray = $request->input('category');   
    	//delete previous category group
    	CategoryPostMap::where('post_id','=',$request->input('id'))->delete();	
    	$data = array(); //array to insert multiple categories in single query!

    	foreach ($categoryArray as $category) {
    		array_push($data, ['category_id'=>$category, 'post_id'=>$request->input('id')]);
    	}
    	CategoryPostMap::insert($data);
    }

    private function getPostCategories(Posts $post){
    	$array = array();
    	foreach($post->category as $category){
    		array_push($array,$category->category_id);
    	}
    	return $array;
    }

    private function getTagIds(Posts $post){
    	$array = array();
    	foreach($post->tags as $tag){
    		array_push($array,$tag->tag_id);
    	}
    	return $array;
    }
}
