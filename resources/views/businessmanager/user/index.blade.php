@extends('businessmanager.layout.app')
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
                        <div class="row">
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
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18"><i class="bx bxs-user-rectangle"></i> Users</h4>

                                    <div class="page-title-right">
                                         <a href="{{ route('bmuser.create') }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i> Add   User</a>
                                    </div>

                                </div>
                            </div>
                        </div>

                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                            <div class="card">
                                    <div class="card-body">
                            <div class="clearfix"></div>
                                <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                    width="100%" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>S.NO.</th>
                                            <!--<th>Check</th>-->
                                            <th>User Name</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone </th>
                                            <th>Date & Time </th>
                                            <th>Action </th>
                                            <th>Status </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($user as $r)
                                         <div class="modal fade bs-example-modal-center{{ $r->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">{{$r->first_name.' '.$r->last_name }} ( Wallet Amount: {{$r->wallet}} )</h5>
                                                        </br>
                                                        
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <span style="color:red;">Please add one balance at a time.</span>  
                                                        <form action="{{route('reseller.userupdateWallet')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$r->id}}">
                                                        <div class="from-group">
                                                        <label for="amount">Promo Balance</label>
                                                        <input type="text" name="amount" value="0" class="form-control number" min="1" required>
                                                        </div>
                                                        <div class="from-group">
                                                            <label for="transactional_wallet">Trans Balance</label>
                                                            <input type="text" name="transactional_wallet" value="0" class="form-control number" min="1">
                                                        </div>
                                                        <div class="from-group mt-3" style="float: right">
                                                        <input type="submit" value="Add" class="btn btn-primary">
                                                        </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">

                                                        {{ $r->email }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">

                                                        {{ $r->mobile }}
                                                    </span>
                                                </td>
                                               
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">

                                                        {{ date('d-m-Y H:i:s ',strtotime($r->created_at)) }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                    <a href="{{ route('bmuser.edit',$r->id) }}" class="btn btn-success btn-rounded"><i class="fa fa-pencil-alt"></i></a>
                                                    </span>
                                                </td>
                                                <td>
                                                    <input type="checkbox" data-id="{{ $r->id }}" name="status" class="js-switch" {{$r->status == 1 ? 'checked' : '' }}>
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $('.number').keyup(function(e) {
        if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
        }
    });

    let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
	elems.forEach(function(html) {
		let switchery = new Switchery(html,  { size: 'small' });
	});

  
 $(document).ready(function(){
    $('.js-switch').change(function () {
        let checkbox = $(this);
        let status = checkbox.prop('checked') ? 1 : 0;
        let originalStatus = checkbox.prop('checked'); // Store original status
        let ID = checkbox.data('id');

        if (confirm("Are you sure you want to change the user status?")) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('bmuser.statusUpdate') }}",
                data: {'status': status, 'id': ID},
                success: function (data) {
                    console.log(data);
                    if(data.error){
                        toastr.error(data.error);
                        checkbox.prop('checked', originalStatus); // Revert to original state
                        setTimeout(function() {
                            location.reload();
                        }, 2000); // Reload after 2 seconds (2000 milliseconds)
                    } else if(data.message){
                        toastr.success(data.message);
                    }
                    console.log(data.message);
                },
                error: function () {
                    // Handle AJAX error here
                    alert("There was an error in the AJAX request.");
                    checkbox.prop('checked', originalStatus); // Revert to original state
                }
            });
        } else {
            alert(!status);
            checkbox.prop('checked', originalStatus); // Revert to original state
        }
    });
});

</script>
@endpush
