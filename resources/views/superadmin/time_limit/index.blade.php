@extends('superadmin.layout.app')
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
        <div class="page-content" style="padding-top:3% !important">
                <div class="row">
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if (Session::has('alert-' . $msg))
                                <section>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-12">
                                            <center>
                                                <div data-example-id="simple-alerts" class="bs-example">
                                                    <div role="alert" class="alert alert-success">
                                                        <strong>Thank you your request has been Submitted
                                                            Successfully! Please wait untill your Request Approves!
                                                        </strong>
                                                    </div>
                                                </div>
                                            </center>
                                        </div>
                                    </div>
                                </section>
                            @endif
                        @endforeach
                    </div> <!-- end .flash-message -->
                </div>
        </div>
        <div class="">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                
                                <h2 class="card-title text-center">Time Limit</h2>
                                <div class="col-md-4 mt-4">
                                         <a href="{{ route('time_limit.create')}}">  <input type="create_time" class="btn btn-primary" value="Create Time"></a> 
                                        </div>
                                <hr>
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Till Time</th>
                                            <th>Date</th>
                                            <th>Unique Id</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($time_limit as $r)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('time_limit.edit',$r->unique_id) }}">{{ date('H:i:s A',strtotime($r->time_limit)) }} </a></td>
                                                <td>{{date('d M Y', strtotime($r->date_limit)) }}</td>
                                                <td>{{ $r->unique_id }}</td>
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
    <script>
        $('.number').keyup(function(e) {
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
        });
    </script>
@endpush
