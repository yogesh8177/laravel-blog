@extends('layouts.app')

@section('title')
	Posts
@endsection

@section('content')

<article>
	<h1>Posts</h1>

	<ol>
	@foreach($posts as $post)
		<li>
			<div class="tile">
				<img src="{{$post->postmeta != null ? $post->postmeta->featured_image : ''}}" alt="{{$post->post_title}}" width="200px" height="100px" /><br/>
				<h1><a href='/postview/{{$post->id}}/{{$post->post_title}}'>{{$post->post_title}}</a></h1>
				<div> 
					<span class="author-name">{{$post->postmeta != null ? $post->postmeta->author->display_name : ""}}</span>
					<span>{{$post->created_at}}</span>
					<hr/>
					@foreach($post->category as $category)
						<span class="category">
						<a href='/category/{{$category->category_id}}'>{{$category->category->category_name}}</a></span>
					@endforeach
					<span class="ratings">Ratings:{{$post->postmeta != null ? $post->postmeta->ratings : "0"}}</span> comment: {{$post->comment_count == "" ? 0 : $post->comment_count}}</span>
					@if(Auth::check())
					<a href="/post/edit/{{$post->id}}">edit</a>
					@endif
				</div>
			</div>
			<hr/>
		</li>

	@endforeach
	</ol>

<form method="post" action="">
	{{csrf_field()}}
	@if($page-1 >= 0)
		<button name="page" value="{{$page-1}}">Prev</button>
	@endif
	@if(!$posts->isEmpty())
		<button name="page" value="{{$page+1}}">Next</button>
	@endif
</form>

</article>	
@endsection