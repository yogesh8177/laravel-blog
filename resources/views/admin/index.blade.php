@extends('layouts.app')

@section('title')
Title
@endsection

@section('content')


<section>
	<ul>
		<li><a href="/post/create">Create Posts</a></li>
		<li><a href="/admin/view">View Posts</a></li>
		<li><a href="/new/create/">Create category</a></li>
		<li><a href="/author/create">Create author</a></li>
	</ul>
</section>

@endsection