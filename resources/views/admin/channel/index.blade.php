@extends('admin.layout.app')
@section('title', 'Sounds - All')
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
						<h4 class="mb-sm-0 font-size-18"><i class="bx bx-video-recording"></i> All CTS Number</h4>
						<div class="page-title-right">
							<a href="{{ route('channel.addctsnumberuser') }}" class="btn btn-primary btn-sm"><i
								class="fa fa-plus"></i> Add CTS Number to User</a>
						</div>	
						<div class="page-title-right">
							<a href="{{ route('channel.create') }}" class="btn btn-primary btn-sm"><i
								class="fa fa-plus"></i> Add CTS Number</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<div class="card">
						<div class="card-body  overflow-x-auto">
							<div class="clearfix"></div>
							<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
								width="100%" id="datatable">
								<thead>
									<tr>
										<th>S.NO.</th>
										<th>Cts Number</th>
										<th>Username</th>
										<th>Status</th>
										<th>Server</th>
										<th>Reason</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($channel as $r)
									<tr>
										<td class="product-p">
											<span class="product-price-wrapper">
											<span class="">{{ $loop->iteration }}</span>
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											{{ $r->ctsNumber }}
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											{{ $r->first_name }} {{ $r->last_name }}
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											@if($r->inactive == 1)
											<i class="fa fa-times text-danger"></i>
											@else
											<i class="fa fa-check text-success"></i>
											@endif
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
												{{ $r->channelserver }}
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
												{{ $r->reason }}
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<a href="{{ route('channel.edit',$r->id) }}" class="btn btn-success btn-rounded"><i class="fa fa-pencil-alt"></i></a>
										</td>
									</tr>
								@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		
	</div>
	<!-- content -->
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
<script>
	let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
	elems.forEach(function(html) {
		let switchery = new Switchery(html,  { size: 'small' });
	});

	$(document).ready(function(){
		$('.js-switch').change(function () {
			let status = $(this).prop('checked') === true ? 1 : 0;
			let ID = $(this).data('id');
			
			if (confirm("Are you sure you want to change the ukey status?")) {
				$.ajax({
					type: "GET",
					dataType: "json",
					url: "{{ route('channel.statusUpdate') }}",
					data: {'status': status, 'id': ID}, 
					success: function (data) {
						toastr.options.closeButton = true;
						toastr.options.closeMethod = 'fadeOut';
						toastr.options.closeDuration = 100;
						toastr.success(data.message);
						console.log(data.message);
					}
				});
			} else {
				$(this).prop('checked', !status);
				return false;
			}
		});
	});
</script>
@endpush