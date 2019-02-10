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
						<span class="list-group-item" data-id="{{$c->id}}">
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

			<hr>
			<div class="category-controls">
				<div class="col-xs-6 text-center">
					<button class="btn btn-success col-xs-12 btn-add-category">
						<i class="glyphicon glyphicon-plus"></i>
					</button>
				</div>
				<div class="col-xs-6 text-center">
					<button class="btn btn-primary edit-categories col-xs-12">
						<i class="glyphicon glyphicon-edit"></i>
					</button>
				</div>
			</div>

			<div class="col-xs-12 text-center category-controls hide">
				<button class="btn btn-success btn-complete-update col-xs-12">
					<i class="glyphicon glyphicon-check"></i>
				</button>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="hidden-xs">
			<h2 class="text-center">Gallery Categories</h2>
		</div>
		<div class="visible-xs">
			<div class="col-xs-2" style="margin-top: 20px;">
				<button class="btn btn-default" onclick="openNav()">
					<i class="glyphicon glyphicon-menu-hamburger"></i>
				</button>
			</div>
			<div class="col-xs-10">
				<h2 class="text-left">Gallery Categories</h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-sm-4 hidden-xs">
				<div class="panel panel-default">
				  <div class="panel-heading"><h4>Categories</h4></div>
					<div class="list-group category-list">
						@forelse($categories as $c)
							<span class="list-group-item" data-id="{{$c->id}}">
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

				<hr>
				<div class="category-controls">
					<div class="col-xs-6 text-center">
						<button class="btn btn-success col-xs-12 btn-add-category">
							<i class="glyphicon glyphicon-plus"></i>
						</button>
					</div>
					<div class="col-xs-6 text-center">
						<button class="btn btn-primary edit-categories col-xs-12">
							<i class="glyphicon glyphicon-edit"></i>
						</button>
					</div>
				</div>

				<div class="col-xs-12 text-center category-controls hide">
					<button class="btn btn-success btn-complete-update col-xs-12">
						<i class="glyphicon glyphicon-check"></i>
					</button>
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
	<script type="text/javascript">
		var $csrfToken = $('#csrf_token').val();
		function openNav() {
		  document.getElementById("mySidenav").style.width = "100vw";
		}

		function closeNav() {
		  document.getElementById("mySidenav").style.width = "0";
		}

		function appendCategory($id, $name){
			$('.category-list').append('<span class="list-group-item" data-id="'+$id+'">'+
									'<span class="span-editable">'+$name+'</span>'+
									'<a class="btn btn-xs btn-danger pull-right btn-delete-category hide">'+
										'<i class="glyphicon glyphicon-remove"></i>'+
									'</a>'+
									'</span>'
								);
		}

		$('.edit-categories').on('click', function(){
			$('.category-controls').toggleClass('hide');
			$('.btn-delete-category').toggleClass('hide');

			$('.span-editable').editable('option', 'disabled', false);
			$('.span-editable').editable({
				ajaxOptions: {
				    type: 'PUT',
				    dataType: 'json'
				},
		        url: '/Category',
		        pk: 1,
		        mode: 'inline',
		        validate: function(value) {
				    if($.trim(value) == '') {
				        return 'Name is required';
				    }
				},
		        params: function(params) {
		              params._token = $csrfToken;
		              params.categoryId = $(this).parent('.list-group-item').attr('data-id');
		              params.name  = params.value;
		              return params;
		        },
		        success: function(response, newValue) {
		        	if(!response.isSuccess){
		        		return response.errorMsg['name'][0];
		        	}
		    	}
		    });
		});

		$('.btn-complete-update').on('click', function(){
			$('.span-editable').editable('option', 'disabled', true);
			$('.btn-delete-category').toggleClass('hide');
			$('.category-controls').toggleClass('hide');
		})

		$('.btn-add-category').on('click', function(){
			BootstrapDialog.show({
	            title: 'Add New Category',
	            type: BootstrapDialog.TYPE_DEFAULT,
	            message: $('<input class="form-control" placeholder="Enter Category Name..." id="input-category"></input><p class="text-danger p-error"></p>'),
	            buttons: [{
	                label: 'Save',
	                cssClass: 'btn-success',
	                hotkey: 13, // Enter.
	                action: function(dialogRef) {
	                	$categoryName = $('#input-category').val();
	                	if($categoryName == ''){
	                		$('.p-error').text('Category name is required.');
	                	} else{
	                		$.ajax({
	                			type : 'POST',
	                			url : '/Category',
	                			data : { name : $categoryName, _token : $csrfToken },
	                			success : function(res){
	                				if(res.isSuccess){
	                					appendCategory(res.id, res.name);
	                    				dialogRef.close();
	                				} else{
	                					$('.p-error').text(res.errorMsg['name'][0]);
	                				}
	                			}
	                		})
	                	}
	                }
	            },
	            {
	            	label: 'Cancel',
	                cssClass: 'btn-default',
	                action: function(dialogRef){
	                    dialogRef.close();
	                }
	            }]
	        });
		});
	    
	    $(document).on('click','.btn-delete-category', function(){
	    	$this = $(this);

			BootstrapDialog.show({
	            title: 'Delete Category',
	            type: BootstrapDialog.TYPE_DEFAULT,
	            message: 'Are you sure you want to delete this category?',
	            buttons: [{
	                label: 'Delete',
	                cssClass: 'btn-danger',
	                action: function(dialogRef) {
						$category = $this.parent('.list-group-item');

                		$.ajax({
                			type : 'Delete',
                			url : '/Category',
                			data : { id : $category.attr('data-id'), _token : $csrfToken },
                			success : function(response){
                				if(response.isSuccess){
                					$category.remove();
                    				dialogRef.close();
                				}
                			}
                		})
	                }
	            },
	            {
	            	label: 'Cancel',
	                cssClass: 'btn-default',
	                action: function(dialogRef){
	                    dialogRef.close();
	                }
	            }]
	        });
	    });
	</script>
</body>
</html>