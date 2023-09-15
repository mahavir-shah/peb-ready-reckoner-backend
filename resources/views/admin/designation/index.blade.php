@include('admin.include.header')

 <style>
	.toast-success {
  		background-color: black;
	}
	.toast-top-center {
	  	top: 1em;
	}
	.close_filter_menu{
		position: absolute;
		right: 10px;
		top: 5px;
	}
	table#DataTables_Table_0 tbody tr td:nth-of-type(2) {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>

<div class="inner-table-wrapper user-listing">
	<div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h4 class="mt-4"><i class="fa fa-hmd-users-icon"></i> <span class="title-text"><b>Designation </b></span><span id="total-title-count" class="title-count"> <!-- (</span><span id="title-count" class="title-count"></span><span class="title-count"> total)  --></span></h4>
            <button class="add-button admin-btn btn btn-secondary" style="width: 185px; height: 40px; font-size: 16px;">Create Designation</button>
        </div>
		<div class="card mt-4">
			<div class="card-body">
				<div class="table-responsive">
					<div class="-page-row filter-datatable">
						<div class="col_filed">
							<select name="column_name" id="column_name" class="form-control" multiple>
								<option value="0" selected>Title</option>
								<option value="1" selected>Actions</option>
							</select>
						</div>
					</div>
					<table class="customtable users table table-bordered table-striped sample_data table-responsive-lg">
						<thead>
							<tr>
								<th class="mwidth100">Title</th>
								<th style="min-width: 132px;">Actions</th>
							</tr>
						</thead>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade update-credentials" id="designation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered" style="display: flex; align-items: center; width: 420px;" role="document">
	    <div class="modal-content">
	      	<div class="modal-header" style="margin: 0 24px;">
	        	<h5 class="modal-title" id="exampleModalLabel">Add Designation</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>                                                                   
	      	</div>
		    <div class="modal-body">
		      	<form method="post" id="designation-form">
		  			@csrf
		      		<div class="row">
				        <label>Designation</label>
				        <input class="form-control get-organization" name="designation_title" >
				 	</div>
		      		<div class="row mt-4">
		      			<div class="col-md-12">
						  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		        			<button class="btn btn-primary save-info" style="border: 0;" type="submit" disabled>Add</button>
		        		</div>
		      		</div>
		    	</form>
		    </div>
  		</div>
	</div>
</div>
@include('admin.include.footer')
<script type="text/javascript" language="javascript">

$(document).ready(function(){
	toastr.options= {
	    "positionClass": "toast-top-center",
	    "timeOut": 5000,
	    "background-color":"black"
	};

	var dataTable = $('.sample_data').DataTable({
		"serverSide" : true,
		"language": {
            searchPlaceholder: "Search",
            "emptyTable": "No data available in the table",
        },
		"ordering": false,
		"order": [],
		"ajax" : {
            type:"POST",
			url:'{{route("admin.designationData")}}', 
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        },
		dom: 'lBfrtip',
		serverSide: true,
		dom: '<"head_filter"<"search_btn"f><"export_btn"B>>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
		 buttons: [
			{
				extend: 'csv',
				text: 'Export',
				exportOptions: {
					modifier: {
						search: 'applied',
						order: 'applied'
					}
				}
			}
		],
	});

	$('#column_name').selectpicker({
		selectedTextFormat: 'static',
		title: 'Columns'
	});

	$('.filter-option-inner').prepend('<i class="fa fa-column-icon column-icon pr-2"></i>');

	$.fn.DataTable.ext.pager.numbers_length = 5;

	$('.head_filter').append($('.filter-datatable'));

	$(document).on('change','#column_name',function(e) {
		var all_column = ["0", "1"];
		var remove_column = [];

		remove_column = $('#column_name').prop('selected',false).val();

		var remaining_column = all_column.filter(function(obj) { return remove_column.indexOf(obj) == -1; });

		dataTable.columns(remove_column).visible(true);
		dataTable.columns(remaining_column).visible(false);
	});


	$(document).on('click', '.add-button', function() {
		$('#designation-form').trigger('reset');
		$('#designation').modal('show');
	});

	$(document).on('keyup', '.get-organization', function() {
		if($(this).val() != ''){
			$('.save-info').prop('disabled',false);
		}else{
			$('.save-info').prop('disabled',true);
		}
	});

	$(document).on('click', '.designation-delete', function() {
		$this=$(this);
		$.ajax({
              type: 'POST',
              url: "{{ route('admin.designationDelete') }}",
              data: {
                  'id': $(this).attr('rel'),
                  "_token": "{{ csrf_token() }}"
              },
              dataType: 'json',
              success: function(data) {
                $this.closest('tr').remove();
				toastr.success('Designation Deleted Successfully');
              }
          });
	});

	$(document).on('submit', '#designation-form', function(event) {
	    event.preventDefault();
	    $.ajax({
	        type:'POST',
	        url:"{{ route('admin.designationAdd') }}",
			data:$('#designation-form').serialize(),
			dataType: 'json',
          	success:function(data){
              	$('#designation').modal('hide');
              	dataTable.draw();
				toastr.success('Designation Name Added Successfully');
          	}
	    });
	});

	$(document).on('click', '.designation_edit', function() {
		$(this).addClass('d-none');
		$(this).parents('tr').find('td .designation_update').removeClass('d-none');
		$(this).parents('tr').find('td .designation_name_inp').addClass('form-control').removeClass('border-0 bg-transparent').prop('readonly',false);
	});

	$(document).on('click', '.designation_update', function() {
		$this= $(this);
		$.ajax({
	        type:'POST',
	        url:"{{ route('admin.designationUpdate') }}",
			data:{
                  'id': $(this).attr('rel'),
				  'designation_title': $(this).parents('tr').find('td .designation_name_inp').val(),
                  "_token": "{{ csrf_token() }}"
              },
			dataType: 'json',
          	success:function(data){
				$this.addClass('d-none');
				$this.parents('tr').find('td .designation_edit').removeClass('d-none');
				$this.parents('tr').find('td .designation_name_inp').removeClass('form-control').addClass('border-0 bg-transparent').prop('readonly',true);
				toastr.success('Designation Updated Successfully');
          	}
	    });
	});
	
});
</script>