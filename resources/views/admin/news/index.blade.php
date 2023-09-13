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
            <h4 class="mt-4"><i class="fa fa-hmd-users-icon"></i> <span class="title-text"><b>News </b></span><span id="total-title-count" class="title-count"> <!-- (</span><span id="title-count" class="title-count"></span><span class="title-count"> total)  --></span></h4>
            <a href="{{route('admin.newsAdd')}}"><button class="add-button admin-btn btn btn-secondary" style="width: 139px; height: 40px; font-size: 16px;">Create News</button></a>
        </div>
		<div class="card mt-4">
			<div class="card-body">
				<div class="table-responsive">
					<div class="-page-row filter-datatable">
						<div class="col_filed">
							<select name="column_name" id="column_name" class="form-control" multiple>
								<option value="0" selected>Title</option>
								<option value="1" selected>content</option>
								<option value="2" selected>Image</option>
								<option value="3" selected>Created Date</option>
								<option value="4" selected>Actions</option>
							</select>
						</div>
					</div>
					<table class="customtable users table table-bordered table-striped sample_data table-responsive-lg">
						<thead>
							<tr>
								<th class="mwidth100">Title</th>
								<th class="mwidth100">content</th>
								<th class="mwidth100">Image</th>
                                <th class="mwidth100">Created Date</th>
								<th style="min-width: 132px;">Actions</th>
							</tr>
						</thead>
					</table>
				</div>
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
			url:'{{route("admin.newsData")}}', 
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

	$('.head_filter').append($('.filter-datatable'))

	$(document).on('change','#column_name',function(e) {
		var all_column = ["0", "1", "2", "3", "4"];
		var remove_column = [];

		remove_column = $('#column_name').prop('selected',false).val();

		var remaining_column = all_column.filter(function(obj) { return remove_column.indexOf(obj) == -1; });

		dataTable.columns(remove_column).visible(true);
		dataTable.columns(remaining_column).visible(false);
	});

	$(document).on('click', '.user-delete', function() {
		$this=$(this);
		$.ajax({
              type: 'POST',
              url: "{{ route('admin.newsdelete') }}",
              data: {
                  'id': $(this).attr('rel'),
                  "_token": "{{ csrf_token() }}"
              },
              dataType: 'json',
              success: function(data) {
                $this.closest('tr').remove();
              }
          });
	});

	
});
</script>