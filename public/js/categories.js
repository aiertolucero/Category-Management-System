var $csrfToken = $('#csrf_token').val();
var $categoryCount = $('#category-count').val();

function appendCategory($id, $name){
	$('.category-list').append('<span class="list-group-item gallery-category" data-id="'+$id+'">'+
        							'<span class="span-editable">'+$name+'</span>'+
        							'<a class="btn btn-xs btn-danger pull-right btn-delete-category hide">'+
        								'Delete'+
        							'</a>'+
    							'</span>'
						      );
}

$('.edit-categories').on('click touchstart', function(e){
    e.preventDefault();
    e.stopPropagation();
	$('.category-controls').toggleClass('hide');
	$('.btn-delete-category').toggleClass('hide');
    $('.list-group-item').removeClass('gallery-category');
    $('.span-editable').toggleClass('editable-click');
    
    // $('.span-editable').editable('option', 'enable', true);
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
        	} else{
                $(".list-group-item[data-id='"+response.categoryId+"']").html('<span class="span-editable editable-click editable">'+newValue+'</span>'+
                                                                              '<a class="btn btn-xs btn-danger pull-right btn-delete-category">'+
                                                                                    'Delete'+
                                                                              '</a>'
                                                                            );
            }
    	}
    });
});

$('.btn-complete-update').on('click touchstart', function(){
	$('.span-editable').removeClass('editable-click');
	$('.btn-delete-category').toggleClass('hide');
	$('.category-controls').toggleClass('hide');
    $('.list-group-item').addClass('gallery-category');
})

$('.btn-add-category').on('click touchstart', function(e){
    e.preventDefault();
    e.stopPropagation();
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

                                $categoryCount++;
                                if($categoryCount == 1){
                                    $('.panel-body').remove();
                                }

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

$(document).off('click touchstart','.btn-delete-category').on('click touchstart','.btn-delete-category', function(e){
    e.preventDefault();
    e.stopPropagation();
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
                            $categoryCount -= 1;
                            if($categoryCount == 0){
                                $('.category-list').append('<div class="panel-body">'+
                                                           'No categories found...'+
                                                           '</div>'
                                                           );
                            }
                            $(".list-group-item[data-id='"+$category.attr('data-id')+"']").remove();
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