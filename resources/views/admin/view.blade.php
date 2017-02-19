@extends('layouts.app')

@section('title')
Admin View
@endsection

@section('content')


<section>
@if($posts!=null)

<ol>
	@foreach($posts as $post)

		<li>
			<h1>{{$post->post_title}}</h1>
			<span class="author-name">{{$post->postmeta != null ? $post->postmeta->author->display_name : "Author"}}</span>
			<span>{{$post->created_at}}</span><hr/>
			@foreach($post->category as $category)
				<span class="category">{{$category->category->category_name}}</span>
			@endforeach
			<span class="ratings">Ratings: {{$post->postmeta != null ? $post->postmeta->ratings : "0"}}</span>
			<span><a href="/post/edit/{{$post->id}}/{{$post->slug}}">edit</a></span>
		</li>

	@endforeach
</ol>

<form method="post" action="/admin/view">
	@include("partial.paginate")
</form>

@endif
</section>

@endsection