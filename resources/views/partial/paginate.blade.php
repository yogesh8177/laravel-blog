

	{{csrf_field()}}
	@if($page-1 >= 0)
		<button name="page" value="{{$page-1}}">Prev</button>
	@endif
	@if(!$posts->isEmpty())
		<button name="page" value="{{$page+1}}">Next</button>
	@endif


