@extends('layouts.app')

@section('title')
	Create postmeta
@endsection

@section('content')


<section>
	<h1>Set featured image </h1>
	<form method="post" action="/post/postmeta/edit" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		<input type="hidden" name="id" value="{{$id}}">
		<input type="hidden" name="postmeta-id" value="{{$postmeta->id}}">

		<ul class="form">
			<li><input type="file" name="featured_image" accept="image/*"></li>
			<li><input type="submit" name="Upload"></li>
		</ul>
	</form>

	<ul class="image-picker">
		<li class="active-image" data-name="{{basename($postmeta->featured_image)}}">
			<img src="{{URL::to('/').$postmeta->featured_image}}" alt="no" width="200" height="100"  /><br/>
			<span>Active Image</span>
		</li>
		@if($files != null)
		@foreach($files as $file)
			<li class="images">
				<span class="delete-image" data-name="{{$file->getFilename()}}" title="Delete this image">X</span>
				<img src="{{URL::to('/').'/Images/'.$id.'/'.$file->getFilename()}}" alt="choice" width="200" height="100" />
				<span class="select-image" data-name="{{$file->getFilename()}}">Select Image</span>
			</li>
		@endforeach
		@endif
	</ul>
	<div>
		Author:
		<select name="author">
			<option>Select</option>
			@foreach($authors as $author)
				<option value="{{$author->id}}" {{$postmeta->author_id == $author->id ? "selected=selected" : ''}}>
					{{$author->display_name}}
				</option>
			@endforeach
		</select><br/><br/>
		<button id="author-update">Update</button>
	</div><hr/>
	
</section>
<script type="text/javascript">
	$(document).ready(function(){
		var token = $("input[name='_token']").val();

		$(".delete-image").click(function(){
			var data = new Object();
			data.token = token;
			data.filename = $(this).data('name');
			data.id = $("input[name='id']").val();
			data.active = $(".active-image").data("name");

			deleteFeaturedImage('/post/postmeta/featuredimage/remove',data,this);
		});

		$(".select-image").click(function(){
			var data = new Object();
			data.token = token;
			data.filename = $(this).data('name');
			data.id = $("input[name='id']").val();

			updateFeaturedImage('/post/postmeta/featuredimage/update',data);
		});

		$("#author-update").click(function(){
			var data = new Object();
			data.token = token;
			data.postmeta_id = $("input[name='postmeta-id']").val();
			data.author_id = $("select[name='author']").val();

			updateAuthor("/postmeta/author/update",data);
		});

	});

	function deleteFeaturedImage(url,data,image){
		$.post(url,{
			_token:data.token,
			id:data.id,
			filename:data.filename
		},function(response){
			if(response == "Image deleted"){
				if(data.active == data.filename){
					$(".active-image").html("<img src='' alt='No image selected' width='200px' height='100px' />");	
				}
				image.closest('.images').remove();
			}else{
				alert('error');
			}
		});
	}

	function updateFeaturedImage(url,data){
		$.post(url,{
			_token:data.token,
			id:data.id,
			filename:data.filename
		},function(response){
			if(response == "Updated"){
				$(".active-image").html("<img src='/Images/"+data.id+"/"+data.filename+"' alt='No image selected' width='200px' height='100px'/><br/><span>Active Image</span>");
			}
			alert("Image updated");
		});
	}

	function updateAuthor(url,data){
		$.post(url,{
			_token:data.token,
			author_id:data.author_id,
			postmeta_id:data.postmeta_id
		},function(response){
			if(response == "Updated"){
				alert("Author updated");
			}else{
				alert("Error");
			}
		});
	}

</script>

@endsection