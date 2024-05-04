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
<div class="page-content">
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
						<h4 class="mb-sm-0 font-size-18"><i class="bx bx-video-recording"></i> All Block Number</h4>
						<div class="page-title-right">
							<a href="{{ route('blocknumber.create') }}" class="btn btn-primary btn-sm"><i
								class="fa fa-plus"></i> Add Block Number</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<form action="{{request()->url()}}" id="searchForm" method="get">
						<div class="row">
							<div class="col-sm-12">
								<label>Show
								<select name="paginate" onchange="this.form.submit()"  id="paginate"
									class="form-control input-sm width-auto d-inline-block" style="width:auto">
								<option @if($paginate == 50) selected @endif value="50">50</option>
								<option @if($paginate == 75) selected @endif value="75">75</option>
								<option @if($paginate == 100) selected @endif value="100">100</option>
								<option @if($paginate == 150) selected @endif value="150">150</option>
								</select> entries</label>
								<div style="float: right;">
									<label>Search:<input type="search" value="{{$search}}" name="search" class="form-control input-sm"
										placeholder=""></label>
								</div>
							</div>
						</div>
					</form>
					<div class="card">
						<div class="card-body  overflow-x-auto">
							<div class="clearfix"></div>
							<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
								width="100%" id="datatable">
								<thead>
									<tr>
										<th>S.NO.</th>
										<th>Number</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($blocknumber as $r)
									<tr>
										<td class="product-p">
											<span class="product-price-wrapper">
											<span class="">{{ $loop->iteration }}</span>
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											{{ $r->number }}
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<input type="checkbox" data-id="{{ $r->id }}" name="status" class="js-switch" {{$r->status == 1 ? 'checked' : '' }}>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
							<div style="float: right;">
								{{ $blocknumber->appends(request()->input())->links() }}
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
<script src="{{asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('skote/layouts/assets/js/pages/datatables.init.js')}}"></script> 
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
	
	$("#datatable").dataTable({
	   "processing": false, 
		"paging": false,
		"filter": false,
		"ordering": false,
	        "orderMulti": false, 
	});
</script>
@endpush