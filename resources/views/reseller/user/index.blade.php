@extends('reseller.layout.app')
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
							<a href="{{ route('reselleruser.create') }}" class="btn btn-primary btn-sm"><i
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
										<th>Email</th>
										<th>Phone </th>
										<th>Credit</th>
										<th>Date & Time </th>
										<th>Action </th>
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
													<form action="{{route('reseller.      ')}}" method="post">
														@csrf
														<input type="hidden" name="id" value="{{$r->id}}">
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
														@if($rolename == 'user')	
														<div class="from-group">
															<label for="amount">Promo Balance</label>
															<input type="number" name="amount" value="0" class="form-control number" required>
														</div>
														@elseif($rolename == 'reseller')
														
														
														<div class="from-group">
															<label for="transactional_wallet">Reseller Balance</label>
															<input type="text" name="reseller_wallet" value="0" class="form-control number" min="1">
														</div>
														@endif;
														<div class="from-group mt-3" style="float: right">
															<input type="submit" value="Add" class="btn btn-primary">
														</div>
													</form>
												</div>
											</div>
										</div>
									</div>

									<div class="modal fade bs-example-modal-center{{ $r->id }}1" tabindex="-1" role="dialog" aria-hidden="true">
										<div class="modal-dialog modal-dialog-centered">
											<div class="modal-content">
												<div class="modal-body">
													{{$r->actual_password}}
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
											{{ $r->wallet }}
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
											{{ date('d-m-Y H:i:s ',strtotime($r->created_at)) }}
											</span>
										</td>
										<td class="product-headline text-left wide-column">
											<span class="product-price-wrapper">
												<a href="{{ route('reselleruser.edit',$r->id) }}" class="btn btn-success btn-rounded"><i class="fa fa-pencil-alt"></i></a>
												<!-- @if($r->status=="1")
													<a href="{{ url('admin/blockuser',$r->id) }}" class="btn btn-success btn-rounded"><i class="fa fa-unlock"></i></a>
													@else
													<a href="{{ url('admin/blockuser',$r->id) }}" class="btn btn-danger btn-rounded"><i class="fa fa-lock"></i></a>
													@endif -->
											</span>
											@if($r->user_plan == 0)
											<button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center{{ $r->id }}">Wallet</button>
											@endif

											<button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center{{ $r->id }}1"><i class="fas fa-eye"></i></button>
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
		<!-- container -->
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
<script></script>
@endpush