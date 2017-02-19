@extends('layouts.app')

@section('title')
Create Category
@endsection

@section('content')


<section>
	<form method="post" action="/new/create">
		{{csrf_field()}}
		<ol>
			<li><input type="text" name="category" placeholder="Category name"></li>
			<li><input type="text" name="description" placeholder="Category description"></li>
			<li><input type="submit" value="Create"></li>
		</ol>
	</form>
</section>


@endsection