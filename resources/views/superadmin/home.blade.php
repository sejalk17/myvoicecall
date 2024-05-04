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


    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">{{ Auth::user()->name }}</h4>


                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-4">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-3">
                                        <h5 class="text-primary">Welcome Back !</h5>
                                        <p>Shree Pe Dashboard</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="{{ asset('skote/layouts/assets/images/profile-img.png') }}" alt=""
                                        class="img-fluid">
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Wallet Balance</p>
                                            <h4 class="mb-0">₹ {{ $wallet_balance }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card mini-stats-wid">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <p class="text-muted fw-medium">Todays Approval</p>
                                            <h4 class="mb-0">₹ {{ $todays }}</h4>
                                        </div>

                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle bg-primary">
                                                    <i class="bx bx-archive-in font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                      
                    </div>
                    <!-- end row -->


                </div>
            </div>
            <!-- end row -->
            <hr>
            <div class="container-fluid">
                <div class="col-xl-12">
                    <div class="row">
                        <!-- <div class="col-xl-4">
                                        <div class="card overflow-hidden">
                                            <div class="bg-primary bg-soft">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="text-primary p-3">
                                                            <h5 class="text-primary">Superdistributor</h5>
                                                            <p>Shree Pe Dashboard</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-5 align-self-end">
                                                        <img src="{{ asset('skote/layouts/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>
                                      
                                    </div> -->
                        <!-- <div class="col-xl-4">
                                        <div class="card overflow-hidden">
                                            <div class="bg-primary bg-soft">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="text-primary p-3">
                                                            <h5 class="text-primary">Distributor</h5>
                                                            <p>Shree Pe Dashboard</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-5 align-self-end">
                                                        <img src="{{ asset('skote/layouts/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>
                                      
                                    </div> -->
                        <!-- <div class="col-xl-4">
                                        <div class="card overflow-hidden">
                                            <div class="bg-primary bg-soft">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="text-primary p-3">
                                                            <h5 class="text-primary">Retailer</h5>
                                                            <p>Shree Pe Dashboard</p>
                                                        </div>
                                                    </div>
                                                    <div class="col-5 align-self-end">
                                                        <img src="{{ asset('skote/layouts/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                          
                                        </div>
                                      
                                    </div> -->


                    </div>
                </div>
              
                <div class="row">
                   
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">All Bill Transaction</p>
                                                <h4 class="mb-0">₹ {{ $wallet_balance }}</h4>
                                            </div>
    
                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-copy-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Bank Wallet Transaction</p>
                                                <h4 class="mb-0">₹ {{ $todays }}</h4>
                                            </div>
    
                                            <div class="flex-shrink-0 align-self-center ">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        <i class="bx bx-archive-in font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Personal Wallet Transaction</p>
                                                <h4 class="mb-0">₹16.2</h4>
                                            </div>
    
                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
    
    <hr>
                    </div>
                </div>
                <div class="row">
    
                    <div class="col-xl-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Total Work</p>
                                                <h4 class="mb-0">₹ {{ $wallet_balance }}</h4>
                                            </div>
    
                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                    <span class="avatar-title">
                                                        <i class="bx bx-copy-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Month Work</p>
                                                <h4 class="mb-0">₹ {{ $todays }}</h4>
                                            </div>
    
                                            <div class="flex-shrink-0 align-self-center ">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        <i class="bx bx-archive-in font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card mini-stats-wid">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium">Today Work</p>
                                                <h4 class="mb-0">₹16.2</h4>
                                            </div>
    
                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                    <span class="avatar-title rounded-circle bg-primary">
                                                        <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
    
    
                    </div>
                </div>
    
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Superdistributor</h4>
                                <p class="card-title-desc">Lower Hierarchy Super Distributor</p>

                                <div class="d-flex flex-wrap gap-2">
                                    <!-- Extra Large modal button -->
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-xl">View All</button>

                                    <!-- Large modal button -->


                                    <!-- Small modal button -->

                                </div>

                                <div>
                                    <!--  Extra Large modal example -->
                                    <div class="modal fade bs-example-modal-xl" tabindex="-1" role="dialog"
                                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myExtraLargeModalLabel">View All
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="page-content">
                                                        <table id="datatable-buttons"
                                                            class="table table-bordered dt-responsive nowrap w-100">
                                                            <tr>
                                                                <th scope="col" style="width: 100px">#</th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Added Date</th>
                                                                <th scope="col">Added day and time</th>
                                                                <th scope="col">Available Balance</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($superdistributors as $r)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        <td>
                                                                            <h5 class="text-truncate font-size-14"><a
                                                                                    href="javascript: void(0);"
                                                                                    class="text-dark">{{ StrToUpper($r->name) }}</a>
                                                                            </h5>
                                                                            <p class="text-muted mb-0">{{ $r->email }}
                                                                            </p>
                                                                        </td>
                                                                        <td>{{ date('d F Y', strtotime($r->created_at)) }}
                                                                        </td>
                                                                        <td>{{ date('D H:I:s', strtotime($r->created_at)) }}
                                                                        </td>
                                                                        @php
                                                                            $wallet = App\models\Wallet::where('user_id', $r->id)->value('amount');
                                                                        @endphp
                                                                        <td>
                                                                            <h6 class="">₹
                                                                                {{ $wallet }}</h6>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    <!--  Large modal example -->
                                    <!-- /.modal -->

                                    <!--  Small modal example -->
                                    <!-- /.modal -->

                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Distributor</h4>
                                <p class="card-title-desc">Lower Hierarchy Distributor</p>

                                <div class="d-flex flex-wrap gap-2">
                                    <!-- Extra Large modal button -->
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-x2">View All</button>

                                    <!-- Large modal button -->

                                </div>

                                <div>
                                    <!--  Extra Large modal example -->
                                    <div class="modal fade bs-example-modal-x2" tabindex="-1" role="dialog"
                                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myExtraLargeModalLabel">View All</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="page-content">
                                                        <table id="datatable-buttons"
                                                            class="table table-bordered dt-responsive nowrap w-100">
                                                            <tr>
                                                                <th scope="col" style="width: 100px">#</th>
                                                                <th scope="col">Name</th>
                                                                <th scope="col">Superdistributor</th>
                                                                <th scope="col">Added Date</th>
                                                                <th scope="col">Added day and time</th>
                                                                <th scope="col">Available Balance</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($distributors as $r)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        @php
                                                                            $sd_name = App\models\User::where('id', $r->sd_id)->value('name');
                                                                        @endphp
                                                                        <td>
                                                                            <h5 class="text-truncate font-size-14"><a
                                                                                    href="javascript: void(0);"
                                                                                    class="text-dark">{{ StrToUpper($r->name) }}</a>
                                                                            </h5>
                                                                            <p class="text-muted mb-0">{{ $r->email }}
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <h5 class="text-truncate font-size-14"><a
                                                                                    href="javascript: void(0);"
                                                                                    class="text-dark">{{ StrToUpper($sd_name) }}</a>
                                                                            </h5>

                                                                        </td>
                                                                        <td>{{ date('d F Y', strtotime($r->created_at)) }}
                                                                        </td>
                                                                        <td>{{ date('D H:I:s', strtotime($r->created_at)) }}
                                                                        </td>
                                                                        @php
                                                                            $wallet = App\models\Wallet::where('user_id', $r->id)->value('amount');
                                                                        @endphp
                                                                        <td>
                                                                            <h6 class="">₹
                                                                                {{ $wallet }}</h6>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    <!--  Large modal example -->
                                    <!-- /.modal -->

                                    <!--  Small modal example -->
                                    <!-- /.modal -->

                                </div>

                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Retailer</h4>
                                <p class="card-title-desc">Lower Hierarchy Retailer </code>.</p>

                                <div class="d-flex flex-wrap gap-2">
                                    <!-- Extra Large modal button -->
                                    <button type="button" class="btn btn-primary waves-effect waves-light"
                                        data-bs-toggle="modal" data-bs-target=".bs-example-modal-x3">View All</button>

                                    <!-- Large modal button -->

                                </div>

                                <div>
                                    <!--  Extra Large modal example -->
                                    <div class="modal fade bs-example-modal-x3" tabindex="-1" role="dialog"
                                        aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myExtraLargeModalLabel">View All</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="page-content">
                                                        <table id="datatable-buttons"
                                                            class="table table-bordered dt-responsive nowrap w-100">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col" style="width: 100px">#</th>
                                                                    <th scope="col">Name</th>
                                                                    <th scope="col">Superdistributor</th>
                                                                    <th scope="col">Distributor</th>
                                                                    <th scope="col">Added Date</th>
                                                                    <th scope="col">Added day and time</th>
                                                                    <th scope="col">Available Balance</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($retailers as $r)
                                                                    <tr>
                                                                        <td>{{ $loop->iteration }}</td>
                                                                        @php
                                                                            $sd_name = App\models\User::where('id', $r->sd_id)->value('name');
                                                                            $d_name = App\models\User::where('id', $r->d_id)->value('name');
                                                                        @endphp
                                                                        <td>
                                                                            <h5 class="text-truncate font-size-14"><a
                                                                                    href="javascript: void(0);"
                                                                                    class="text-dark">{{ StrToUpper($r->name) }}</a>
                                                                            </h5>
                                                                            <p class="text-muted mb-0">{{ $r->email }}
                                                                            </p>
                                                                        </td>
                                                                        <td>
                                                                            <h5 class="text-truncate font-size-14"><a
                                                                                    href="javascript: void(0);"
                                                                                    class="text-dark">{{ StrToUpper($sd_name) }}</a>
                                                                            </h5>

                                                                        </td>
                                                                        <td>
                                                                            <h5 class="text-truncate font-size-14"><a
                                                                                    href="javascript: void(0);"
                                                                                    class="text-dark">{{ StrToUpper($d_name) }}</a>
                                                                            </h5>

                                                                        </td>

                                                                        <td>{{ date('d F Y', strtotime($r->created_at)) }}
                                                                        </td>
                                                                        <td>{{ date('D H:I:s', strtotime($r->created_at)) }}
                                                                        </td>
                                                                        @php
                                                                            $wallet = App\models\Wallet::where('user_id', $r->id)->value('amount');
                                                                        @endphp
                                                                        <td>
                                                                            <h6 class="">₹
                                                                                {{ $wallet }}</h6>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->

                                            <!--  Large modal example -->
                                            <!-- /.modal -->

                                            <!--  Small modal example -->


                                        </div>

                                    </div>
                                    <!-- end card body -->
                                </div>
                                <!-- end card -->
                            </div>

                            <!-- end col -->
                        </div>
                    </div>
                    <hr>
                    <!-- end row -->
                </div>
                <!-- container-fluid -->
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
