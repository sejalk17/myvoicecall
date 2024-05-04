@extends('admin.layout.app')
@section('title','Ask Doctor')
@push('headerscript')
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css">
<link href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
					<h4 class="mb-sm-0 font-size-18">Edit User</h4>
				</div>
			</div>
		</div>
		@php
		$user_detail= App\Models\UserDetail::where('user_id',$row->id)->first(); 
		$userWisePlan= App\Models\Userwiseplan::where('user_id',$row->id)->first();

		$rolename = DB::table('roles')
		->select('name')
		->where('id', function($query) use ($row) {
		$query->select('role_id')
		->from('model_has_roles')
		->where('model_id', $row->id);
		})
		->value('name');
		@endphp
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="{{ route('user.update', $row->id) }}" enctype="multipart/form-data">
							@method('put')
							@csrf
							<div class="row">
								<div class="col-md-6 form-group">
									<label>First Name</label>
									<input type="text" name="first_name" class="form-control" value="{{ old('first_name', $row->first_name) }}" placeholder="Enter First Name" required=""/>
									<div class="text-danger">{{ $errors->first('first_name')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Last Name</label>
									<input type="text" name="last_name" class="form-control" value="{{ old('last_name', $row->last_name) }}" placeholder="Enter Last Name" />
									<div class="text-danger">{{ $errors->first('last_name')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="email" required=""
										value="{{ old('email', $row->email) }}" placeholder="Enter Email">
									<div class="text-danger">{{ $errors->first('email')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>User name</label>
									<input type="text" class="form-control" name="username" readonly
										value="{{ old('username', $row->username) }}" placeholder="Enter Username">
									<div class="text-danger">{{ $errors->first('username')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Mobile</label>
									<input type="text" class="form-control" name="mobile" required=""
										value="{{ old('mobile', $row->mobile) }}" placeholder="Enter Mobile No.">
									<div class="text-danger">{{ $errors->first('mobile')}}</div>
								</div>
							    <div class="col-md-6 form-group">
                                    <label>User Role</label>
                                    <select name="role" required="" class="form-select">
                                    @foreach ($role as $key => $value)
                                        <option value="{{$key}}" {{ old('role', @$rolename) == $key ? 'selected' : '' }}>{{ $value }}</option>
                                    @endforeach
                                    </select>
                                    <div class="text-danger">{{ $errors->first('role')}}</div>
                                </div>
								<div class="col-md-6 form-group">
									<label>Address</label>
									<input type="text" class="form-control" name="address" required=""
										value="{{ old('address', @$user_detail->address) }}" placeholder="Enter Address">
									<div class="text-danger">{{ $errors->first('address')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Company Name</label>
									<input type="text" class="form-control" name="company_name" required=""
										value="{{ old('company_name', @$user_detail->company_name) }}" placeholder="Enter Company Name">
									<div class="text-danger">{{ $errors->first('company_name')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>User Plan</label>
									<select name="user_plan" required="" class="form-select" id="user_plan">
										<option value="0"> No Plan </option>
										@foreach ($plan as $value)
										<option value="{{$value->id}}" {{ old('user_plan', @$row->user_plan) == $value->id ? 'selected' : '' }}>{{ $value->title }}</option>

										@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('user_plan')}}</div>
								</div>

								<div class="col-md-6 form-group" id="user_plan_start_div" style="display:none;">
									<label>Plan start date</label>
									<input type="text" class="form-control" name="user_plan_start_date" required=""
										value="{{ old('user_plan_start_date', date('Y-m-d', strtotime(@$userWisePlan->user_plan_start_date))) }}" placeholder="yyyy/mm/dd" id="user_plan_start_date">
									<div class="text-danger">{{ $errors->first('user_plan_start_date')}}</div>
								</div>
								<div class="col-md-6 form-group" id="user_plan_end_div" style="display:none;">
									<label>Plan End date</label>
									<input type="text" class="form-control" name="user_plan_end_date" required=""
										value="{{ old('user_plan_end_date', date('Y-m-d', strtotime(@$userWisePlan->user_plan_end_date))) }}" placeholder="yyyy/mm/dd" id="user_plan_end_date">

									<div class="text-danger">{{ $errors->first('user_plan_end_date')}}</div>
								</div>
								
							</div>

							<div class="row">							
								<div class="col-md-12 form-group">
									<h3 class="text-center" style="margin-top:20px; background-color:#e1e3e4; padding:15px 0">For FLIPKART  calling</h3>
								</div>
                               

                                <div class="col-md-6 form-group">
									<label>User Type</label>
									<select name="user_type"  required="" class="form-select">
									@foreach ($userType as $key => $value)
									<option value="{{$key}}" {{ (old('user_type', @$user_detail->user_type) == $key) ? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('user_type')}}</div>
								</div>
                                

								<div class="col-md-6 form-group">
									<label>Retry Attempt</label>
									<select name="retry_option"  required="" class="form-select">
									@foreach ($retryOption as $key => $value)
									<option value="{{$key}}" {{ (old('retry_option', @$user_detail->retry_option) == $key) ? 'selected' : '' }}>{{ $value }}</option>
									@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('retry_option')}}</div>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6 form-group">
											<label>API</label>
											<div class="form-check mb-3">
												<input type="radio" id="api_disable" name="api_status" value="0" {{ (old('api_status', @$user_detail->api_status) == 0) ? 'checked' : '' }}>
												<label for="now">Disable</label>&nbsp;&nbsp;
												<input type="radio" id="api_enable" name="api_status" value="1" {{ (old('api_status', @$user_detail->api_status) == 1) ? 'checked' : '' }}>
												<label for="later">Enable</label>
												<div class="text-danger">{{ $errors->first('api_status')}}</div>
											</div>
										</div>
										<div class="col-md-6 form-group">
											<label>DND</label>
											<div class="form-check mb-3">
												<input type="radio" id="dnd_disbale" name="dnd_status" value="0" {{ (old('dnd_status', @$user_detail->dnd_status) == 0) ? 'checked' : '' }}>
												<label for="now">Disable</label>&nbsp;&nbsp;
												<input type="radio" id="dnd_enable" name="dnd_status" value="1" {{ (old('dnd_status', @$user_detail->dnd_status) == 1) ? 'checked' : '' }}>
												<label for="later">Enable</label>
												<div class="text-danger">{{ $errors->first('dnd_status')}}</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Campaign Type</label>
									<select name="camp_type" required="" class="form-select">
									@foreach ($soundType as $key => $value)
									<option @if(old('camp_type',$row->camp_type) == $key) selected @endif value="{{$key}}">{{ $value }}</option>
									@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('type')}}</div>
								</div>
								
								
								<div class="col-md-6 form-group">
									<label>Plan start date</label>
									<input type="text" class="form-control" name="plan_start_date" required=""
										value="{{ old('plan_start_date', date('Y-m-d', strtotime(@$user_detail->plan_start_date))) }}" placeholder="yyyy/mm/dd" id="plan_start_date">
									<div class="text-danger">{{ $errors->first('plan_start_date')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Plan End date</label>
									<input type="text" class="form-control" name="plan_end_date" required=""
										value="{{ old('plan_end_date', date('Y-m-d', strtotime(@$user_detail->plan_end_date))) }}" placeholder="yyyy/mm/dd" id="plan_end_date">
									<div class="text-danger">{{ $errors->first('plan_end_date')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Logo</label>
									<input type="file" class="form-control" accept="image/*" name="logo_image" 
										value="{{ old('logo_image') }}">
									<img src="{{ asset(@$user_detail->logo_image) }}"  height="150" width="150" />
									<div class="text-danger">{{ $errors->first('logo_image')}}</div>
								</div>

								<div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">OBD calling</label>
									<input type="radio" id="obd" name="obd" value="0" {{ (old('obd', @$row->obd) == 0) ? 'checked' : '' }}>
                                    <label for="obd"> No</label>
                                	<input type="radio" id="obd" name="obd" value="1" {{ (old('obd', @$row->obd) == 1) ? 'checked' : '' }}>
                                    <label for="obd"> Yes</label>
									<div class="text-danger small">{{ $errors->first('obd')}}</div>
                                </div>

                                <div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">DTMF </label>
                                   	<input type="radio" id="dtmf" name="dtmf" value="0" {{ (old('dtmf', @$row->dtmf) == 0) ? 'checked' : '' }}>
                                    <label for="dtmf"> No</label>
                                    <input type="radio" id="dtmf" name="dtmf" value="1" {{ (old('dtmf', @$row->dtmf) == 1) ? 'checked' : '' }}>
                                    <label for="dtmf"> Yes</label>
									<div class="text-danger small">{{ $errors->first('dtmf')}}</div>
                                </div>

								<div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Whatsapp Message </label>
									<input type="radio" id="whtsapp_msg" name="whtsapp_msg" value="0" {{ (old('whtsapp_msg', @$row->whtsapp_msg) == 0) ? 'checked' : '' }}>
                                    <label for="dtmf"> No</label>
                                    <input type="radio" id="whtsapp_msg" name="whtsapp_msg" value="1" {{ (old('whtsapp_msg', @$row->whtsapp_msg) == 1) ? 'checked' : '' }}>
                                    <label for="dtmf"> Yes</label>
                                </div>

                                <div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Call Patching </label>
									<input type="radio" id="call_patching" name="call_patching" value="0" {{ (old('call_patching', @$row->call_patching) == 0) ? 'checked' : '' }}>
                                     <label for="call_patching"> No</label>
                                 	<input type="radio" id="call_patching" name="call_patching" value="1" {{ (old('call_patching', @$row->call_patching) == 1) ? 'checked' : '' }}>
                                    <label for="call_patching"> Yes</label>
									<div class="text-danger small">{{ $errors->first('call_patching')}}</div>
                                </div>

                                <div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">IBD </label>
                                  	<input type="radio" id="ibd" name="ibd" value="0" {{ (old('ibd', @$row->ibd) == 0) ? 'checked' : '' }}>
                                    <label for="ibd"> No</label>
                                    <input type="radio" id="ibd" name="ibd" value="1" {{ (old('ibd', @$row->ibd) == 1) ? 'checked' : '' }}>
                                    <label for="ibd"> Yes</label>
									<div class="text-danger small">{{ $errors->first('ibd')}}</div>
                                </div>
								
								<div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">OBD Campaign Schedule</label>
									<input type="radio" id="obd_schedule" name="obd_schedule" value="0" {{ (old('obd_schedule', @$row->obd_schedule) == 0) ? 'checked' : '' }}>

                                    <label for="obd_schedule"> No</label>
									<input type="radio" id="obd_schedule" name="obd_schedule" value="1" {{ (old('obd_schedule', @$row->obd_schedule) == 1) ? 'checked' : '' }}>
                                    <label for="obd_schedule"> Yes</label>
									<div class="text-danger small">{{ $errors->first('obd_schedule')}}</div>
                                </div>
								<br>
							</div>

                            <div class="row" id="tabdata">
                            <button type="button" id="addrow"class="btn btn-info pull-right m-l-20">
                                <i class="fa fa-plus"></i></button>
                                @foreach ($userPlan as $r)
                             
                               
                                <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Plan type</label>
                                    <select name="plan_type[{{ $loop->iteration - 1}}][]"  required="" class="form-select">
                                        @foreach ($planType as $key => $value)
                                        <option @if(old('plan_type', $r->plan_type) == $key) selected @endif value="{{$key}}">{{ $value }}</option>
                                        @endforeach
                                        </select>
                                        <div class="text-danger">{{ $errors->first('plan_type')}}</div>
                                </div>
                                
                                <div class="col-md-6 form-group">
									<label>Price</label>
									<input type="text" name="plan_type[{{ $loop->iteration - 1 }}][]" class="form-control" value="{{ old('plan_type', $r->price) }}" placeholder="Price" required=""/>
									<div class="text-danger">{{ $errors->first('plan_type')}}</div>
								</div>
                                </div>
                                @endforeach
                            </div>
							</div>

							<!--  For Agent calling --->
							<div class="row">
								<div class="col-md-12 form-group">
									<h3 class="text-center" style="margin-top:20px; background-color:#e1e3e4; padding:15px 0">
										For Agent Calling
									</h3>
								</div>
								<div class="col-md-6 form-group">
									<label>No Of active Agent</label>
									<input type="text" name="active_agent" class="form-control" value="{{ old('active_agent', $row->active_agent) }}" placeholder="No of active Agent" />
									<div class="text-danger">{{ $errors->first('active_agent')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Cts Number (Agent Calling)</label>

									<select name="agentCtsNumber[]" id="agentCtsNumber" class="form-select" multiple="multiple">
										<option  >Choose...</option>
										@foreach ($ctsAgentNumberArray as $key => $value)
										<option @if(in_array($value,$agentCtsNumbers)) selected @endif value="{{$key}}">{{ $value }}</option>
										@endforeach
									</select>

									<div class="text-danger">{{ $errors->first('apiProvider')}}</div>
								</div>
							<div>
                           
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
	const userPlan = document.getElementById('user_plan');
	const userPlanStartDate = document.getElementById('user_plan_start_div');
	const userPlanEndDate = document.getElementById('user_plan_end_div');
	var originalDate = new Date();

	var newEndDate = new Date(originalDate.getFullYear(), originalDate.getMonth() + 1, originalDate.getDate());
	jQuery('#user_plan_start_date').datepicker({
		dateFormat: 'yy-mm-dd'
	});
	jQuery('#user_plan_end_date').datepicker({
		dateFormat: 'yy-mm-dd'	
	});
	jQuery('#user_plan_start_date').datepicker('setDate', '0');
	jQuery('#user_plan_end_date').datepicker('setDate', newEndDate);

	@if($row->user_plan != 0)
		userPlanStartDate.style.display = 'block';
		userPlanEndDate.style.display = 'block';
	@endif

	userPlan.addEventListener('change', function() {
		var selectedValue = userPlan.value; // Get the selected value of the select box
		// Assuming you want to show retryDuration when a specific option is selected
		if (selectedValue > 0 ) {
			userPlanStartDate.style.display = 'block';
			userPlanEndDate.style.display = 'block';
			
		} else {
			userPlanStartDate.style.display = 'none';
			userPlanEndDate.style.display = 'none';
		}
	});

	jQuery('#plan_end_date').datepicker({
	    dateFormat: 'yy-mm-dd'
	});
	jQuery('#plan_start_date').datepicker({
	    dateFormat: 'yy-mm-dd'
	});
    jQuery(document).ready(function() {
        jQuery('#ctsNumber').select2();
		$('#agentCtsNumber').select2();
	});

    let i = 11;
    $('#addrow').on("click", function () {
        var newRow = $("<tr>");
        var cols = "";
        cols += '<div class="row"><div class="col-md-6 form-group"><select name="plan_type[' + i + '][]" required class="form-select" id=product_id_' + i + ' required>@foreach($planType as $key =>$prow)<option value="{{$key}}">{{$prow}}</option>@endforeach</select></div>';
        cols += ' <div class="col-md-6 form-group"><input class="form-control" type="text" name="plan_type[' + i + '][]"  id=hsn_' + i + ' " required placeholder="Price"><button type="button" id="delbtn" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button></div></div>';
            i++;
        newRow.append(cols);
        $("#tabdata").append(cols);
    });
    $("#tabdata").on("click", "#delbtn", function () {
        $(this).closest('.row').remove();
        i--;
    });
</script>

@endpush