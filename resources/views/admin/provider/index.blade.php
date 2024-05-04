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
    <div class="page-content">
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
    
    <div class="">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h2 class="card-title text-center">Provider</h2>
                            <div class="col-md-4 mt-4">
                                <a href="{{ route('provider.create') }}"> <input type="create_amount"
                                        class="btn btn-primary" value="Create Provider"></a>
                            </div>
                            <hr>
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                               
                                <!-- <input type="button" name="check" value="Deselect All" class="btn btn-primary" onclick='deSelect()'> -->
                                <thead>
                                   
                                    <tr>
                                        {{-- <th><input type="checkbox" name="check" value="Check" class="btn btn-primary" onclick='selects()'> --}}
                                        </th>
                                        <th>S.No.</th>
                                        <th>Provider</th>
                                        <th>Cli</th>
                                        <th>Number</th>
                                        <th>Landline</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $r)
                                        <tr>
                                            {{-- <td><input type="checkbox" name="chk" id=""></td> --}}
                                            <td>{{ $loop->iteration }}</td>
                                           
                                        
                                            <td>
                                                {{ $r->provider }}
                                            </td>
                                            <td>
                                                {{ $r->cli }}
                                            </td>
                                            <td>
                                                {{ $r->number }}
                                            </td>
                                            <td>
                                                {{ $r->landline }}
                                            </td>
                                            <td>
                                                <a href="{{route('provider.edit',$r->unique_id)}}" class="btn btn-success btn-rounded"><i class="fa fa-pencil-alt"></i></a>
                                            </td>
                                           
                                           
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
