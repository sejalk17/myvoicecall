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
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0 font-size-18">Wallet Approval / Rejection</h4>
                            <div class="page-title-right">

                            </div>

                        </div>
                    </div>
                    <div class="flash-message">
                        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                            @if (Session::has('alert-' . $msg))
                                <section>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-12">
                                            <center>
                                                <div data-example-id="simple-alerts" class="bs-example">
                                                    <div role="alert" class="alert alert-danger">
                                                        <strong>The request you upodating is already updated please check
                                                            the same
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
                <!-- end page title -->

                <div class="row">
                    <div class="card border border-success">
                        <div class="col-lg-12">
                            <center>
                                <div class="card-header bg-transparent border-success">
                                    <h4 class="my-0 text-success"><i class="mdi mdi-check-all me-3"></i>Wallet Request from
                                        <u><em>{{ strtoupper($amount->name) }}</em></u> of Rs.
                                        <u><em>{{ $amount->amount }}</em></u>
                                    </h4>
                                </div>
                            </center>
                            <hr>

                            <div class="card-body">
                                <div class="row">

                                    <div class="col-sm-4 col-lg-4 col-xs-12">
                                        <h5 class="card-text">Retailer Name:- <u><em>{{ $amount->name }}</em></u>
                                        </h5>
                                        <h5 class="card-text">Requested Amount:-
                                            <u><em>{{ $amount->amount }}</em></u></h5>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4 col-lg-4 col-xs-12">
                                        <h5 class="card-text">Retailer Email:-<u><em>{{ $amount->email }}</em></u>
                                        </h5>
                                        <h5 class="card-text">Transaction
                                            ID:-<u><em>{{ $amount->unique_id }}</em></u></h5>
                                        <hr>
                                    </div>
                                    <div class="col-sm-4 col-lg-4 col-xs-12">
                                        <h5 class="card-text">Date of
                                            Request:-<u><em>{{ date('d M Y', strtotime($amount->created_at)) }}</em></u>
                                        </h5>
                                        <h5 class="card-text">Request
                                            Time:-<u><em>{{ date('H:i:s A', strtotime($amount->created_at)) }}</em></u>
                                        </h5>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="{{ url('superadmin/requestUpdate') }}" method="POST">
                            @csrf
                            <div class="row form-group">
                                <div class="col-lg-12">
                                    <textarea name="remark" class="form-control" rows="3"
                                        placeholder="Provide Appropriate Remark"></textarea>
                                    <div class="text-danger">{{ $errors->first('remark') }}</div>
                                    <input type="hidden" name="uid" value="{{ $amount->unique_id }}">
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-lg-12">
                                    <input type="submit" name="submit"
                                        class="btn btn-success waves-effect waves-light btn-sm" value="Approve">
                                    <input type="submit" name="submit"
                                        class="btn btn-danger waves-effect waves-light btn-sm" value="Reject">
                                </div>
                            </div>
                            <br>
                        </form>
                    </div>
                </div>
            </div> <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Skote.
                    </div>
                    <div class="col-sm-6">
                        <div class="text-sm-end d-none d-sm-block">
                            Design & Develop by Themesbrand
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

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
