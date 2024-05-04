    @extends('reseller.layout.app')
    @push('headerscript')
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />   
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
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
    .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    height: 38px !important;
    padding: 4px !important;
}
.select2-container {
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    position: relative;
    vertical-align: middle;
    width: 100% !important;
}
    </style>
    @endpush
    @section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="col-xl-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card mini-stats-wid bg-red">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-0 f-26-bold">{{($wallet) ? $wallet : 0}}</h4>
                                        <p class="text-bold-00">Promotioanl Balance</p>
                                    </div>
                                    <div class="flex-shrink-0 align-self-center">
                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                            <span class="avatar-title red">
                                                <i class="bx bx-copy-alt font-size-24"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card mini-stats-wid bg-darkblue">
                            <div class="card-body">
                                <div class="d-flex">
                                   
                                    <div class="flex-shrink-0 align-self-center ">
                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                            <span class="avatar-title rounded-circle darkblue ">
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

            <div class="col-xl-12">
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
                                        <div class="offset-sm-3 col-sm-3 mt-2"  style="float: right;">
                                            <div id="reportrange">
                                                <i class="fa fa-calendar icon-gradient"></i>
                                                <span>Filter By Date Range</span> <i class="fa fa-caret-down" style="float: right; margin-top: 7px;"></i>
                                            </div>
                                            <input type="hidden" name="start_date" id="start_date">
                                            <input type="hidden" name="end_date" id="end_date">
                                        </div>
                                            <div class="col-sm-3 mt-2">
                                                <select name="user" id="user" class="form-select selectpicker"  onchange="this.form.submit()">
                                                    <option value="">Filter By User</option>
                                                    <option @if(request()->user==Auth::user()->id) selected @endif value="{{Auth::user()->id}}">Your Transcation</option>
                                                    @foreach($user as $r)
                                                        <option @if(request()->user==$r->id) selected @endif value="{{$r->id}}">{{$r->first_name}} {{$r->last_name}}</option>
                                                    @endforeach
                                                </select>
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
                                        @if(request()->user)
                                        <tr style="background: #000;
                                        color: #fff;">
                                            <th>#</th>
                                            <th> @if($startDate != null && $endDate != null) {{ date('d-m-Y', strtotime($startDate)) }} - {{ date('d-m-Y', strtotime($endDate)) }} @elseif($transcation->count() != 0) {{date('d-m-Y',strtotime(@$transcation->first()->created_at))}} - {{date('d-m-Y')}} @endif</th>
                                            <th>Opening Balance</th>
                                            <th>₹{{$opening}}</th>
                                            <th>Closeing Balance</th>
                                            <th>₹{{$cloesing}}</th>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th class="@if($sort_f == 'id' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'id' && $sort_by == 'asc') sorting_asc @else sorting @endif" onclick="ascDescFilter('id');">
                                            S.NO.
                                        </th>
                                        <th class="@if($sort_f == 'created_at' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'created_at' && $sort_by == 'asc') sorting_asc @else sorting @endif" onclick="ascDescFilter('created_at');">
                                            Date 
                                        </th>
                                        <th class="@if($sort_f == 'created_by' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'created_by' && $sort_by == 'asc') sorting_asc @else sorting @endif" onclick="ascDescFilter('created_by');">
                                            Created By 
                                        </th>
                                            	<th class="@if($sort_f == 'transcation_type' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'transcation_type' && $sort_by == 'asc') sorting_asc @else sorting @endif" onclick="ascDescFilter('transcation_type');">
                                            Transcation Type 
                                        </th>
                                            	
                                        <th class="@if($sort_f == 'debit_amount' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'debit_amount' && $sort_by == 'asc') sorting_asc @else sorting @endif" onclick="ascDescFilter('debit_amount');">
                                            Debit Amount
                                             </th>
                                             <th class="@if($sort_f == 'credit_amount' && $sort_by == 'desc') sorting_desc @elseif($sort_f == 'credit_amount' && $sort_by == 'asc') sorting_asc @else sorting @endif" onclick="ascDescFilter('credit_amount');">
                                            Credit Amount
                                             </th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-wrapper" class="auto-load">
                                        @foreach($transcation as $key => $r)
                                        <tr>
                                            <td>{{ ($key+1) + ($transcation->currentPage() - 1)*$transcation->perPage() }}</td>
                                            <td>{{date('d-m-Y',strtotime($r->created_at))}}</td>
                                            <td>{{$r->created_by}}</td>
                                            <td>{{ ($r->transcation_type == 1) ? 'Promotional' : 'Transactional' }}</td>
                                            <td>₹{{ $r->debit_amount }}</td>
                                            <td>₹{{ $r->credit_amount }} </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <div style="float: right;">
                                    {{ $transcation->appends(request()->input())->links() }}
                                    
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @push('footerscript')
    <script src="{{asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('skote/layouts/assets/js/pages/datatables.init.js')}}"></script>
    <!-- Responsive examples -->
    <script src="{{asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
           $(".selectpicker").select2();
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




<script>

    var ENDPOINT =  "{{request()->fullUrl()}}";

    var page = 1;

  

    /*------------------------------------------

    --------------------------------------------

    Call on Scroll

    --------------------------------------------

    --------------------------------------------*/

    $(window).scroll(function () {

        if ($(window).scrollTop() + $(window).height() >= ($(document).height() - 1)) {

            page++;

            infinteLoadMore(page);

        }

    });

  

    /*------------------------------------------

    --------------------------------------------

    call infinteLoadMore()

    --------------------------------------------

    --------------------------------------------*/

    function infinteLoadMore(page) {

        $.ajax({
            url: ENDPOINT,
                datatype: "html",
                type: "get",
                data:{'page':page},
                beforeSend: function () {

                    // $('.auto-load').show();

                }

            })

            .done(function (response) {

                if (response.html == '') {

                    // $('.auto-load').html("We don't have more data to display :(");

                    return;

                }

  

                // $('.auto-load').hide();

                $("#data-wrapper").append(response.html);

            })

            .fail(function (jqXHR, ajaxOptions, thrownError) {

                // console.log('Server error occured');

            });

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
