        @extends('admin.layout.app')
        @push('headerscript')
            <!-- DataTables -->
            <link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
                rel="stylesheet" type="text/css" />
            <link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
                rel="stylesheet" type="text/css" />
            <!-- Responsive datatable examples -->
            <link
                href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
                rel="stylesheet" type="text/css" />
            <link
                href="{{ asset('skote/layouts/assets/css/custom.css') }}"
                rel="stylesheet" type="text/css" />
            <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
        @endpush
        @section('content')
            <div class="page-content">
                <div class="container-fluid">
                    <!-- start page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <h2 class="mb-sm-0 font-size-32">{{ Auth::user()->first_name }}
                                    {{ Auth::user()->last_name }}</h2>
                                <div id="reportrange">
                                    <i class="fa fa-calendar icon-gradient"></i>
                                    <span></span> <i class="fa fa-caret-down"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end page title -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class=" p-2">
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 main-card  mb-2">
                                        <div class="card  bg-darkblue  mb-0">
                                            <div class="card-body">
                                                <div class="d-flex z-2">
                                                    <div class="flex-grow-1">
                                                        <p class="text-bold-00 z-2 ">Credit</p>
                                                        <h3 class="mb-0 f-26-bold z-2">{{ Auth()->user()->wallet }}</h3>
                                                  
                                                    </div>
                                                    <div class="flex-shrink-0 align-self-center icon-card">
                                                        <div class="mini-stat-icon ">
                                                            <span class="avatar-title ">
                                                                <i class="">
                                                                    <div class="ag-courses-item_bg"></div>
                                                                {{-- <img src="../skote/layouts/assets/images/icon/icon2.png" alt="icon" height="100%" width="100%" class="icon-av">    --}}
                                                                
                                                                </i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 main-card  mb-2">
                                        <div class="card  mini-stats-wid bg-red mb-0">
                                            <div class="ag-courses-item_bg"></div>
                                            <div class="card-body">
                                                <div class="d-flex z-2">
                                                    <div class="flex-grow-1">
                                                        <p class="text-bold-00 z-2">Campaign</p>
                                                        <h4 class="f-26-bold mb-0 z-2" id="campaign-count">0</h4>
                                               
                                                    </div>
                                                    <div class="flex-shrink-0 align-self-center icon-card">
                                                        <div class="mini-stat-icon ">
                                                            <span class="avatar-title">
                                                                <i class=" ">

                                                                    {{-- <img src="../skote/layouts/assets/images/icon/icon4.png" alt="icon" height="100%" width="100%" class="icon-av">    --}}
                                                                </i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 main-card  mb-2 ">
                                        <div class="card  mini-stats-wid bg-blue  mb-0">
                                            <div class="ag-courses-item_bg"></div>
                                            <div class="card-body">
                                                <div class="d-flex z-2">
                                                    <div class="flex-grow-1">
                                                        <p class="text-bold-00 z-2">Answered</p>
                                                        <h4 class="f-26-bold mb-0 z-2" id="answered-count">0
                                                        </h4>
                                                   
                                                    </div>
                                                    <div class="flex-shrink-0 align-self-center icon-card ">
                                                        <div class="  mini-stat-icon">
                                                            <span class="avatar-title ">
                                                                <i class=" "> 
                                                                  
                                                                    {{-- <img src="../skote/layouts/assets/images/icon/icon1.png" alt="icon" height="100%" width="100%" class="icon-av">    --}}
                                                                </i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-12 main-card  mb-2 ">
                                        <div class="card  mini-stats-wid bg-brown mb-0">
                                            <div class="ag-courses-item_bg"></div>
                                            <div class="card-body">
                                                <div class="d-flex z-2">
                                                    <div class="flex-grow-1">
                                                        <p class="text-bold-00 z-2">No Answered</p>
                                                        <h4 class="f-26-bold mb-0 z-2" id="notanswered-count">
                                                            0</h4>
                                                        
                                                    </div>
                                                    <div class="flex-shrink-0 align-self-center icon-card">
                                                        <div class=" mini-stat-icon">
                                                            <span class="avatar-title">
                                                                <i class=" ">
                                                                  
                                                                    {{-- <img src="../skote/layouts/assets/images/icon/icon3.png" alt="icon" height="100%" width="100%" class="icon-av">    --}}
                                                                </i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                                         
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title mb-4">Latest Campaign</h4>
                                    <div class="table-responsive">
                                        <table class="table align-middle table-nowrap mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="align-middle">S.NO.</th>
                                                    <th class="align-middle">Date</th>
                                                    <th class="align-middle">Campaign Name</th>
                                                    <th class="align-middle">Created By</th>
                                                    <th class="align-middle">Total Count</th>
                                                    <th class="align-middle">Answered</th>
                                                    <th class="align-middle">Not Answered</th>
                                                    <th class="align-middle">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($campaign as $r)
                                                    <tr>
                                                        <td class="product-p">
                                                            <span class="product-price-wrapper">
                                                                <span class="">{{ $loop->iteration }}</span>
                                                            </span>
                                                        </td>
                                                        <td class="product-headline text-left wide-column">
                                                            <span class="product-price-wrapper">
                                                                {{ date('d-m-Y', strtotime($r->created_at)) }}
                                                            </span>
                                                        </td>
                                                        <td class="product-headline text-left wide-column">
                                                            <span class="product-price-wrapper">
                                                                {{ $r->campaign_name }}
                                                            </span>
                                                        </td>
                                                        @php
                                                            $user_detail = App\Models\User::where(
                                                                'id',
                                                                $r->user_id,
                                                            )->first();
                                                        @endphp
                                                        <td class="product-headline text-left wide-column">
                                                            <span class="product-price-wrapper">
                                                                {{ $user_detail->first_name }}
                                                                {{ $user_detail->last_name }}
                                                            </span>
                                                        </td>
                                                        <td class="product-headline text-left wide-column">
                                                            <span class="product-price-wrapper">
                                                                {{ $r->total_count }}
                                                            </span>
                                                        </td>
                                                        <td class="product-headline text-left wide-column">
                                                            <span class="product-price-wrapper">
                                                                {{ $r->success_count }}
                                                                <!--{{ $r->deliverCount == null ? '0' : $r->deliverCount }}-->
                                                            </span>
                                                        </td>
                                                        <td class="product-headline text-left wide-column">
                                                            <span class="product-price-wrapper">
                                                                {{ $r->failed_count }}
                                                                <!--{{ $r->notDeliverCount == null ? '0' : $r->notDeliverCount }}-->
                                                            </span>
                                                        </td>
                                                        <td class="product-headline text-left wide-column">
                                                            <a href="{{ route('campaign.show', $r->id) }}"
                                                                class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                                title="View Details" target="_blank">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            <a href="{{ url('admin/campaign/downloadFile', $r->id) }}"
                                                                class="btn btn-success btn-sm btn-rounded waves-effect waves-light"
                                                                title="Download Report">
                                                                <i class="bx bx-download"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>
                            </div>
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
                    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
                    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
                    <script>
                        $('.number').keyup(function(e) {
                            if (/\D/g.test(this.value)) {
                                this.value = this.value.replace(/\D/g, '');
                            }
                        });
                    </script>
                    <script type="text/javascript">
                        jQuery(function() {
                            var start = moment().startOf('year');
                            var end = moment();
                            function cb(start, end) {
                                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                                //    alert(start.format('YYYY-M-D'));
                                //    alert(end.format('YYYY-M-D'));
                                $.ajax({
                                    url: "{{ route('admin.filterDateBase') }}",
                                    method: 'GET',
                                    dataType: "json",
                                    data: {
                                        'start': start.format('YYYY-MM-DD'),
                                        'end': end.format('YYYY-MM-DD')
                                    },
                                    success: function(response) {
                                        $('#campaign-count').text(response.campaign);
                                        $('#answered-count').text(response.answered);
                                        $('#notanswered-count').text(response.notanswered);
                                    },
                                    error: function(xhr, status, error) {
                                        console.log('error:' + error);
                                    }
                                });
                            }
                            $('#reportrange').daterangepicker({
                                startDate: start,
                                endDate: end,
                                ranges: {
                                    'Today': [moment(), moment()],
                                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                                        'month').endOf('month')],
                                    'This Year': [moment().startOf('year'), moment().endOf('year')]
                                }
                            }, cb);
                            cb(start, end);
                        });
                    </script>
                @endpush
