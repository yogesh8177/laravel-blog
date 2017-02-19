@extends('layouts.app')

@section('title')
	Tags
@endsection

@section('content')

<article>
	<ol>
	@if($posts != null)
	@foreach($posts as $row)
		<li>
			<div class="tile">
				<img src="{{$row->featured_image !=null ? $row->featured_image : ''}}" alt="{{$row->post_title}}" width="200px" height="100px" />
				<div>
					<h1>{{$row->post_title}}</h1>
					<span class="author-name">{{$row->display_name}}</span>
					<span>{{$row->created_at}}</span>
					<span class="tag"><a href="/tag/{{$row->tag_id}}">{{$row->tag_name}}</a></span>
				</div>
			</div>
		</li>
	@endforeach
	@endif
	</ol>

<form method="post" action="">
	{{csrf_field()}}
	@if($page-1 >= 0)
		<button name="page" value="{{$page-1}}">Prev</button>
	@endif
	@if($posts != null)
		<button name="page" value="{{$page+1}}">Next</button>
	@endif
</form>

</article>

@endsection