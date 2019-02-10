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

$(document).off('click touchstart', '.gallery-category').on('click touchstart', '.gallery-category', function(e){
	e.preventDefault();
	$this = $(this); 
	$current_category = $.trim($this.children('.span-editable').text());
	closeNav();
	loadNewGallery($this, $current_category);
	getFlickerImages($key, $current_category);
});

$(document).off('click touchstart', '.img-gallery').on('click touchstart', '.img-gallery', function(e){
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

	$(document).off('click touchstart', '.btn-prev').on('click touchstart', '.btn-prev', function(e){
		e.preventDefault();
		$('.gallery').html('');
		getFlickerImages($key, $current_category);
	})
});