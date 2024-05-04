@extends('user.layout.app')
@section('title', 'XLSX - All')
@push('headerscript')
<style>
    #reportrange {
    background: #fff;
    min-width: 100%;
    cursor: pointer;
    padding: 3px 10px;
    border: 1px solid #ced4da;
    /* border: 1px solid #50a5f1; */
    display: inline-block;
    font-size: 16px;
    border-radius: 5px;
    color: #595c6c;
    }
</style> 
 {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" integrity="sha512-mR/b5Y7FRsKqrYZou7uysnOdCIJib/7r5QeJMFvLNHNhtye3xJp1TdJVPLtetkukFn227nKpXD9OjUc09lx97Q==" crossorigin="anonymous"
referrerpolicy="no-referrer" /> --}}
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <style>
        .red-row {
            background-color: red !important;
            color: white !important;
        }
    </style>
       <style>
        .paging_simple_numbers{
            display: none !important;
        }
        .dataTables_info{
            display: none !important;
        }
        .dataTables_filter{
            display: none !important;
        }
        .dataTables_length{
            display: none !important;
        }
    </style>
@endpush
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
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
                            <h4>Campaign Report</h4>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                        <div class="card">
                        <form method="POST" id="campaign_form" action="{{ route('userreport.xlsxstore') }}" enctype="multipart/form-data">
							@csrf
                            <div class="row">
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
@endsection
@push('footerscript')
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script> --}}
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/js/pages/datatables.init.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    
   
@endpush
