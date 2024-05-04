@extends('superadmin.layout.app')
@push('headerscript')
    <!-- DataTables -->
    <link href="{{ asset('theme/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('theme/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('theme/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

@endpush
@section('content')
        <div class="page-content" style="padding-top:10% !important">
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
                                                         <strong>Action has been taken successfully!!
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
                                <h2 class="card-title text-center">Wallet Requests</h2>
                                <hr>
                                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Unique Id</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($amount as $r)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    @if ($r->status!=1)
                                                    {{ $r->name }}
                                                    @else
                                                    <a href="{{url("superadmin/approve/$r->unique_id")}}">{{ $r->name }}</a>
                                                    @endif    
                                                </td>
                                                <td>{{ $r->email }}</td>
                                                <td>{{ $r->amount }}</td>
                                                @if ($r->status == '1')
                                                    <td class="badge badge-pill badge-soft-warning font-size-11">Pending</td>
                                                @elseif($r->status=='2')
                                                    <td class="badge badge-pill badge-soft-success font-size-11">Approved</td>
                                                @else
                                                    <td class="badge badge-pill badge-soft-danger font-size-11">Rejected</td>
                                                @endif
                                                <td>{{ date('d M Y', strtotime($r->created_at)) }}</td>
                                                <td>{{ date('H:i:s A', strtotime($r->created_at)) }}</td>
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
    <script src="{{ asset('theme/layouts/assets/js/pages/form-validation.init.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('theme/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('theme/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('theme/layouts/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('theme/layouts/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('theme/layouts/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('theme/layouts/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('theme/layouts/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('theme/layouts/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('theme/layouts/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('theme/layouts/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('theme/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('theme/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
    <!-- Datatable init js -->
    <script src="{{ asset('theme/layouts/assets/js/pages/datatables.init.js') }}"></script>
    <script>
        $('.number').keyup(function(e) {
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
        });
    </script>
@endpush
