@extends('reseller.layout.app')
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
                            <form method="POST" action="{{ route('resellercampaign.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                <div class="col-md-6 form-group">
                                    <label>User</label>
                                    <select name="user_id" required="" class="form-control">
                                    <option value="{{Auth::user()->id}}">My self</option>
                                    @foreach ($userData as $key)
                                        <option value="{{$key->id}}">{{ $key->first_name }} {{ $key->last_name }}</option>
                                    @endforeach
                                    </select>
                                    <div class="text-danger">{{ $errors->first('type')}}</div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Upload file</label>
                                    <input type="file" class="form-control" accept=".csv" name="excel_file_upload" required=""
                                    value="{{ old('excel_file_upload') }}">
                                    <div class="text-danger">{{ $errors->first('excel_file_upload')}}</div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Campaign Name</label>
                                    <input class="form-control" type="text" id="" name="campaign_name" value="{{ old('campaign_name') }}" required="">
                                    <div class="text-danger">{{ $errors->first('campaign_name')}}</div>
                                </div>
                                
                                <div class="col-md-6 form-group">
                                    <label>Service No.</label>
                                    <select name="service_no" required="" class="form-select">
                                        <option value="">Select Type</option>
                                        <option value="7317109076">7317109076</option>
                                    </select>
                                    <div class="text-danger">{{ $errors->first('service_no')}}</div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Campaign Type</label>
                                    <select name="type" required="" class="form-select">
                                        <option value="">Select Type</option>
                                        @foreach ($soundType as $key => $value)
                                            <option value="{{$key}}">{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger">{{ $errors->first('type')}}</div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Voice List</label>
                                    <select name="voiceclip" required="" class="form-select" require="">
                                        <option value="">Select Type</option>
                                        @foreach ($soundList as $r)
                                            <option value="{{$r->id}}">{{ $r->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="text-danger">{{ $errors->first('voiceclip')}}</div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Retry Attempt</label>
                                    <select name="retry_attempt" required="" class="form-select">
                                        <option value="0">No Retry</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                    </select>
                                    <div class="text-danger">{{ $errors->first('retry_attempt')}}</div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Dur. Between Retry(In hours)</label>
                                    <select name="retry_duration" required="" class="form-select">
                                        <option value="0">Immediate</option>
                                        <option value="15">15 min</option>
                                        <option value="30">30 min</option>
                                        <option value="60">1 Hr</option>
                                    </select>
                                    <div class="text-danger">{{ $errors->first('retry_duration')}}</div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Schedule</label>
                                    <div class="form-check mb-3">
                                    <input type="radio" id="now" name="schedule" value="0" checked>
                                    <label for="now">Now</label>&nbsp;&nbsp;
                                    <input type="radio" id="later" name="schedule" value="1">
                                    <label for="later">Later</label>
                                    <div class="text-danger">{{ $errors->first('schedule')}}</div>
                                    </div>
                                </div>
                                <div class="col-md-6 form-group" id="schedule" style="display: none;">
                                    <label>Schedule date</label>
                                    <input type="text" class="form-control" name="schedule_datetime" id="schedule_datetime" value="{{ old('schedule_datetime') }}" placeholder="dd/mm/yyyy hh:mm"/>
                                    <div class="text-danger">{{ $errors->first('schedule_datetime')}}</div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Plan End date</label>
                                    <input class="form-control" type="text" id="camp_end_datetime" name="camp_end_datetime" value="{{ old('camp_end_datetime') }}" placeholder="dd/mm/yyyy hh:mm">
                                    <div class="text-danger">{{ $errors->first('camp_end_datetime')}}</div>
                                </div>

                                

                                <br>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group">
                                        <button name="submitBtn" class="btn btn-success" type="submit">Save</button>
                                        <button class="btn btn-default m-l-15" type="reset">Cancel</button>
                                </div>
                            </form>
                            </div> <!-- end col -->
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>



@endsection
@push('footerscript')

<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.js"></script>
<script>
        jQuery('#schedule_datetime').datetimepicker();
        jQuery('#camp_end_datetime').datetimepicker({
            language: 'en',
            format: 'yyyy-MM-dd hh:mm'
        });
    </script>
    <script>
        const showInputRadio = document.getElementById('later');
        const hideInputRadio = document.getElementById('now');
        const inputBox = document.getElementById('schedule');

        showInputRadio.addEventListener('change', function () {
            if (showInputRadio.checked) {
                inputBox.style.display = 'block';
            }
        });

        hideInputRadio.addEventListener('change', function () {
            if (hideInputRadio.checked) {
                inputBox.style.display = 'none';
            }
        });
    </script>
@endpush
