    @extends('admin.layout.app')
    @section('title', 'Users - All')
    @push('headerscript')
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />     
    <style>
    .red-row {
        background-color: red !important;
        color:white !important;
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
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
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
                                        <h4 class="mb-sm-0 font-size-18"><i class="bx bxs-user-rectangle"></i> Users</h4>

                                       

                                    </div>
                                </div>
                            </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                                <div class="card">
                                        <div class="card-body overflow-x-auto">
                                <div class="clearfix"></div>
                                <form action="{{request()->url()}}" method="get">
                                <div class="row p-2">
                                    <div class="offset-sm-9 col-md-3">
                                        <select name="user" id="user" class="form-control selectpicker" onchange="this.form.submit()">
                                            <option value="">Select Reseller</option>
                                            @foreach($reseller as $rr) 
                                            <option @if(request()->user == $rr->id) selected @endif value="{{$rr->id}}">{{$rr->first_name}} {{$rr->last_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>
                                    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>S.NO.</th>
                                                <!--<th>Check</th>-->
                                                <th>User Name</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>User Role</th>
                                                <th>Permission For View</th>
                                                <th>Permission For Download</th>
                                                <th>Permission For Number Block</th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($user as $r)
                                         
                                                <tr>
                                                    <td class="product-p">
                                                        <span class="product-price-wrapper">
                                                            <span class="">{{ $loop->iteration }}</span>
                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            {{ $r->username }}
                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            {{ $r->first_name }}
                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            {{ $r->last_name }}
                                                        </span>
                                                    </td>
                                                   
                                                    <td>
                                                    @php 
                                                    $rolename = DB::table('roles')
                                                    ->select('name')
                                                    ->where('id', function($query) use ($r) {
                                                        $query->select('role_id')
                                                            ->from('model_has_roles')
                                                            ->where('model_id', $r->id);
                                                    })
                                                    ->value('name');
                                                    @endphp
                                                    <span class="product-price-wrapper">

                                                            {{ $rolename }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        @if($r->block_view == 1)
                                                        <i class="fa fa-check text-success"></i>
                                                        @else
                                                        <i class="fa fa-times text-danger"></i>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($r->block_download == 1)
                                                        <i class="fa fa-check text-success"></i>
                                                        @else
                                                        <i class="fa fa-times text-danger"></i>
                                                        @endif
                                                    </td>   
                                                    <td>
                                                        @if($r->number_permission == 1)
                                                        <i class="fa fa-check text-success"></i>
                                                        @else
                                                        <i class="fa fa-times text-danger"></i>
                                                        @endif
                                                    </td>
                                                    <td class="product-headline text-left wide-column">

                                                        <span class="product-price-wrapper">
                                                        <a href="{{ route('permission.edit',$r->id) }}" class="btn btn-success btn-rounded"><i class="fa fa-pencil-alt"></i></a>
                                                          
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
        </div>
    @endsection
    @push('footerscript')
    <script src="{{asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('skote/layouts/assets/js/pages/datatables.init.js')}}"></script> 

    <!-- Responsive examples -->
    <script src="{{asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    <script>
         $(".selectpicker").select2();
        $('.number').keyup(function(e) {
            if (/\D/g.test(this.value)) {
                    this.value = this.value.replace(/\D/g, '');
            }
        });
    </script>
    @endpush
