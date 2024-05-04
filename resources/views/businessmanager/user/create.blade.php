@extends('businessmanager.layout.app')
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
						<form method="POST" action="{{ route('bmuser.store') }}" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<div class="col-md-6 form-group">
									<label>First Name</label>
									<input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="Enter First Name" required=""/>
									<div class="text-danger">{{ $errors->first('first_name')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Last Name</label>
									<input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="Enter Last Name" />
									<div class="text-danger">{{ $errors->first('last_name')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="email" required=""
										value="{{ old('email') }}" placeholder="Enter Email">
									<div class="text-danger">{{ $errors->first('email')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>User name</label>
									<input type="text" class="form-control" name="username" required=""
										value="{{ old('username') }}" placeholder="Enter Username">
									<div class="text-danger">{{ $errors->first('username')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Mobile</label>
									<input type="text" class="form-control" name="mobile" required=""
										value="{{ old('mobile') }}" placeholder="Enter Mobile No.">
									<div class="text-danger">{{ $errors->first('mobile')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Password</label>
									<input type="password" class="form-control" name="password" required=""
										value="{{ old('password') }}" placeholder="Enter Password">
									<div class="text-danger">{{ $errors->first('password')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>User Role</label>
									<select name="role" required="" class="form-select">
									@foreach ($role as $key => $value)
									<option @if(old('role') == $value) selected @endif value="{{$key}}">{{ $value }}</option>
									@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('role')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Address</label>
									<input type="text" class="form-control" name="address" required=""
										value="{{ old('address') }}" placeholder="Enter Address">
									<div class="text-danger">{{ $errors->first('address')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Company Name</label>
									<input type="text" class="form-control" name="company_name" required=""
										value="{{ old('company_name') }}" placeholder="Enter Company Name">
									<div class="text-danger">{{ $errors->first('company_name')}}</div>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.js"></script>
<script>
	jQuery('#plan_end_date').datepicker({
	    dateFormat: 'yy-mm-dd'
	});
	var originalDate = new Date();
	var newDate = new Date(originalDate.getFullYear(), originalDate.getMonth() + 3, originalDate.getDate());
	jQuery('#plan_end_date').datepicker('setDate', newDate);
	jQuery('#plan_start_date').datepicker({
	    dateFormat: 'yy-mm-dd',
	});
	$('#plan_start_date').datepicker('setDate', '0');
</script>
@endpush