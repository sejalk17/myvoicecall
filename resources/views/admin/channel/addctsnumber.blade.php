@extends('admin.layout.app')
@section('title', 'Sounds - All')
@push('headerscript')
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	.col-md-6{
	margin-bottom:10px;
	}
	.red-row {
	background-color: red !important;
	color:white !important;
	}
</style>
@endpush
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-content">
<!-- Start content -->
<div class="">
	<div class="container-fluid">
		@if (session()->has('error'))
		<div class="alert alert-danger">
			{{ session()->get('error') }}
		</div>
		@endif
		@if (session()->has('success'))
		<div class="alert alert-success">
			{{ session()->get('success') }}
		</div>
		@endif
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18"><i class="bx bx-video-recording"></i> Add CTS Number</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body  overflow-x-auto">
						<div class="clearfix"></div>
						<form method="POST" action="{{ route('channel.addctsnumbersave') }}" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-6 form-group">
									<label>Username </label>
									<select name="users" id="users" class="form-select">
										<option  >Choose...</option>
										@foreach ($user as $key => $value)
										<option @if(old('users') == $key) selected @endif value="{{$key}}">{{ $value }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-md-6 form-group">
									<label> Cts Nunber </label>
									<select name="ctsNumber" id="ctsNumber" class="form-select">
										<option  >Choose...</option>
										@foreach ($channel as $key => $value)
										<option @if(old('agentCtsNumber') == $key) selected @endif value="{{$key}}">{{ $value }}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<button name="submitBtn" class="btn btn-primary" type="submit">Save</button>
									<button class="btn btn-danger m-l-15" type="reset">Cancel</button>
								</div>
							</div>
						</form>
						
					</div>
				</div>
			</div>
		</div>
		<!-- container -->
	</div>
	<!-- content -->
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
	elems.forEach(function(html) {
		let switchery = new Switchery(html,  { size: 'small' });
	});
	
	$(document).ready(function(){
		$('.js-switch').change(function () {
			let status = $(this).prop('checked') === true ? 1 : 0;
			let ID = $(this).data('id');
			
			if (confirm("Are you sure you want to change the ukey status?")) {
				$.ajax({
					type: "GET",
					dataType: "json",
					url: "{{ route('channel.statusUpdate') }}",
					data: {'status': status, 'id': ID}, 
					success: function (data) {
						toastr.options.closeButton = true;
						toastr.options.closeMethod = 'fadeOut';
						toastr.options.closeDuration = 100;
						toastr.success(data.message);
						console.log(data.message);
					}
				});
			} else {
				$(this).prop('checked', !status);
				return false;
			}
		});
	});
	$(document).ready(function() {
	  $('#users').select2();
	  $('#ctsNumber').select2();
	});
</script>
@endpush