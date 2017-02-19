@extends('layouts.app')

@section('title')
	Category
@endsection

@section('content')
	
	<section>
		@if($rows!=null)
			<ol>
			@foreach($rows as $row)
				<li>
					<div>
						<img src="{{$row->featured_image == null ? '' : $row->featured_image}}" alt="{{$row->post_title}}" width="200px" height="100px" />
						<h1><a href="/postview/{{$row->post_id}}">{{$row->post_title}}</a></h1>					
						<span class="author-name">{{$row->display_name != null ? $row->display_name : "No author"}}</span>
						<span>{{$row->created_at}}</span>
						<hr/>
							<span class="category">
								<a href="/category/{{$row->category_id}}">{{$row->category_name}}</a>
							</span> &nbsp;

					</div>
				</li>
			@endforeach
			</ol>

			
		@else
			<p>No data</p>
		@endif

		<form method="post" action="">
				{{csrf_field()}}
				@if($page-1 >= 0)
					<button name="page" value="{{$page-1}}">Prev</button>
				@endif
				@if($rows != null)
					<button name="page" value="{{$page+1}}">Next</button>
				@endif
		</form>

	</section>
@endsection