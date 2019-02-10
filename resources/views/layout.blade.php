<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title></title>

	<link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('vendor/bootstrap-dialog/css/bootstrap-dialog.css') }}" rel="stylesheet">
	<link href="{{ asset('vendor/bootstrap3-editable/css/bootstrap-editable.css') }}" rel="stylesheet">
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    <input id="csrf_token" type="hidden" value="{{ csrf_token() }}" name="_token">
    <input id="category-count" type="hidden" value="{{count($categories)}}" >

	<div id="mySidenav" class="sidenav">
		<div class="col-xs-12">
			<a href="javascript:void(0)" class="btn btn-lg pull-right btn-close-sidenav" onclick="closeNav()">
				<i class="glyphicon glyphicon-remove"></i>
			</a>
		</div>
		<div class="col-xs-12">
			<div class="panel panel-default">
			  <div class="panel-heading"><h4>Categories</h4></div>
				<div class="list-group category-list">
					@forelse($categories as $c)
						<span class="list-group-item gallery-category" data-id="{{$c->id}}">
							<span class="span-editable">{{$c->name}}</span>
							<a class="btn btn-xs btn-danger pull-right btn-delete-category hide">
								<i class="glyphicon glyphicon-remove"></i>
							</a>
						</span>
					@empty
						<div class="panel-body">
						    No categories found...
						</div>
					@endforelse 
				</div>
			</div>
			@include('partials.category-controls')
		</div>
	</div>

	<div class="container">
		<div class="hidden-xs">
			<h2 class="text-center category-title">Gallery Categories</h2>
		</div>
		<div class="visible-xs">
			<div class="col-xs-2" style="margin-top: 20px;">
				<button class="btn btn-default" onclick="openNav()">
					<i class="glyphicon glyphicon-menu-hamburger"></i>
				</button>
			</div>
			<div class="col-xs-10">
				<h2 class="text-left category-title">Gallery Categories</h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-4 hidden-xs">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4>Categories</h4></div>
					<div class="list-group category-list">
						@forelse($categories as $c)
							<span class="list-group-item gallery-category" data-id="{{$c->id}}">
								<span class="span-editable">{{$c->name}}</span>
								<a class="btn btn-xs btn-danger pull-right btn-delete-category hide">
									<i class="glyphicon glyphicon-remove"></i>
								</a>
							</span>
						@empty
						  <div class="panel-body">
						    No categories found...
						  </div>
						@endforelse 
					</div>
				</div>
				@include('partials.category-controls')
			</div>
			<div class="col-sm-8 col-xs-12">
				<div class="gallery well row">
					<div class="alert alert-default" role="alert">Please select a Category...</div>
				</div>
			</div>
		</div>
	</div>

	<script
	  src="https://code.jquery.com/jquery-1.12.4.min.js"
	  integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
	  crossorigin="anonymous">
	</script>
	<script src="{{ URL::asset('vendor/bootstrap/js/bootstrap.js') }}"></script>
	<script src="{{ URL::asset('vendor/bootstrap-dialog/js/bootstrap-dialog.js') }}"></script>
	<script src="{{ URL::asset('vendor/bootstrap3-editable/js/bootstrap-editable.min.js') }}"></script>
	<script src="{{ URL::asset('vendor/masonry/masonry.pkgd.min.js') }}"></script>

	<script src="{{ URL::asset('js/nav.js') }}"></script>
	<script src="{{ URL::asset('js/categories.js') }}"></script>
	<script type="text/javascript">
		$key = '34069b277ba8944508bb693eff4ee362';
		$per_page = 30;
		$current_category = '';

		function getFlickerImages($key, $text){
			$.ajax({
				type : 'GET',
				url : 'https://api.flickr.com/services/rest/?method=flickr.photos.search&api_key='+$key+'&text='+$text+'&per_page='+$per_page+'&format=json&nojsoncallback=1',
				success : function(result){
					if(result.stat == "ok"){
						$.each(result.photos.photo, function( index, value ) {
							$('.gallery').append('<div class="col-xs-6 col-md-4">'+
												  	'<a href="#" class="thumbnail img-gallery" '+
												  		'data-secret="'+value.secret+'" data-id="'+value.id+'"  title="'+value.title+'">'+
											    		'<img src="https://farm'+value.farm+'.staticflickr.com/'+value.server+'/'+value.id+'_'+value.secret+'.jpg">'+
											      	'</a>'+
										    	'</div>'
										    );
						});
					}
				}
			});
		}

		function loadNewGallery($this){
			$('.gallery').html('');
			$('.gallery-category').removeClass('active');
			$('.category-title').text($current_category+' Photo Gallery');
			$this.toggleClass('active');
		}

		$(document).off('click', '.gallery-category').on('click', '.gallery-category', function(e){
			e.preventDefault();
			$this = $(this); 
			$current_category = $.trim($this.children('.span-editable').text());
			closeNav();
			loadNewGallery($this, $current_category);
			getFlickerImages($key, $current_category);
		});

		$(document).off('click', '.img-gallery').on('click', '.img-gallery', function(e){
			$this = $(this);
			$('.gallery').html('');
			$id = $this.attr('data-id');
			$secret = $this.attr('secret');

			$.ajax({
				type : 'GET',
				url : 'https://api.flickr.com/services/rest/?method=flickr.photos.getInfo&api_key='+$key+'&photo_id='+$id+'&secret='+$secret+'&format=json&nojsoncallback=1',
				success : function(result){
					if(result.stat == "ok"){
						$title = result.photo.title._content;
						$description = (result.photo.description._content == "") ? result.photo.description._content : "No description...";
						$('.gallery').append('<a href="#" class="btn btn-primary pull-right btn-prev btn-prev-sm hidden-xs" >'+
												'<i class="glyphicon glyphicon-chevron-left"></i>'+
											'</a>'+
											'<a href="#" class="btn btn-primary pull-right btn-prev btn-prev-xs visible-xs" >'+
												'<i class="glyphicon glyphicon-chevron-left"></i> Back to gallery'+
											'</a>'+
											 '<div class="col-xs-12 col-sm-8 img-container">'+
											    '<img style="max-width: 100%" src="https://farm'+result.photo.farm+'.staticflickr.com/'+result.photo.server+'/'+result.photo.id+'_'+result.photo.secret+'.jpg">'+
										     '</div>'+
										     '<div class="col-xs-12 col-sm-4">'+
												'<h3 class="no-pads-top no-margin-top hidden-xs">Image details</h3>'+
												'<hr>'+
												'<h4 style="word-break: break-all;">'+$title+'</h4>'+
												'<span>'+$description+'</span>'+
									    	  '</div>'
										    );
					}
				}
			});

			$(document).off('click', '.btn-prev').on('click', '.btn-prev', function(e){
				e.preventDefault();
				$('.gallery').html('');
				getFlickerImages($key, $current_category);
			})
		});
	</script>
</body>
</html>

