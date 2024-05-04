@extends('admin.layout.app')
@push('headerscript')
    <!-- DataTables -->
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

@endpush
@section('content')
    <div class="page-content" style="padding-top:6% !important">
<div class="flash-message">
                @if (Session::has('message'))
                <center>
                    <h6 class="alert {{ Session::get('alert-class', 'alert-info') }}">
                        <b>{{ Session::get('message') }}</b>
                    </h6>
                </center>
                @endif
            </div> <!-- end .flash-message -->
    <div class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h2 class="card-title text-center">Register View</h2>
                            <hr>
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                               
                                <thead>
                                   
                                    <tr>
                                        <th>S.No.</th>
                                        <th>Name</th>
                                        <th>Email ID</th>
					<th>Phone number</th>
                                        <th>cheque Image</th>
					<th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user as $r)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                            <h5 class="text-truncate font-size-14"><a
                                                href="javascript: void(0);"
                                                class="text-dark">{{ StrToUpper($r->name) }}</a>
                                            </h5>
                                            </td>
                                    
                                            <td>
                                               {{ $r->email}}
                             
                                            </td>
						@php
							$detail=App\Models\UserDetail::where('user_id',$r->id)->first();
					@endphp
						<td>{{ $detail->phone_no }}</td>
                                        <td><img src="{{ asset($detail->cheque) }}" height="100px"></td>
					<td><a href="{{ url('admin/registerapprove', $r->reference_id) }}" class="btn btn-success btn-sm">Approve</a> &nbsp; &nbsp; &nbsp; <a href="{{ url('admin/registerreject', $r->reference_id) }}" class="btn btn-danger btn-sm">Reject</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

@endsection
@push('footerscript')
    <script src="{{ asset('skote/layouts/assets/js/pages/form-validation.init.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('skote/layouts/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
    <!-- Datatable init js -->
    <script src="{{ asset('skote/layouts/assets/js/pages/datatables.init.js') }}"></script>
@endpush
