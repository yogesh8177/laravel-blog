@extends('layouts.app')

@section('title')
	View
@endsection

@section('content')

<article>
	<h1>{{$post->post_title}}</h1>
	@if($post!=null)
			<span class="author-name">{{$post->postmeta != null ? $post->postmeta->author->display_name : "No author"}}</span> <hr/>
			<span class="ratings">Ratings:{{$post->postmeta !=null ? $post->postmeta->ratings : ""}}</span>
		@foreach($post->category as $category)
			<span class="category"><a href="/category/{{$category->category_id}}"> {{$category->category->category_name}}</a></span>
		@endforeach
			<hr/>

			<div class="post-content">
				{!!$post->post_content!!}
			</div>

			<h3>Tags</h3>

		@foreach($tags as $tag)
			<span class="tag"><a href='/tag/{{$tag->id}}'>{{$tag->tag_name}}</a></span>
		@endforeach

		<hr/>
		<div class="comment-box">
			<h3>Comments {{$post->comment_count}}</h3>
	
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				<input type="hidden" name="id" value="{{$post->id}}">
				<ul>
					<li><input id="firstname" type="text" name="firstname" placeholder="First name"></li>
					<li><input id="lastname" type="text" name="lastname" placeholder="Last name"></li>
					<li><input id="email" type="email" name="email" placeholder="abc@xyz.com"></li>
					<li><textarea id="comment" name="comment" placeholder="Enter your comment"></textarea></li>
					<li><input type="submit" id="addcomment" value="Comment"></li>
				</ul>

		</div>
		<div class="user-comments"> 
			@foreach($post->comments as $comment)
				<div class="comment">
					<span class="comment-author">{{$comment->author}}</span><br/>
					{{$comment->comment_content}}
				</div><br>
			@endforeach
		</div>
	@else
		<p>No data</p>
	@endif
</article>
<script type="text/javascript">
	$(document).ready(function(){
		$("#addcomment").click(function(){
			var data = new Object();

			data.firstname = $("#firstname").val();
			data.lastname = $("#lastname").val();
			data.email = $("#email").val();
			data.comment = $("#comment").val();
			data.token = $("input[name='_token']").val();
			data.id = $("input[name='id']").val();

			if(data.comment == "" || data.email == "" || data.firstname == ""){
				alert("Enter required details for posting comment!");
			}else{
				postComment('/comment/create',data);
			}
			
		});
	});

	function postComment(url,data){
		$.post(url,
		{
			_token:data.token,
			id:data.id,
			author:data.firstname+" "+data.lastname,
			email:data.email,
			comment:data.comment
		},
		function(e){
			if(e == "Comment posted"){
				alert("Comment posted");
				$(".user-comments").append(data.comment);
			}else{
				alert(e);
			}
		});
		
	}
</script>	
@endsection
