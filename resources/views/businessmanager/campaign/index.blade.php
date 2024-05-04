@extends('businessmanager.layout.app')
@section('title', 'Sounds - All')
@push('headerscript')
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <style>
        .red-row {
            background-color: red !important;
            color: white !important;
        }
    </style>
    <style>
        .paging_simple_numbers {
            display: none !important;
        }

        .dataTables_info {
            display: none !important;
        }

        .dataTables_filter {
            display: none !important;
        }

        .dataTables_length {
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
                            <h4>Campaign</h4>
                            <a href="{{ route('businesscampaign.create') }}" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i> Create Campaign</a>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix"></div>
                                @php
                                    if ($sort_by == 'asc') {
                                        $sort = 'desc';
                                    } elseif ($sort_by == 'desc') {
                                        $sort = 'asc';
                                    } else {
                                        $sort = 'asc';
                                    }
                                @endphp
                                <form action="{{ request()->url() }}" id="searchForm" method="get">
                                    <input type="hidden" value="{{ $sort }}" name="sort_by" id="sort_by">
                                    <input type="hidden" name="sort_f"
                                        value="@if (isset(request()->sort_f)) {{ $sort_f }} @else id @endif"
                                        id="sort_f">
                                    <div class="row">
                                        <div class="col-sm-12">
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

                                            <div style="float: right;">
                                                <label>Search:<input type="search" value="{{ $search }}"
                                                        name="search" class="form-control input-sm" placeholder=""></label>
                                            </div>
                                        </div>
                                    </div>


                                </form>
                                <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                    width="100%" id="datatable">

                                    <thead>
                                        <tr>
                                            <th class="@if ($sort_f == 'id' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'id' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('id');">
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
                                            <th class="@if ($sort_f == 'created_by' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'created_by' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('created_by');">
                                                Created By
                                            </th>
                                            <th class="@if ($sort_f == 'total_count' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'total_count' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('total_count');">
                                                <input type="hidden" name="sort_by" value="{{ $sort }}">
                                                Total Count

                                            </th>
                                            <th class="@if ($sort_f == 'deliverCount' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'deliverCount' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('deliverCount');">
                                                distributions
                                            </th>
                                            <th class="@if ($sort_f == 'notDeliverCount' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'notDeliverCount' && $sort_by == 'asc') sorting_asc @else sorting @endif"
                                                onclick="ascDescFilter('notDeliverCount');">
                                                dialing_order
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
                                                @php
                                                    $user_detail = App\Models\User::where('id', $r->user_id)->first();
                                                @endphp
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        {{ $user_detail->first_name }} {{ $user_detail->last_name }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        {{ $r->totalcount }}
                                                    </span>
                                                </td>

                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        {{ $r->distributions }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        {{ $r->dialing_order }}

                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        <a href="{{ route('businesscampaign.show', $r->id) }}"
                                                            class="btn btn-primary btn-sm btn-rounded waves-effect waves-light"
                                                            title="View Details" target="_blank"> <i
                                                                class="fas fa-eye"></i></a>
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
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
@endsection
@push('footerscript')
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
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
        function ascDescFilter(id) {
            $('#sort_f').val(id);
            $('#searchForm').submit();
        }
    </script>
@endpush
