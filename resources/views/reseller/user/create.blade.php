@extends('reseller.layout.app')
@section('title','Create User')
@push('headerscript')
<link href="{{ asset('theme/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
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
						<form method="POST" action="{{ route('reselleruser.store') }}" enctype="multipart/form-data">
							@csrf
							<div class="row">
								<input type="hidden" name="camp_type" value="transactional" />
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
									<label>Logo</label>
									<input type="file" class="form-control" accept="image/*" name="logo_image"
										value="{{ old('logo_image') }}">
									<div class="text-danger">{{ $errors->first('logo_image')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Address</label>
									<input type="text" class="form-control" name="address"
										value="{{ old('address') }}" placeholder="Enter Address">
									<div class="text-danger">{{ $errors->first('address')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Company Name</label>
									<input type="text" class="form-control" name="company_name" required=""
										value="{{ old('company_name') }}" placeholder="Enter Company Name">
									<div class="text-danger">{{ $errors->first('company_name')}}</div>
								</div>

                                <div class="col-md-6 form-group">
									<label>User Plan</label>
									<select name="user_plan" required="" class="form-select" id="user_plan">
										<option value="0"> No Plan </option>
										@foreach ($plan as $value)
										<option @if(old('user_plan') == $value->id) selected @endif value="{{$value->id}}">{{ $value->title }}</option>
										@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('user_plan')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Credit(Wallet)</label>
									<input type="text" class="form-control" name="wallet" 
										value="{{ old('wallet') }}" placeholder="Enter Credit">
									<div class="text-danger">{{ $errors->first('wallet')}}</div>
								</div>

                                <div class="col-md-6 form-group" id="user_plan_start_div" style="display:none;">
									<label>Plan start date</label>
									<input type="text" class="form-control" name="user_plan_start_date" 
										value="{{ old('user_plan_start_date') }}" placeholder="yyyy/mm/dd" id="user_plan_start_date">
									<div class="text-danger">{{ $errors->first('user_plan_start_date')}}</div>
								</div>
								<div class="col-md-6 form-group" id="user_plan_end_div" style="display:none;">
									<label>Plan End date</label>
									<input type="text" class="form-control" name="user_plan_end_date"
										value="{{ old('user_plan_end_date') }}" placeholder="yyyy/mm/dd" id="user_plan_end_date">
									<div class="text-danger">{{ $errors->first('user_plan_end_date')}}</div>
								</div>

                            </div>

                            <div class="row">
                                <div class="col-md-12 form-group">
									<h3 class="text-center" style="margin-top:20px; background-color:#e1e3e4; padding:15px 0">For FLIPKART  calling</h3>
								</div>
                                <div class="col-md-6 form-group">
									<label>User type</label>
									<select name="user_type"  required="" class="form-select">
									@foreach ($userType as $key => $value)
									<option @if(old('user_type') == $key) selected @endif value="{{$key}}">{{ $value }}</option>
									@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('user_type')}}</div>
								</div>

								

								<div class="col-md-6 form-group">
									<label>Plan type</label>
									<select name="plan_type"  required="" class="form-select">
									@foreach ($planType as $key => $value)
									<option @if(old('plan_type') == $key) selected @endif value="{{$key}}">{{ $value }}</option>
									@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('plan_type')}}</div>
								</div>

							

								<div class="col-md-6 form-group">
									<label>Retry Attempt</label>
									<select name="retry_option"  required="" class="form-select">
									@foreach ($retryOption as $key => $value)
									<option @if(old('retry_option') == $key) selected @endif value="{{$key}}">{{ $value }}</option>
									@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('retry_option')}}</div>
								</div>

								<div class="col-md-3 form-group">
									<label>API</label>
									<div class="form-check mb-3">
										<input type="radio" id="api_disable" name="api_status" value="0" @if(old('api_status') == "0") checked @else checked @endif >
										<label for="now">Disable</label>&nbsp;&nbsp;
										<input type="radio" id="api_enable" name="api_status" value="1" @if(old('api_status') == "1") checked @endif>
										<label for="later">Enable</label>
										<div class="text-danger">{{ $errors->first('api_status')}}</div>
									</div>
								</div>

								<div class="col-md-3 form-group">
									<label>DND</label>
									<div class="form-check mb-3">
										<input type="radio" id="dnd_disbale" name="dnd_status" value="0" @if(old('dnd_status') == "0") checked @else checked @endif>
										<label for="now">Disable</label>&nbsp;&nbsp;
										<input type="radio" id="dnd_enable" name="dnd_status" value="1" @if(old('dnd_status') == "1") checked @endif>
										<label for="later">Enable</label>
										<div class="text-danger">{{ $errors->first('dnd_status')}}</div>
									</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Account start date</label>
									<input type="text" class="form-control" name="plan_start_date" required=""
										value="{{ old('plan_start_date') }}" placeholder="yyyy/mm/dd" id="plan_start_date">
									<div class="text-danger">{{ $errors->first('plan_start_date')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Account End date</label>
									<input type="text" class="form-control" name="plan_end_date" required=""
										value="{{ old('plan_end_date') }}" placeholder="yyyy/mm/dd" id="plan_end_date">
									<div class="text-danger">{{ $errors->first('plan_end_date')}}</div>
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

const userPlan = document.getElementById('user_plan');
	const userPlanStartDate = document.getElementById('user_plan_start_div');
	const userPlanEndDate = document.getElementById('user_plan_end_div');
	var originalDate = new Date();

	userPlan.addEventListener('change', function() {
		var selectedValue = userPlan.value; // Get the selected value of the select box
		// Assuming you want to show retryDuration when a specific option is selected
		if (selectedValue > 0 ) {
			userPlanStartDate.style.display = 'block';
			userPlanEndDate.style.display = 'block';
			var newEndDate = new Date(originalDate.getFullYear(), originalDate.getMonth() + 1, originalDate.getDate());
			jQuery('#user_plan_start_date').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			jQuery('#user_plan_end_date').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			jQuery('#user_plan_start_date').datepicker('setDate', '0');
			jQuery('#user_plan_end_date').datepicker('setDate', newEndDate);
		} else {
			userPlanStartDate.style.display = 'none';
			userPlanEndDate.style.display = 'none';
		}
	});


	jQuery('#plan_end_date').datepicker({
	    dateFormat: 'yy-mm-dd'
	});
	var newDate = new Date(originalDate.getFullYear(), originalDate.getMonth() + 3, originalDate.getDate());
	jQuery('#plan_end_date').datepicker('setDate', newDate);
	jQuery('#plan_start_date').datepicker({
	    dateFormat: 'yy-mm-dd',
	});
	$('#plan_start_date').datepicker('setDate', '0');
</script>
@endpush