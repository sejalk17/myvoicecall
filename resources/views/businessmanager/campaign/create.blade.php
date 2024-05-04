@extends('businessmanager.layout.app')
@section('title', 'Create Campaign')
@push('headerscript')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css"
        rel="stylesheet" type="text/css">
    <link href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
    <style>
        .col-md-6 {
            margin-bottom: 10px;
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
                                <form method="POST" action="{{ route('businesscampaign.store') }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label>Campaign Name <span class="text-danger"> *</span></label>
                                            <input class="form-control" required="" placeholder="Enter Campaign Name"
                                                type="text" id="" name="campaign_name"
                                                value="{{ old('campaign_name') }}" required="">
                                            <div class="text-danger">{{ $errors->first('campaign_name') }}</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Distribution<span class="text-danger"> *</span></label>
                                            <select name="distribution" required="" class="form-select"
                                                id="distribution">
                                                <option value="">Select Type</option>
                                                <option value="equally" selected>Equally</option>
                                                <option value="agentwise">Agent wise</option>
                                            </select>
                                            <div class="text-danger">{{ $errors->first('distribution') }}</div>
                                        </div>
                                        @php
                                            $downline = App\Models\User::where('parent_id', Auth::user()->id)->get();
                                        @endphp
                                        <div class="col-md-6 form-group" id="agentwise" style="display: none">
                                            <label>Agent List<span class="text-danger"> *</span></label>
                                            <select name="agent" class="form-select">
                                                <option value="">Select Agent</option>
                                                @foreach ($downline as $r)
                                                    <option value="{{ $r->id }}"> {{ $r->first_name }}
                                                        {{ $r->last_name }} - {{ $r->username }}</option>
                                                @endforeach
                                            </select>
                                            <div class="text-danger">{{ $errors->first('agent') }}</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Form<span class="text-danger"> *</span></label>
                                            <select name="form" required="" class="form-select">
                                                <option value="">Select Form</option>
                                                <option value="basic" selected>Basic Form</option>
                                            </select>
                                            <div class="text-danger">{{ $errors->first('retry_duration') }}</div>
                                        </div>
                                       
                                        <div class="col-md-6 form-group">
                                            <label>Upload file<span class="text-danger"> *</span></label>
                                            <input type="file" class="form-control" accept=".csv"
                                                name="excel_file_upload" required=""
                                                value="{{ old('excel_file_upload') }}">
                                            <div class="text-danger">{{ $errors->first('excel_file_upload') }}</div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label>Dialing Order<span class="text-danger"> *</span></label>
                                            <div class="form-check mb-3">
                                                <input type="radio" name="order" required="" value="Ascending" checked>
                                                <label for="now">Ascending</label>&nbsp;&nbsp;
                                                <input type="radio" name="order" value="Decending" required="">
                                                <label for="later">Decending</label>
                                                <div class="text-danger">{{ $errors->first('schedule') }}</div>
                                            </div>
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
    <script>
        const showInputRadio = document.getElementById('later');
        const hideInputRadio = document.getElementById('now');
        const inputBox = document.getElementById('schedule');
        showInputRadio.addEventListener('change', function() {
            if (showInputRadio.checked) {
                inputBox.style.display = 'block';
            }
        });
        hideInputRadio.addEventListener('change', function() {
            if (hideInputRadio.checked) {
                inputBox.style.display = 'none';
            }
        });
    </script>
    <script>
        // Wait for the document to be ready
        $(document).ready(function() {
            // Bind change event handler to the #distribution element
            $('#distribution').change(function() {
                // Check if the selected option's ID is "agentwise"
                if ($(this).val() === 'agentwise') {
                    // If it is, show the #agentwise element
                    $('#agentwise').show();
                } else {
                    // If not, hide the #agentwise element
                    $('#agentwise').hide();
                }
            });
        });
    </script>
@endpush
