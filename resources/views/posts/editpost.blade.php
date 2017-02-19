@section('title')
	Edit Post
@endsection
@extends('layouts.app')

@section('content')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<section>
<h1>Edit</h1>

	@if($post!=null)

		<form method="post" action="/post/edit">
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="hidden" name="id" value="{{$post->id}}">
			<ul>
				<li><a href="/post/postmeta/{{$post->id}}">Set featured image</a></li>
				<li><input type="text" name="post_title" value="{{$post->post_title}}"></li>
				<li><textarea name="post_content" placeholder="Enter your post...">{{$post->post_content}} </textarea></li>
				<li><input type="text" name="slug" value="{{$post->slug}}"></li>
				<li><select name="post_type">
					<option value="{{$post->post_type}}">Select</option>
					<option value="draft" @if($post->post_type == 'draft') selected='selected' @endif>Draft</option>
					<option value="publish" @if($post->post_type == 'publish') selected='selected' @endif>Publish</option>
				</select></li>
				<li>
					<div class="category-box">
					@if($categories!=null)
						<ol>
							@foreach($categories as $c) 
								
							<li>{{$c->category_name}}
							<input type="checkbox" name="category[]" @foreach($post_category as $category) @if($c->id==$category) checked='checked' @endif @endforeach value="{{$c->id}}"  />
							</li>
							@endforeach
						</ol>
					@endif
					</div>
				</li>
				<li><a href="/comment/edit/{{$post->id}}">Edit Comments {{$post->comment_count}}</a></li>
				<li>
					<input type="text" name="tag" placeholder="Add tags"><br/>
					<label>Remove tags: </label>
					@foreach($tags as $tag)
						<label><a class="tag" href='#' data-tag="{{$tag->id}}">{{$tag->tag_name}}</a></label>
					@endforeach
				</li>
				<li><input type="submit" value="Update"></li>
			</ul>
			
			
		</form>
		<form method="post" action="/post/delete">
			<input type="hidden" name="_token" value="{{csrf_token()}}">
			<input type="hidden" name="id" value="{{$post->id}}">
			<input type="submit" value="Delete" name="Delete">
		</form>
	@else
		<p>No data</p>
	@endif

	<script type="text/javascript">
		$(document).ready(function(){
			$('.tag').click(function(){
				var token = $("input[name='_token']").val();
				var tag_id = $(this).data("tag");
				var post_id = $("input[name='id']").val();

				deleteTag("http://localhost:8000/post/tags/delete",token,tag_id,post_id,this);
			});
		});

		function deleteTag(url, token, tag_id, post_id, tag){

			$.post( url, 
				{ _token: token, post_id: post_id, tag_id: tag_id },
				function(data){
					if(data=="Tag deleted") 
						tag.remove();
					alert(data);
				});		
			
		}
	</script>
</section>
@endsection