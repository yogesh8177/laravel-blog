@extends('layouts.app')

@section('title')
	Search
@endsection

@section('content')



<section>
 		<h1>Search {{$key}}</h1>
 	<form method="get" action="/search">
		<input type="text" name="key">
		<input type="submit" value="Search">
	</form>
	<ol>
	@if($posts!=null)
		@foreach($posts as $post)
			<li><a href='/postview/{{$post->id}}/{{$post->slug}}'>{{$post->post_title}}</a>, Ratings:{{$post->postmeta !=null ? $post->postmeta->ratings : ""}}, comment: {{$post->comment_count}}
			@if(Auth::check())
				<a href="/post/edit/{{$post->id}}">[ edit ]</a>
			@endif
			</li>
		@endforeach
	@endif
	</ol>
@if($posts != null)
<form method="post" action="">
	{{csrf_field()}}
	@if($page-1 >= 0)
		<button name="page" value="{{$page-1}}">Prev</button>
	@endif
	@if(!$posts->isEmpty())
		<button name="page" value="{{$page+1}}">Next</button>
	@endif
</form>
@endif

</section>
@endsection