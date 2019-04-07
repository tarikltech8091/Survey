@extends('layout.master')
@section('content')
<!--error message*******************************************-->
<div class="row">
	<div class="col-md-6">
		@if($errors->count() > 0 )

		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<h6>The following errors have occurred:</h6>
			<ul>
				@foreach( $errors->all() as $message )
				<li>{{ $message }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		@if(Session::has('message'))
		<div class="alert alert-success" role="alert">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{ Session::get('message') }}
		</div> 
		@endif

		@if(Session::has('errormessage'))
		<div class="alert alert-danger" role="alert">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{ Session::get('errormessage') }}
		</div>
		@endif

	</div>
</div>
<!--end of error message*************************************-->

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				Category Entry
				<div class="panel-tools">
					<a class="btn btn-xs btn-link panel-collapse collapses" href="#"> </a>
					<a class="btn btn-xs btn-link panel-close" href="#"> <i class="fa fa-times"></i> </a>
				</div>
			</div>
			<div class="panel-body">
				<form method="post" action="{{url('/inventory/category/settings')}}">
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div class="table-responsive"><!--end of Stockes table-->
						<table class="table stocks_entry table-hover table-bordered table-striped nopadding" >
							<thead>
								<tr>
									<th>#</th>	
									<th>Category Name</th>
									<th>Item Unit Type</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody class="category_entry_body">

								@if(!empty($category_list) && count($category_list)>0)
								@foreach($category_list as $key => $list)

								<tr>
									<td>{{$key+1}}</td>
									<td>
										<input type="text" class="form-control item_category_name" name="item_category_name" value="{{isset($list->item_category_name)? $list->item_category_name :''}}" disabled="disabled" id="item_category_name_{{$key}}" required="" />
									</td>

									<td>
										<select name="item_quantity_unit" class="form-control item_quantity_unit" id="item_quantity_unit_{{$key}}" disabled="disabled" required="">
											<option value="">Select Quantity Unit</option>
											<option {{($list->item_quantity_unit == 'piece')? 'selected' :''}} value="piece">Piece</option>
											<option {{($list->item_quantity_unit == 'kg')? 'selected' :''}} value="kg">KG</option>
										</select>
									</td>

									<td>
										<a id="cat_edit_{{$key}}" class="cat_edit btn btn-teal tooltips" name="edit" data-toggle1="tooltip" title="Edit Data" data-original-title="Edit Data" value="Edit"><i class="fa fa-edit" aria-hidden="true"></i></a>

										<a data-id="{{$list->item_category_id}}" data-rid="{{$key}}" class="category_update btn btn-success tooltips hidden" data-toggle1="tooltip" title="Update Data" data-original-title="Update Data" id="cat_update_{{$key}}" ><i class="fa fa-check" aria-hidden="true"></i></a>

										<a class="btn btn-danger tooltips category_delete" data-toggle1="tooltip" title="Clear Data" data-original-title="Clear Data" data-id="{{$list->item_category_id}}"><i class="fa fa-times" aria-hidden="true"></i></a>

									</td>
								</tr>
								@endforeach
								@else
								<tr>
									<td colspan="4" class="text-center">No Data Available</td>
								</tr>
								@endif
							</tbody>
						</table>
					</div><!--end of Category table-->

					<input type="hidden" class="category_entry_field" name="category_entry_field" value="1">

					<div class="row">
						<div class="col-md-6 form-group pull-left">
							<button class="btn btn-default add_line_category">Add line</button>
						</div>

					</div>
					{{$category_pagination ? $category_pagination:''}}
				</form>
			</div>
		</div>

	</div>
</div>

@stop
@section('JScript')
<script>

	/*##########################
	# Category entry Field Add
	##########################*/
	jQuery(function(){

	    var max_fields_category_entry = 1; //maximum input boxes allowed
	   
	    var wrapper_category_entry  = jQuery(".category_entry_body");
	   
	    var category_entry_add_btn  = jQuery(".add_line_category");
	    
	    var site_url = jQuery('.site_url').val();
	    
	    var x = 1; //initlal text box count



	    jQuery(category_entry_add_btn).click(function(e){ //on add input button click
	        e.preventDefault();
	        x = jQuery('.category_entry_field').val();

	        if(x <= max_fields_category_entry){ //max input box allowed
	            x++; //text box increment

	            var request_url =  site_url+'/ajax/category/settings';

	            $(this).addClass('hidden');

	            jQuery.ajax({
	                  url: request_url,
	                  type: "get",
	                  success:function(data){
	                    jQuery(wrapper_category_entry).append(data);
	                    jQuery('.category_entry_field').val(x);
	                  }
	            });

	             //add input box
	        }
	    });

	    // $(wrapper_category_entry).on("click",".category_entry_remove_btn", function(e){ //user click on remove text
	    //     e.preventDefault(); 

	    //   var row = $(this).data('rowid');

	    //     $('.category_entry_group').remove();
	    //      x--;

	    //     jQuery('.category_entry_field').val(x);

	    // });
	   
	});


	/********************************************
	## CategoryEdit
	*********************************************/

	    jQuery(function(){
	         $('.category_entry_body').on('click','.cat_edit',function(){
	            var cat_id=$(this).attr('id').split("_")[2];
	            $("#item_category_name_"+cat_id).prop('disabled',false);
	            $("#item_quantity_unit_"+cat_id).prop('disabled',false);
	            $(this).addClass('hidden');
	            $("#cat_update_"+cat_id).removeClass('hidden');
	        });

	    });


	/********************************************
	## CategoryUpdate 
	*********************************************/

	    jQuery(function(){
	        jQuery('.category_update').click(function(){

	            var category_id = jQuery(this).data('id');
	            var row_id = jQuery(this).data('rid');
	            var site_url = jQuery('.site_url').val();
	            var item_category_name = jQuery('#item_category_name_'+row_id).val();
	            var item_quantity_unit = jQuery('#item_quantity_unit_'+row_id).val();

	            if(item_category_name.length !=0 && item_quantity_unit.length !=0){

	               var request_url=site_url+'/ajax/category/settings/update/'+category_id+'/'+item_category_name+'/'+item_quantity_unit;
	                jQuery.ajax({
	                    url: request_url,
	                    type: 'get',
	                    success:function(data){
	                        window.location.href=site_url+'/inventory/category/settings';

	                    }
	                }); 

	            }else alert("Category or Unit Type Not Empty.")
	            

	        });
	    });

	/********************************************
	## CategoryDelete 
	*********************************************/

	    jQuery(function(){
	         jQuery('.category_delete').click(function(){
	            var r = confirm("Are you want to Delete Item Category??");

	            var category_id = jQuery(this).data('id');
	            var site_url = jQuery('.site_url').val();
	            var request_url=site_url+'/ajax/category/settings/delete/'+category_id;
	            jQuery.ajax({
	                url: request_url,
	                type: 'get',
	                success:function(data){
	                    if (r == true) {
	                        window.location.href=site_url+'/inventory/category/settings';
	                    } else {
	                        return false;
	                    } 

	                }
	            });

	        });
	    });

	/********************************************
	## ItemEdit
	*********************************************/

	    jQuery(function(){
	        $('.item_entry_body').on('click','.item_edit',function(){
	            var item_id=$(this).attr('id').split("_")[2];
	            $("#item_name_"+item_id).prop('disabled',false);
	            $("#item_category_id_"+item_id).prop('disabled',false);
	            $("#item_quantity_unit_"+item_id).prop('disabled',false);
	            $("#item_description_"+item_id).prop('disabled',false);
	            $(this).addClass('hidden');
	            $("#item_update_"+item_id).removeClass('hidden');
	        });

	    });

	/*##########################
	# Item entry Field Add
	##########################*/

	jQuery(function(){

	    var max_fields_item_entry = 1; //maximum input boxes allowed
	   
	    var item_entry  = jQuery(".item_entry_body");
	   
	    var item_entry_add_btn  = jQuery(".add_line_item");
	    
	    var site_url = jQuery('.site_url').val();
	    
	    var x = 1; //initlal text box count

	    jQuery(item_entry_add_btn).click(function(e){ //on add input button click
	        e.preventDefault();
	        x = jQuery('.item_entry_field').val();

	        if(x <= max_fields_item_entry){ //max input box allowed
	            x++; //text box increment

	            var request_url =  site_url+'/ajax/item/settings';
	            $(this).addClass('hidden');


	            jQuery.ajax({
	                  url: request_url,
	                  type: "get",
	                  success:function(data){
	                    jQuery(item_entry).append(data);
	                    jQuery('.item_entry_field').val(x);
	                  }
	            });
	        }
	    });
	    
	});

	/********************************************
	## ItemUpdate 
	*********************************************/

	    jQuery(function(){
	        jQuery('.item_update').click(function(){

	            var site_url = jQuery('.site_url').val();
	            var item_id = jQuery(this).data('id');
	            var row_id = jQuery(this).data('rid');
	            var item_name = jQuery('#item_name_'+row_id).val();
	            var item_category_id = jQuery('#item_category_id_'+row_id).val();
	            var item_description = jQuery('#item_description_'+row_id).val();
	            var item_quantity_unit = jQuery('#item_quantity_unit_'+row_id).val();

	            if(item_name.length !=0 && item_category_id.length !=0 && item_description.length !=0){
	                var request_url=site_url+'/ajax/item/settings/update/'+item_id+'/'+item_name+'/'+item_category_id+'/'+item_quantity_unit+'/'+item_description;
	            
	                jQuery.ajax({
	                    url: request_url,
	                    type: 'get',
	                    success:function(data){
	                        window.location.href=site_url+'/inventory/item/settings';

	                    }
	                });
	            }else alert("Field not empty");

	            

	        });
	    });

	/********************************************
	## ItemDelete 
	*********************************************/

	    jQuery(function(){
	        jQuery('.item_delete').click(function(){

	            var r = confirm("Are you want to Delete Item??");

	            var item_id = jQuery(this).data('iid');
	            var site_url = jQuery('.site_url').val();
	            var request_url=site_url+'/ajax/item/settings/delete/'+item_id;
	            jQuery.ajax({
	                url: request_url,
	                type: 'get',
	                success:function(data){

	                    if (r == true) {
	                        window.location.href=site_url+'/inventory/item/settings';

	                    } else {
	                        return false;
	                    } 


	                }
	            });


	        });
	    });

	/*##########################################
	# Item List By ajax
	############################################
	*/

	jQuery(function(){

	    jQuery('.stock_entry_body').on('change','.category_list', function(){

	        var id = jQuery(this).data('id');

	        var item_category_id = jQuery(this).val();
	        var site_url = jQuery('.site_url').val();
	        var request_url = site_url+'/ajax/category/list/'+item_category_id+'/'+id;


	            jQuery.ajax({
	                url: request_url,
	                type: 'get',
	                success:function(data){
	                    jQuery('#item_details_id_'+id).html(data);
	                }
	            });

	    });
	});


</script>