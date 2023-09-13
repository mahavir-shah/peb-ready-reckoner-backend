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
            <h4 class="mt-4"><i class="fa fa-hmd-users-icon"></i> <span class="title-text"><b>Web Config </b></span><span id="total-title-count" class="title-count"> <!-- (</span><span id="title-count" class="title-count"></span><span class="title-count"> total)  --></span></h4>
        </div>
		<div class="card mt-4">
			<div class="card-body">
				<div class="table-responsive">
					<div class="-page-row filter-datatable">
						<div class="col_filed">
							<select name="column_name" id="column_name" class="form-control" multiple>
								<option value="0" selected>Logo</option>
								<option value="1" selected>content</option>
								<option value="2" selected>Actions</option>
							</select>
						</div>
					</div>
					<table class="customtable users table table-bordered table-striped sample_data table-responsive-lg">
						<thead>
							<tr>
								<th>Logo</th>
								<th>content</th>
								<th>Actions</th>
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
		"bPaginate": false,
		"bFilter": false, //hide Search bar
    	"bInfo": false, // hide showing entries
		"ordering": false,
		"order": [],
		"ajax" : {
            type:"POST",
			url:'{{route("admin.webConfigData")}}', 
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        },
		dom: 'lBfrtip',
		serverSide: true,
		dom: '<"head_filter"<"search_btn"f>>rt<"row"<"col-sm-4"l><"col-sm-4"i>>',
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
		var all_column = ["0", "1", "2"];
		var remove_column = [];

		remove_column = $('#column_name').prop('selected',false).val();

		var remaining_column = all_column.filter(function(obj) { return remove_column.indexOf(obj) == -1; });

		dataTable.columns(remove_column).visible(true);
		dataTable.columns(remaining_column).visible(false);
	});

});
</script>