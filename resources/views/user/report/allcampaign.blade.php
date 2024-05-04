@extends('user.layout.app')
@section('title', 'Sounds - All')
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
                            <div class="card-body">
                                <div class="clearfix"></div>
                                @php
                                if($sort_by == 'asc'){
                                  $sort = 'desc';
                                }
                                elseif($sort_by == 'desc'){
                                $sort = 'asc';
                                }else{
                                $sort = 'asc';
                                 }
                                @endphp
                                <form action="{{ request()->url() }}" id="searchForm" method="get">
                                    <input type="hidden" value="{{$sort}}" name="sort_by" id="sort_by">
                                    <input type="hidden" name="sort_f" value="@if(isset(request()->sort_f)) {{ $sort_f}} @else id @endif" id="sort_f">
                                    <div class="row">
                                        <div class="col-sm-3 mt-2">
                                            <label>Show
                                                <select name="paginate" onchange="this.form.submit()" id="paginate"
                                                    class="form-control input-sm width-auto d-inline-block"
                                                    style="width:auto">
                                                    <option @if ($paginate == 10) selected @endif
                                                        value="10">10</option>
                                                    <option @if ($paginate == 25) selected @endif
                                                        value="25">25</option>
                                                    <option @if ($paginate == 50) selected @endif
                                                        value="50">50</option>
                                                    <option @if ($paginate == 100) selected @endif
                                                        value="100">100</option>
                                                </select> entries</label>
                                        </div>

                                            <div class="offset-sm-3 col-sm-3 mt-2"  style="float: right;">
                                                <div id="reportrange">
                                                    <i class="fa fa-calendar icon-gradient"></i>
                                                    <span>Filter By Date Range</span> <i class="fa fa-caret-down" style="float: right; margin-top: 7px;"></i>
                                                </div>
                                                <input type="hidden" name="start_date" id="start_date">
                                                <input type="hidden" name="end_date" id="end_date">
                                            </div>
                                            <div class="col-sm-3 mt-2">
                                                <input type="search" value="{{ $search }}"
                                                        name="search" class="form-control input-sm" placeholder="Search">

                                            </div>
                                        </div>
                                </form>
                                <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                    width="100%" id="datatable">
                                    
                                    <thead>
                                        <tr>
                                            <th class="@if ($sort_f == 'id' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'id' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('s-no');">
                                                    S.NO.
                                            </th>
                                            <th class="@if ($sort_f == 'created_at' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'created_at' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('created_at');">
                                                    Date
                                            </th>
                                            <th class="@if ($sort_f == 'campaign_name' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'campaign_name' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('campaign_name');">
                                                    Campaign Name
                                            </th>
                                           
                                            <th class="@if ($sort_f == 'total_count' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'total_count' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('total_count');">
                                                    Total Count
                                            </th>
                                            <th class="@if ($sort_f == 'deliverCount' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'deliverCount' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('deliverCount');">
                                                    Answered
                                            </th>
                                            <th class="@if ($sort_f == 'notDeliverCount' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'notDeliverCount' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('notDeliverCount');">
                                                    <input type="hidden" name="sort_by" value="{{ $sort }}">
                                                    Not Answered
                                            </th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($campaign as $key => $r)
                                            <tr>
                                                <td class="product-p">
                                                    <span class="product-price-wrapper">
                                                        <span
                                                            class="">{{ $key + 1 + ($campaign->currentPage() - 1) * $campaign->perPage() }}</span>
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
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        {{ $r->total_count }}
                                                    </span>
                                                </td>
                                               
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        {{ $r->success_count }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        {{  $r->failed_count }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        @if (Auth::user()->block_view == 1)
                                                        <a href="{{ route('usercampaign.show', $r->id) }}" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light" title="View Details" target="_blank">  <i class="fas fa-eye"></i></a>
                                                        @endif

                                                        @if (Auth::user()->block_download == 1)
                                                        <a href="{{ url('user/usercampaign/downloadFile',$r->id) }}" class="btn btn-success btn-sm btn-rounded waves-effect waves-light" title="Download Report"> <i class="bx bx-download f-17 mr-1"></i> </a>
                                                        @endif
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div style="float: right;">
                                    {{ $campaign->appends(request()->input())->links() }}
                                </div>
                            </div>
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
    
    <script>
        $("#datatable").dataTable({
            "processing": false, // for show progress bar
            "paging": false, // for disable paging
            "filter": false,
            "ordering": false, // this is for disable sort order
            "orderMulti": false, // for disable multiple column at once
        });
    </script>

    <script>
         function ascDescFilter(id){
            $('#sort_f').val(id);
            $('#searchForm').submit();
        }
    </script>
    <script type="text/javascript">
        jQuery(function() {
            @if ($startDate != null && $endDate != null)
                var start = moment("{{ $startDate }}", "YYYY-MM-DD");
                var end = moment("{{ $endDate }}", "YYYY-MM-DD")
            @else
                var start = moment().subtract(1, 'month').endOf('month');
                var end = moment();
            @endif
            function cb(start, end) {
                if (start._isValid && end._isValid) {
                    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#start_date').val(start.format('YYYY-MM-DD'));
                    $('#end_date').val(end.format('YYYY-MM-DD'));
                } else {
                    $('#reportrange span').html('Filter By Date Range');
                    $('#start_date').val(null);
                    $('#end_date').val(null);
                }
                $('#searchForm').submit();
            }

            function cb1() {
                var startDate = "{{ date('F, d Y', strtotime($startDate)) }}";
                var endDate = "{{ date('F, d Y', strtotime($endDate)) }}";
                $('#reportrange span').html(startDate + ' - ' + endDate);
                $('#start_date').val("{{ $startDate }}");
                $('#end_date').val("{{ $endDate }}");
            }

            $('#reportrange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Clear Dates': [null, null],
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')]
                },
                locale: {
                    format: 'MM/DD/YYYY' // Format for the selected date range
                }
            }, cb);

            @if ($startDate != null && $endDate != null)
                cb1();
            @endif
        });
    </script>
@endpush
