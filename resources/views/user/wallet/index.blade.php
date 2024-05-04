    @extends('user.layout.app')
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
                                        <h4 class="mb-0 f-26-bold">{{($userWallet) ? $userWallet : 0}}</h4>
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
                   
                <!-- end row -->
            </div>

            <div class="col-xl-12">
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="clearfix"></div>
                               
                                
                                <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                    width="100%" id="datatable">
                                    <thead>
                                      
                                        <tr>
                                            <th class="">
                                            S.NO.
                                        </th>
                                        <th class="">
                                            Date 
                                        </th>
                                        <!--    	<th class="">-->
                                        <!--    Transcation Type -->
                                        <!--</th>-->
                                       
                                             <th class="">
                                            Credit Amount
                                             </th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-wrapper" class="auto-load">
                                        @foreach($transcation as $key => $r)
                                        <tr>
                                            <td>{{ ($key+1) }}</td>
                                            <td>{{date('d-m-Y',strtotime($r->created_at))}}</td>
                                            <!-- <td>{{ ($r->transcation_type == 1) ? 'Promotional' : 'Transactional' }}</td> -->
                                            <!-- <td>₹{{ $r->debit_amount }}</td> -->
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
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> --}}
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

<script>
    var ENDPOINT = "{{request()->fullUrl()}}";
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
                datatype: "json",
                type: "get",
                data:{'page':page},
                success: function (response) {
                console.log(response);  
                if (response.html == '') {
                    return;
                }
                $("#data-wrapper").append(response.html);
            }
            });
            // .done(function (response) {
            //     console.log(response);  
            //     if (response.html == '') {
            //         return;
            //     }
  
            //     // $('.auto-load').hide();
            //     $("#data-wrapper").append(response.html);
            // });
//             $.ajax({
//              url:  ENDPOINT + "?page=" + page,
//             datatype: "json",
//             type: "get",
//              success: function (response) {
//             if(!response.nextpage_satus){
//          $('.getdata').hide();
//           }
//          $('.getdata').attr('data-id',response.nextpage);
//          $('#myTable').append(response.output);
//   },


// });
    }
</script>
<script type="text/javascript">
   
</script>
    @endpush
