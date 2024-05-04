@extends('user.layout.app')
@section('title', 'Sounds - All')
@push('headerscript')
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<style>
  .col-md-6{
	margin-bottom:10px;
	}
	.red-row {
	background-color: red !important;
	color:white !important;
	}
	.ui-draggable .ui-dialog-titlebar{
	width: 319px;
	}
	.ui-dialog-titlebar-close:before{
	content:"x";
	display:block;
	position: absolute;
	font-size: 18px;
	color: #0e1961;
	top: -6px;
	right: 3px;
	}
	.ui-dialog-buttonset{
	display: flex;
	justify-content: center;
	}
	.ui-dialog .ui-dialog-buttonpane .ui-dialog-buttonset{
	float:unset!important;
	}
	.ui-dialog-buttonset button{
	border: 0px solid;   
	padding: 6px 28px;
	color: #fff;
	border-radius: 6px;
	}
	.ui-dialog-buttonset button:first-child{
	background: #57bb97;
	}
	.ui-dialog-buttonset button:last-child{
	background:#ff1c1c;
	}
	.ui-dialog .ui-dialog-title{
	font-weight: 400;
	}
	.ui-draggable .ui-dialog-titlebar{
	color: #fff;
	background: #0e1961;
	}
	.ui-dialog .ui-dialog-titlebar-close {
	width: 25px;
	height: 23px;
	position: relative;
	border: 1px solid #80808082;
	border-radius: 50%;
	}
	.paging_simple_numbers{
	display: none !important;
	}
	.dataTables_info{
	display: none !important;
	}
	.dataTables_filter{
	display: none !important;
	}
	.dataTables_length{
	display: none !important;
	}
</style>
@endpush
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-content">
<div class="container-fluid">
	<div class="col-xl-12">
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" id="campaign_form" action="{{ route('userwhatstapp.store') }}" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-12 form-group">
									<h3>Whatsapp Settings</h3>
								</div>
								<div class="col-md-6 form-group">
									<label>Template ID</label>
									<input class="form-control" type="text" id="" required="" name="template_id" value="@if(@$row->temp_id) {{ $row->temp_id }} @else {{ old('template_id') }}  @endif" placeholder="Enter Template Id">
									<div class="text-danger">{{ $errors->first('template_id')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>API Path</label>
									<input class="form-control" type="text" id="" required="" name="api_path" value="@if(@$row->api_path) {{$row->api_path }} @else {{old('api_path')}}  @endif" placeholder="Enter API path">
									<div class="text-danger">{{ $errors->first('api_path')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Template Language</label>
									<select name="temp_lang" required="" class="form-select" id="temp_lang">
									<option value="en" {{ old('temp_lang', @$row->temp_ln) == 'en' ? 'selected' : '' }}>English</option>
									<option value="hi" {{ old('temp_lang', @$row->temp_ln) == 'hi' ? 'selected' : '' }}>Hindi</option>
									</select>
									<div class="text-danger">{{ $errors->first('temp_lang')}}</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<button id="submitBtn" name="submitBtn" class="btn btn-primary" type="submit">Save</button>
									<button class="btn btn-danger m-l-15" type="reset">Cancel</button>
								</div>
						</form>
						<div class="row">
						<div class="col-md-10 form-group text-center" style="margin-top:20px;">
						<img src="{{ asset('/uploads/whatsappimage.png') }}" />
						</div>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@push('footerscript')
<script src="{{asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('skote/layouts/assets/js/pages/datatables.init.js')}}"></script>
<!-- Responsive examples -->
<script src="{{asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
	$("#datatable").dataTable({
	   "processing": false, // for show progress bar
		"paging": false, // for disable paging
		"filter": false,
		"ordering": false, // this is for disable sort order
	        "orderMulti": false, // for disable multiple column at once
	});
</script>
<script>
	function ascDescFilter(id){
	         $('#sort_f').val(id);
	         $('#searchForm').submit();
	     }
	
	     function ConfirmDialog(type,id) {
	$('.btn-close').trigger('click');
	$('<div></div>').appendTo('body')
	 .html('<div><h6></h6></div>')
	 .dialog({
	   modal: true,
	   title: 'Are you Sure? ',
	   zIndex: 10000,
	   autoOpen: true,
	   width: 'auto',
	   resizable: false,
	   buttons: {
	     Yes: function(sucesss) {
	$(this).remove();
	$.ajax({
	      url: "{{ url('user/usercampaign/retryCampaign') }}/"+type+"/"+id,
	      method: 'GET',
	      success: function(response) {
	          if(response == 1){
	             
	          }
		window.location.reload();
	      },
	      error: function(xhr, status, error) {
	          console.error('Error updating player ID:', error);
	      }
	  });
	     },
	     No: function() {
	$(this).remove();
	     }
	   },
	   close: function(event, ui) {
	     $(this).remove();
	   }
	 });
	};
</script>
@endpush