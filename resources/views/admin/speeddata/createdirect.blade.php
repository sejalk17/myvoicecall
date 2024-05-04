@extends('admin.layout.app')
@section('title','Create User')
@push('headerscript')
<link href="{{ asset('theme/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<style>
	.col-md-6{
	margin-bottom:10px;
	}
</style>
@endpush
@section('content')
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
					<h4 class="mb-sm-0 font-size-18">Create User</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="{{ route('adminspeeddata.storedirect') }}" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-6 form-group">
									<label>File Name</label>
									<select name="campaigns[]" id="campaigns" class="form-select" multiple>
										<option  >Choose...</option>
										@foreach ($campaign as $r)
										<option @if(old('campaigns') == $r->id) selected @endif value="{{$r->id}}">{{ $r->campaign_name }} ({{$r->total_count}})</option>
										@endforeach
									</select>
								</div>
								
								<br>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<button name="submitBtn" class="btn btn-primary" type="submit">Save</button>
									<button class="btn btn-danger m-l-15" type="reset">Cancel</button>
								</div>
						</form>
						</div> <!-- end col -->
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('theme/default/assets/js/fastclick.js')}}"></script>
<script src="{{ asset('theme/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
$(document).ready(function() {
	  $('#campaigns').select2();
	});
@endpush
