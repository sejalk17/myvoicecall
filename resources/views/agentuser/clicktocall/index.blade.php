@extends('agentuser.layout.app')
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
						<h4>Campaign</h4>
						<a href="{{ route('clicktocall.create') }}" class="btn btn-primary btn-sm"><i
							class="fa fa-plus"></i> Click to call initiate</a>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<div class="card">
						<div class="card-body">
							<div class="clearfix"></div>
							<form action="{{request()->url()}}" id="searchForm" method="get">
								<input type="hidden" value="" name="sort_by" id="sort_by">
								<input type="hidden" name="sort_f" value="" id="sort_f">
							</form>
							<table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
								width="100%" id="datatable">
								<thead>
									<tr>
										<th class="">
											S.NO.
										</th>
										<th class="">
                                        agent_no
										</th>
										<th class="">
                                        b_mobile_no
										</th>
										<th class="">
                                        a_connected_time
										</th>
										<th class="">
                                        a_connected_status
										</th>
										<th class="">
                                        b_connected_time
										</th>
										<th>b_end_time</th>
										<th>b_connected_status</th>
										<th>record_voice</th>
										<th>disconnect_by</th>
									</tr>
								</thead>
								<tbody>
                                @foreach ($agentData as $key => $r)
                                        <tr>
                                            <td>{{ ($key+1)}}</td>
                                            <td>{{$r->agent_no}}</td>
                                            <td>{{$r->b_mobile_no}}</td>
                                            <td>{{$r->a_connected_time}}</td>
                                            <td>{{$r->a_connected_status}}</td>
                                            <td>{{$r->b_connected_time}}</td>
                                            <td>{{$r->b_end_time}}</td>
                                            <td>{{$r->b_connected_status}}</td>
                                            <td>{{$r->record_voice}}</td>
                                            <td>{{$r->disconnect_by}}</td>
                                        </tr>
                                @endforeach
								</tbody>
							</table>
							<div style="float: right;">
							</div>
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
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
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
@endpush