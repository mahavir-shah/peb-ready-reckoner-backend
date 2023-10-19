<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Peb Ready Reckoner - Admin</title>
<link rel="icon" href="{{asset('backend/favicon.ico')}}">
    <!-- Favicon-->
    <link rel="icon" type="image/png" href="{{asset('backend/favicon.ico')}}">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://use.fortawesome.com/b5e0e19b.js"></script>

    <!-- Fonts-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,400;1,500;1,600;1,700&family=Work+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet">

    <!-- CSS only -->
    <link rel="stylesheet" href="{{ asset('backend/css/styles.css') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('backend/css/custom_css.css') }}">

   <!-- <script type="text/javascript" src="https://www.bugherd.com/sidebarv2.js?apikey=b2ucalq8gvrdapvxarcgva" async="true"></script>
     {{--  <script type="text/javascript" src="https://www.bugherd.com/sidebarv2.js?apikey=gilyw01hr4vp1tufliqidw" async="true"></script> --}} -->
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/lottie-web/5.10.2/lottie.min.js"
    integrity="sha512-fTTVSuY9tLP+l/6c6vWz7uAQqd1rq3Q/GyKBN2jOZvJSLC5RjggSdboIFL1ox09/Ezx/AKwcv/xnDeYN9+iDDA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<body>
<div class="d-flex" id="wrapper">
        <!-- Page content wrapper-->
<div id="page-content-wrapper">

<div class="modal fade update-credentials" id="designation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  	<div class="modal-dialog modal-dialog-centered" style="display: flex; align-items: center; width: 420px;" role="document">
	    <div class="modal-content">
	      	<div class="modal-header" style="margin: 0 24px;">
	        	<h5 class="modal-title" id="exampleModalLabel">User Details</h5>
	        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          		<span aria-hidden="true">&times;</span>
	        	</button>                                                                   
	      	</div>
		    <div class="modal-body">
		      	<form method="post" id="designation-form" action="{{route('paymentProcess')}}">
		  			@csrf
                    <input type="hidden" name="user_id" value="{{$user->id}}">
		      		<div class="row mb-2">
				        <label>Name</label>
				        <input class="form-control get-organization" value="{{$user->name}}">
				 	</div>
                     <div class="row mb-2">
				        <label>Phone No</label>
				        <input class="form-control get-organization" value="{{$user->mobile_no}}">
				 	</div>
                     <div class="row mb-2">
				        <label>Email</label>
				        <input class="form-control get-organization" value="{{$user->email}}">
				 	</div>
                     <div class="row mb-2">
				        <label>Plan Name</label>
				        <input class="form-control get-organization" name="plan_name" value="{{$plan}}">
				 	</div>
                    <div class="row mb-2">
				        <label>Amount</label>
				        <input class="form-control get-organization" name="amount" value="{{$price}}">
				 	</div>
                     <div class="row mb-2">
				        <label>Expiry Date</label>
				        <input class="form-control get-organization" name="plan_expirey_date" value="{{$expirt_date}}">
				 	</div>
		      		<div class="row mt-4">
		      			<div class="col-md-12">
						  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		        			<button class="btn btn-primary save-info" style="border: 0;" type="submit">Payment</button>
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

	$('#designation').modal('show');

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
				dataTable1.draw();
              }
          });
	});
	
});
</script>