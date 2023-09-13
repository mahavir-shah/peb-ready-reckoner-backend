@include('admin.include.header')
<style> 
		.ck-editor__editable_inline { min-height: 350px; } 
		.ck.ck-reset.ck-editor.ck-rounded-corners { width: 100%; }
        #content-error{
            position: absolute;
            bottom: -32px;
            left: 15px;
        }
	</style>
<div class="inner-table-wrapper user-listing">
	<div class="container">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <a href="{{route('admin.webConfig')}}"><h4 class="mt-4"><i class="fa fa-arrow-left"></i> <span class="title-text"><b>Back </b></span><span id="total-title-count" class="title-count"></span></h4></a>
        </div>
		<div class="card mt-4">
			<div class="card-body">
                <form action="{{route('admin.webConfigcreate')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" value="{{isset($data) ? $data->id : ''}}" name="id">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Logo<span class="text-danger">*</span></label>
                                <input name="logo" type="file" class="form-control w-100 shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="logo" {{isset($data->logo) ? '' : 'required'}}>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label>Welcome Content<span class="text-danger">*</span></label>
                            <textarea class="form-control wysiwyg_ckeditor" name="welcome_content" id="welcome_content" required>{{isset($data) ? $data->welcome_content : ''}}</textarea>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <div class="form-group" style="text-align: center;">
                                <button type="submit" class="add-button admin-btn btn btn-secondary" style=" width: 139px; height: 40px; font-size: 16px;">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>
@include('admin.include.footer')
<script type="text/javascript">
	$(document).ready(function () {
		
		ClassicEditor
	    .create(document.querySelector('#welcome_content')).then (editor => {
           editorTextarea = editor;
        })
	    .catch(error => {
	    	console.error(error);
	    });

        $('form').validate({
            ignore : [],
            rules: { 
                content: {                         
                        rckrequired:true
                    }
                 }
        });
    });
</script>