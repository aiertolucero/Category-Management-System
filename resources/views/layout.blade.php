<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Category Management System</title>

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
									Delete
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
	<script src="{{ URL::asset('js/gallery.js') }}"></script>
</body>
</html>

