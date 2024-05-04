@extends('user.layout.app')
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
                                    <h4 class="mb-sm-0 font-size-18">Add Voice File</h4>
                                </div>
                            </div>
                        </div>
    
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                            <form method="POST" action="{{ route('usersound.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">

                                <div class="col-md-6 form-group">
                                    <label>File Name</label>
                                    <input class="form-control" type="text" id="camp_end_datetime" name="name" value="{{ old('name') }}" placeholder="Enter File name">
                                    <div class="text-danger">{{ $errors->first('name')}}</div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Type</label>
                                    <select name="type" required="" class="form-select">
                                        <option value="transactional">OBD </option>
                                     
                                    </select>
                                    <div class="text-danger">{{ $errors->first('type')}}</div>
                                </div>
                          
                                <div class="col-md-6 form-group">
                                    <label>Upload file</label>
                                    Please convert your file <a href="https://audio.online-convert.com/convert-to-wav" target="_blank">from here </a> 
                                    <br/>Please use 8 Bit, Mono, 8000 Rate(Hz), Use only wav file.
                                    <input type="file" class="form-control" accept="audio/mp3,audio/wav" name="voiceclip" required=""
                                    value="{{ old('voiceclip') }}">
                                    <div class="text-danger">{{ $errors->first('voiceclip')}}</div>
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
            </div> <!-- container -->
        </div> <!-- content -->
    </div>



@endsection
@push('footerscript')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('theme/default/assets/js/fastclick.js')}}"></script>
 <script src="{{ asset('theme/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>

<script>
        $('#datepicker-autoclose').datepicker();
    </script>
@endpush
