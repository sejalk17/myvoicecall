@extends('agentuser.layout.app')
@section('title','Click to Call ')
@push('headerscript')
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css">
<link href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
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
					<h4 class="mb-sm-0 font-size-18">Create Campaign</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="{{ route('clicktocall.store') }}" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-12 form-group">
									<h4 style="color:red;">Call will be display from No. ? </h4>
								</div>
								<div class="col-md-6 form-group">
									<label>Agent No</label>
									<input class="form-control" type="text" id="" required="" name="agent_no" maxlength="26" value="{{ old('agent_no') }}" placeholder="Enter Agent No">
									<div class="text-danger">{{ $errors->first('agent_no')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Dialer No</label>
									<input class="form-control" type="text" id="" required="" name="b_mobile_no" maxlength="26" value="{{ old('b_mobile_no') }}" placeholder="Enter Dialer No">
									<div class="text-danger">{{ $errors->first('b_mobile_no')}}</div>
								</div>
								
							<div class="row">
								<div class="col-md-6 form-group">
									<button id="submitBtn" name="submitBtn" class="btn btn-primary" type="submit">Initiate Call</button>
									<button class="btn btn-danger m-l-15" type="reset">Cancel</button>
								</div>
						</form>
						</div> 
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>
@endsection
@push('footerscript')
@endpush