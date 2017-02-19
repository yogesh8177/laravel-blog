@extends('layouts.app')

@section('title')
Create Author
@endsection

@section('content')


<section>

<h1>Create Author</h1>

<form method="post" action="/author/create">
	{{csrf_field()}}
	
	<ul>
		<li><input type="text" name="firstname" placeholder="First name"></li>
		<li><input type="text" name="lastname" placeholder="Last name"></li>
		<li><input type="text" name="displayname" placeholder="Display name"></li>
		<li><input type="email" name="email" placeholder="Email"></li>
		<li><textarea name="description" placeholder="Author description"></textarea></li>
		<li><input type="text" name="mobile" placeholder="mobile">
		<li><input type="url" name="url" placeholder="Url">
		<li><input type="submit" value="Create"></li>
	</ul>

</form>
</section>

@endsection