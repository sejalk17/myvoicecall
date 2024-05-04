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
					<h4 class="mb-sm-0 font-size-18">Upload Report</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" id="campaign_form" action="{{ route('usercampaign.uploadstore') }}" enctype="multipart/form-data">
							@csrf
							<div class="row">
								
								<div class="col-md-6 form-group">
									<label>Campaign Name</label>
									<input class="form-control" type="text" id="" required="" name="campaign_name" maxlength="26" value="{{ old('name') }}" placeholder="Enter Campaign name">
									<div class="text-danger">{{ $errors->first('name')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Campaign Ref Id</label>
									<input class="form-control" type="text" id="" required="" name="campaign_ref_id" maxlength="26" value="{{ old('name') }}" placeholder="Enter Campaign name">
									<div class="text-danger">{{ $errors->first('name')}}</div>
								</div>

								<div class="col-md-6 form-group">
									<label>Service number</label>
									<input class="form-control" type="text" id="" required="" name="service_no" maxlength="26" value="{{ old('name') }}" placeholder="Enter Campaign name">
									<div class="text-danger">{{ $errors->first('name')}}</div>
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
								
								<div class="col-md-6 form-group" id="upload-data">
									<label>Upload Data</label> 
									<input type="file" class="form-control" accept=".csv" id="excel_file_upload" name="excel_file_upload" required=""
										value="{{ old('excel_file_upload') }}">
									<div class="text-danger">{{ $errors->first('excel_file_upload')}}</div>
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
