<!-- Bootstrap core JS-->
<style type="text/css">
	#turn {
	 display: none;
	}
	 #turn p {
		 font-size: 0;
	}
	 @media screen and (min-width: 0) and (max-width: 768px)  {
		 #turn {
			 display: block;
			 position: fixed;
			 width: 100vw;
			 height: 100%;
			 /* This index should be the highest z-index in the application. Please ensure */
			 z-index: 99999999999;
			 top: 0;
			 background-color: rgba(0, 0, 0, 0.9);
			 color: white;
		}
		 #turn p {
			 color: white;
			 position: absolute;
			 top: 50%;
			 left: 50%;
			 transform: translate(-50%, -50%);
			 text-align: center;
			 font-size: 16px;
			 font-family:  "Work Sans";
			 font-weight: 400;
		}
		 #turn p span {
			 width: 100px;
			 height: 100px;
			 display: block;
			 margin: auto;
			 margin-bottom: 10px;
		}
		 #turn p img {
			 width: 100px;
			 height: 100px;
		}
	}
	
    /* Filter Select box */
    /*the container must be positioned relative:*/
    .mts-custom-select{
      position: relative;
    }
    
    .filter_menu .filter-data .mts-custom-select:after {
        content: "";
    }
	.member-filter-data .filter-data .mts-custom-select:after {
        content: "";
    }
    .mts-custom-select select {
      display: none; /*hide original SELECT element:*/
    }
    
    .select-selected {
      background-color: #fff;
    }
    
    /*style the arrow inside the select element:*/
    .select-selected:after {
      position: absolute;
      content: "";
      top: 14px;
      right: 10px;
      width: 0;
      height: 0;
      border: 6px solid transparent;
      border-color: #727272 transparent transparent transparent;
    }
    
    /*point the arrow upwards when the select box is open (active):*/
    .select-selected.select-arrow-active:after {
      border-color: transparent transparent #727272 transparent;
      top: 7px;
    }
    
    /*style the items (options), including the selected item:*/
    .select-items div,.select-selected {
      color: #727272;
      padding: 8px 16px;
      border: 1px solid transparent;
      border-color: transparent transparent #727272 transparent;
      cursor: pointer;
      user-select: none;
    }
    
    /*style items (options):*/
    .select-items {
      position: absolute;
      background-color: #ffffff;
      top: 100%;
      left: 0;
      right: 0;
      z-index: 99;
    }
    
    /*hide the items when the select box is closed:*/
    .select-hide {
      display: none;
    }
    
    .select-items div:hover, .same-as-selected {
      background-color: rgba(0, 0, 0, 0.1);
    }

    .select-items div.disabled {
        opacity: 0.2;
        pointer-events: none;
    }
    #API-Loader {
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        z-index: 99999;
        background: rgba(225,225,225,0.6);
    }
    #API-Loader lottie-player{
          width: 50px;
        height: 50px;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
</style>
</div>
</div>
<!-- 
<div id="turn"><p><span><img src="https://hmmngbrd.nyc3.cdn.digitaloceanspaces.com/upload%2Flanding_page%2Fphone-rotate.png" alt=""></span>Please rotate your device to portrait<br>for better experience!</p></div> -->

<div class="modal fade admin-modal" id="msg-model" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="width: 420px;height: 100vh;display: flex;align-items: center;margin-top: 0;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Message</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          			<span aria-hidden="true">&times;</span>
       			</button>
            </div>
            <form  method="post" id="admin-msg-form" enctype="multipart/form-data">
              @csrf
              <input  class="form-control" type="hidden" name="type"  value="" id="type">
	            <div class="modal-body">
                    <div class="form-group">
                        <label>From</label>
                      <input  class="form-control" type="text" name="from_address"  value="{{env('MAIL_FROM_ADDRESS')}}" readonly>
                    </div>
                    <div class="form-group">
                        <label>To</label>
                      <input  class="form-control" type="text" name="to_address"  id="to_address" value="" readonly>
                    </div>
                    <div class="form-group">
		      			<label>Message</label><span class="text-danger">*</span>
		        		<textarea  class="form-control" name="message" id="message" value=""></textarea>
		      		</div>
                      <div class="form-group">
                        <label>Attachment</label>
                        <input  class="form-control" id="attachment_file" type="file" name="attachment_file" value="">
                    </div>
	            </div>
	            <div class="modal-footer">
	                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	                <button type="submit" class="btn btn-primary send-mail-btn" disabled>Send</button>
	            </div>
            </form>
        </div>
    </div>
</div>

<!--  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- Core theme JS-->
 <script src="{{asset('backend/js/scripts.js')}}"></script> 
 <script src="{{asset('backend/js/ckeditor.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
<script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js" integrity="sha512-rstIgDs0xPgmG6RX1Aba4KV5cWJbAMcvRCVmglpam9SoHZiUCyQVDdH2LPlxoHtrv17XWblE/V/PP+Tr04hbtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

<div id="API-Loader" class="loader-center" style="display:none">
  <lottie-player src="{{ asset('backend/js/lottie.json') }}" background="transparent" speed="1" loop  autoplay></lottie-player>
</div>

</html>
<script type="text/javascript" language="javascript">
$(document).ready(function(){

    $(document).on('keyup','#message',function() {
        if($(this).val() != ''){
            $('.send-mail-btn').attr('disabled',false);
        }else{
            $('.send-mail-btn').attr('disabled',true);
        }
    });

    $(document).on('submit', '#admin-msg-form', function(event) {
        event.preventDefault();
        let payload = {
          "from_address": "notifications@butterfly.co",
          "to_address": $('#to_address').val(),
          "message": $('#message').val(),
          "media":""
        };
        $('#API-Loader').show();
        if($('input[type=file]')[0].files?.length){
          let file = $('input[type=file]')[0].files[0];
          var files = new FormData();
          files.append("media",file,file.name);
          $.ajax({
              type:'POST',
              url:'{{ env("API_ENDPOINT_DOMAIN")."/media/upload"}}',
              contentType: false,
              processData: false,
              data: files,
              dataType: 'html',
              success:function(data){
                data = JSON.parse(data);
                if(data.success){
                  debugger 
                  payload.media= data.data.data[0]['url'];
                  sentEmailMessage(payload);
                }
              }
          });
        }else{
          sentEmailMessage(payload);
        }
    });

    function sentEmailMessage(payload){
      $.ajax({
            type:'POST',
            url:"{{ env('API_ENDPOINT').'/sendEmail' }}",
            data: payload,
            dataType: 'json',
            success:function(data){
              $('#API-Loader').hide();
              if(data?.status){
                $('#msg-model').modal('hide');
                toastr.success('Email Sent Successfully');
              }else{
                toastr.error(data?.message);
              }
            }
        });
    }
});
</script>
