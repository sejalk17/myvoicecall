@extends('admin.layout.app')
@push('headerscript')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- DataTables -->
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
    rel="stylesheet" type="text/css" />
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
    rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css"
    integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js"
    integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
@section('content')
<div style="padding-top:10% !important">
    <div class="row">
        <div class="flash-message">
              @if (Session::has('message'))
                <center>
                    <h6 class="alert {{ Session::get('alert-class', 'alert-info') }}">
                        <b>{{ Session::get('message') }}</b>
                    </h6>
                </center>
                @endif
        </div> <!-- end .flash-message -->
    </div>
</div>
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
                                    <th>Report Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Bill Detail Report</td>
                                        <td><a href="{{ url('admin/report') }}" ><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                    
                                    <tr>
                                        <td>2</td>
                                        <td>Wallet Detail Report</td>
                                        <td><a href="{{ url('admin/walletreport') }}"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                            </tbody>
                        </table>
                       
                </div>
                 
                    <br> <br>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div> <!-- container-fluid -->
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

<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



@endpush