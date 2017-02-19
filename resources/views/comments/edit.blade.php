@extends('layouts.app')

@section('title')
Edit Comment
@endsection


@section('content')

<section>
	@if($comments!=null)

		<input type="hidden" name="id" value="{{$post_id}}">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<ol class="edit-comment-box">
		@foreach($comments as $comment)

				<li>
					<div>
						<span class="author-name">{{$comment->author}}</span>
						<span class="comment-content">{{$comment->comment_content}}</span>
						@if($comment->approve == 0)
							<span id="approve-{{$comment->id}}" class="approve" data-id="{{$comment->id}}" >Approve</span>
						@else
							<span id="disapprove-{{$comment->id}}" class="approve" data-id="{{$comment->id}}" >Disapprove</span>
						@endif
						<span class="delete" data-id="{{$comment->id}}" data-approve="{{$comment->approve}}" >Delete</span>
					</div>
				</li>
			

		@endforeach
		</ol>
	@endif
</section>
<script type="text/javascript">
	$(document).ready(function(){

		$(".approve").click(function(){
			var id = $(this).attr("id"); //element id
			var data = new Object();
			data.id = $(this).data("id"); //data-id
			data.token = $("input[name='_token']").val();
			data.post_id = $("input[name='id']").val();

			if(id == "approve-"+data.id){
				data.approve = "approve";
				
			}else{
				data.approve = "disapprove";
			}
			approve("/comment/approve",data);
		});

		$(".delete").click(function(){

			var data = new Object();
			data.id = $(this).data("id");
			data.token = $("input[name='_token']").val();
			data.approve = $(this).data("approve");
			data.post_id = $("input[name='id']").val();
			remove("/comment/delete",data,$(this).closest("li"));
		});
	});


	function approve(url,data){
		$.post(url,{
			_token:data.token,
			id:data.id,
			approve:data.approve,
			post_id:data.post_id
		},function(response){
			if(response == "Approved"){
				alert("Approved");
				$("#approve-"+data.id).attr("id","disapprove-"+data.id).html("Disapprove");
			}else if(response == "Disapproved"){
				alert("Disapproved");
				$("#disapprove-"+data.id).attr("id","approve-"+data.id).html("Approve");
			}else{
				alert("error");
			}
		});
	}

	function remove(url,data,element){
		$.post(url,{
			_token:data.token,
			id:data.id,
			post_id:data.post_id
		},function(response){
			if(response == "Deleted"){
				alert("Deleted");
				element.remove();
			}else{
				alert("error");
			}
		});
	}

</script>
@endsection