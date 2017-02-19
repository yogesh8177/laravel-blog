@extends('layouts.app')

@section('title')
	Create Post
@endsection

@section('content')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>tinymce.init({ selector:'textarea' });</script>

<section>
	<h1>Create Post</h1>

	
	<form method="post" action="/post/create">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<ul class="form">
			<li><input type="text" name="post_title" placeholder="Title"></li>
			<li><textarea name="post_content" placeholder="Enter your post..."> </textarea></li>
			<li><input type="text" name="slug" placeholder="Slug"></li>
			<li>Post type <select name="post_type">
				<option>Select</option>
				<option value="draft">Draft</option>
				<option value="publish">Publish</option>
			</select></li>
			<li>Author 
				<select name="author">
					<option>Select</option>
					@foreach($authors as $author)
						<option value="{{$author->id}}">{{$author->display_name}}</option>
					@endforeach
				</select>
			</li>
			<li>
				Categories: <br/>
				<div class="category-box">
				<ol>
				@if($categories!=null)
					
						
						@foreach($categories as $c)
							<li>{{$c->category_name}}<input type="checkbox" name="category[]" value="{{$c->id}}"></li>
						@endforeach
					
				@endif
				</ol>
				</div>
			</li>
			<li><input type="text" name="tag" placeholder="Enter tags"></li>
			<li><input type="submit" value="Create"></li>
		</ul>
		
		
	</form>
</section>
@endsection