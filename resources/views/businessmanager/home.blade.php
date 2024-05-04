@extends('businessmanager.layout.app')
@push('headerscript')
<!-- DataTables -->
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
	rel="stylesheet" type="text/css" />
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
	rel="stylesheet" type="text/css" />
<!-- Responsive datatable examples -->
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
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
			<h4 class="mb-sm-0 font-size-18">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h4>
		</div>
	</div>
</div>
<!-- end page title -->
{{-- 
<div class="row">
	<div class="col-xl-6">
		<div class="card overflow-hidden">
			<div class="bg-primary bg-soft">
				<div class="row">
					<div class="col-7">
						<div class="text-primary p-3">
							<h5 class="text-primary">Welcome Back !</h5>
						</div>
					</div>
					<div class="col-5 align-self-end">
						<img src="{{ asset('skote/layouts/assets/images/profile-img.png') }}" alt=""
							class="img-fluid">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
--}}
<!-- end row -->
<hr>
<div class="row mb-3">
	<div class="col-12">
		<div class="">
			<div class="">
				<!--<div class="row">-->
				<div id="reportrange">
					<i class="fa fa-calendar icon-gradient"></i>
					<span></span> <i class="fa fa-caret-down"></i>
				</div>
			</div>
			<!--</div>-->
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xl-3">
		<div class="card bg-blue">
			<div class="card-body">
				<div class="d-flex">
					<div class="flex-grow-1">
						<h4 class="mb-0  f-26-bold">{{ auth()->user()->wallet }}</h4>
						<p class="text-bold-00">Credit</p>
					</div>
					<div class="flex-shrink-0 align-self-center">
						<div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
							<span class="avatar-title rounded-circle">
							<i class="bx bx-copy-alt font-size-24"></i>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-9">
		<div class="row">
			<div class="col-md-4">
				<div class="card mini-stats-wid  bg-red">
					<div class="card-body">
						<div class="d-flex">
							<div class="flex-grow-1">
								<h4 class="mb-0  f-26-bold" id="campaign-count">{{ $campaign->count() }}</h4>
								<p class="text-bold-00">Campaign</p>
							</div>
							<div class="flex-shrink-0 align-self-center">
								<div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
									<span class="avatar-title">
									<i class="bx bx-copy-alt font-size-24"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card mini-stats-wid bg-darkblue">
					<div class="card-body">
						<div class="d-flex">
							<div class="flex-grow-1">
								<h4 class="mb-0   f-26-bold" id="answered-count">
									{{ $campaign->sum('deliverCount') }}
								</h4>
								<p class="text-bold-00">Answered</p>
							</div>
							<div class="flex-shrink-0 align-self-center ">
								<div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
									<span class="avatar-title rounded-circle darkblue">
									<i class="bx bx-archive-in font-size-24"></i>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card mini-stats-wid  bg-brown">
					<div class="card-body">
						<div class="d-flex">
							<div class="flex-grow-1">
								<h4 class="mb-0  f-26-bold" id="notanswered-count">
									{{ $campaign->sum('notDeliverCount') }}
								</h4>
								<p class="text-bold-00">No Answered</p>
							</div>
							<div class="flex-shrink-0 align-self-center">
								<div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
									<span class="avatar-title rounded-circle brown">
									<i class="bx bx-purchase-tag-alt font-size-24"></i>
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
							</tr>
						</thead>
						<tbody>
							@foreach ($campaign->take(5) as $r)
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
								$user_detail = App\Models\User::where('id', $r->user_id)->first();
								@endphp
								<td class="product-headline text-left wide-column">
									<span class="product-price-wrapper">
									{{ $user_detail->first_name }} {{ $user_detail->last_name }}
									</span>
								</td>
								<td class="product-headline text-left wide-column">
									<span class="product-price-wrapper">
									{{ $r->total_count }}
									</span>
								</td>
								<td class="product-headline text-left wide-column">
									<span class="product-price-wrapper">
									{{-- {{ $deliverCount=App\Models\Campaigndata::Where('status',1)->where('campaign_id',$r->id)->count() }} --}}
									{{ $r->deliverCount == null ? '0' : $r->deliverCount }}
									</span>
								</td>
								<td class="product-headline text-left wide-column">
									<span class="product-price-wrapper">
									{{-- {{ $notDeliverCount=App\Models\Campaigndata::Where('status',0)->where('campaign_id',$r->id)->count() }} --}}
									{{ $r->notDeliverCount == null ? '0' : $r->notDeliverCount }}
									</span>
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
<script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('skote/layouts/assets/libs/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('skote/layouts/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
<script src="{{ asset('skote/layouts/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
<script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- Responsive examples -->
<script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>
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
	        // alert(start);
	        //  alert(end);
	        $.ajax({
	            url: "{{ route('reseller.filterDateBase') }}",
	            method: 'GET',
	            dataType: "json",
	            data: {
	                'start': start.format('YYYY-MM-DD h:mm:ss'),
	                  'end': end.format('YYYY-MM-DD h:mm:ss')
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