@extends('user.layout.app')
@section('title','Create Campaign')
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
						<form method="POST" id="campaign_form" action="{{ route('usercampaign.usercampaigdatastore') }}" enctype="multipart/form-data">
							@csrf
							<div class="row">
								@php
								$userdetail = App\Models\UserDetail::where('user_id',Auth::user()->id)->first();
								$data = App\Models\Ctsnumber::where('status',"1")->where('user_id',Auth::user()->id)->get();
								@endphp
								<div class="col-md-6 form-group">
									<label>Campaign Name</label>
									<input class="form-control" type="text" id="" required="" name="campaign_name" maxlength="26" value="{{ old('name') }}" placeholder="Enter Campaign name">
									<div class="text-danger">{{ $errors->first('name')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>DID</label>
									{{-- <input type="text" name="service_no" class="form-control" readonly value="{{}}"> --}}
									<select name="service_no" required="" class="form-select">
										@if($data != null)
										@php
										$noAacitve="";
										@endphp
										@foreach($data as $r)
										@php
										$noAacitve= App\Models\Channel::where('inactive','0')->where('ctsNumber',$r->ctsNumber)->get();
										@endphp
										@foreach($noAacitve as $non)
										@if($non->ctsNumber == $r->ctsNumber)
										<option value="{{$r->ctsNumber}}">{{$r->ctsNumber}}</option>
										@endif 
										@endforeach
										@endforeach
										@endif
									</select>
									<div class="text-danger">{{ $errors->first('service_no')}}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Voice List</label>
									<select name="voiceclip" required="" class="form-select">
										<option value="">Select Type</option>
										@foreach ($soundList as $r)
										<option value="{{ $r->id }}">{{ $r->name }}</option>
										@endforeach
									</select>
									<div class="text-danger">{{ $errors->first('voiceclip') }}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Camp Type</label>
									<select name="type" required="" class="form-select">
										<option value="transactional">OBD</option>
									</select>
									<div class="text-danger">{{ $errors->first('type') }}</div>
								</div>
								<div class="col-md-6 form-group">
									<label>Retry Attempt</label>
									<select name="retry_attempt" required="" class="form-select" id="retry_attempt">
										<option value="0">No Retry</option>
										@if(App\Models\UserDetail::where('user_id',Auth::user()->id)->value('retry_option') == 1)
										<option value="1">1</option>
										@elseif(App\Models\UserDetail::where('user_id',Auth::user()->id)->value('retry_option') == 2)
										<option value="1">1</option>
										<option value="2">2</option>
										@endif
									</select>
									<div class="text-danger">{{ $errors->first('retry_attempt') }}</div>
								</div>
								<div class="col-md-6 form-group"  id="retry_duration">
									<label>Dur. Between Retry(In hours)</label>
									<select name="retry_duration" required="" class="form-select">
										<option value="0">Immediate</option>
										<option value="15">15 min</option>
										<option value="30">30 min</option>
									</select>
									<div class="text-danger">{{ $errors->first('retry_duration')}}</div>
								</div>
								
								@php
								$obd_schedule 	= Auth::user()->obd_schedule;
								$dtmf 			= Auth::user()->dtmf;
								$whtsapp_msg	= Auth::user()->whtsapp_msg;
								$user_plan		= Auth::user()->user_plan;
								@endphp
								@if($dtmf == 1)
								<div class="col-md-6 form-group">
									<label>DTMF Response (Capture )</label><br>
									<input type="radio" id="no" name="dtmf_response" value="no" checked>
									<label for="no">No</label>&nbsp;&nbsp;
									<input type="radio" id="yes" name="dtmf_response" value="yes">
									<label for="yes">Yes</label>
									<div class="text-danger">{{ $errors->first('schedule')}}</div>
								</div>
								@endif
								@if($whtsapp_msg == 1)
								<div class="col-md-6 form-group">
									<label>Want to send thank you message on whatsapp ? (AFter DTMF Response)</label><br>
									<input type="radio" id="no1" name="whatsapp_response" value="no" checked>
									<label for="no">No</label>&nbsp;&nbsp;
									<input type="radio" id="yes1" name="whatsapp_response" value="yes">
									<label for="yes">Yes</label>
									<div class="text-danger">{{ $errors->first('whatsapp_response')}}</div>
								</div>
								@endif
								
								<div class="col-md-6 form-group" id="upload-data">
									<label>Upload Data</label> Download Sample File <a href="{{asset('uploads/sample.xlsx')}}" download>from here</a> <br/><span style="color:red; font-size:16px;">Sample file is changed so please use new file</span>
									<input type="file" class="form-control" accept=".xlsx" id="excel_file_upload" name="excel_file_upload" required=""
										value="{{ old('excel_file_upload') }}">
									<div class="text-danger">{{ $errors->first('excel_file_upload')}}</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<button id="submitBtn" name="submitBtn" class="btn btn-primary" type="submit">Save</button>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	    var submitted = false;
	
	    $('#campaign_form').submit(function(e) {
	        if (submitted) {
	            e.preventDefault();
	        } else {
	            submitted = true;
	            $('#submitBtn').prop('disabled', true).val('Submitting...');
	        }
	    });
	});
	
	jQuery('#schedule_datetime').datetimepicker();
	jQuery('#camp_end_datetime').datetimepicker({
	 language: 'en',
	 format: 'yyyy-MM-dd hh:mm'
	});
</script>
<script>
	const showInputRadio = document.getElementById('later');
	const hideInputRadio = document.getElementById('now');
	const retryAttempt = document.getElementById('retry_attempt');
	const inputBox = document.getElementById('schedule');
	const retryDuration = document.getElementById('retry_duration');
	
	showInputRadio.addEventListener('change', function() {
	    if (showInputRadio.checked) {
	        inputBox.style.display = 'block';
	    }
	});
	
	retryAttempt.addEventListener('change', function() {
		var selectedValue = retryAttempt.value; // Get the selected value of the select box
		alert(selectedValue);
		if (selectedValue > 0 ) {
			retryDuration.style.display = 'block';
		} else {
			retryDuration.style.display = 'none';
		}
	});
	
	
	hideInputRadio.addEventListener('change', function() {
	    if (hideInputRadio.checked) {
	        inputBox.style.display = 'none';
	    }
	});
	
	function uploadTypeCheck(type){
	       if(type == 'csv'){
	           $('#manual-data').hide();
	           $('#upload-data').show();
	           $('#excel_file_upload').attr('required',true);
	           $('#manual_data').attr('required',false);
	       }else{
	           $('#manual-data').show();
	           $('#upload-data').hide();
	           $('#excel_file_upload').attr('required',false);
	           $('#manual_data').attr('required',true);
	       }
	}
</script>
@endpush