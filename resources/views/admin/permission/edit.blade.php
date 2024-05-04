@extends('admin.layout.app')
@section('title','Ask Doctor')
@push('headerscript')
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css">
<link href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
	.col-md-6{
	margin-bottom:10px;
	}
</style>
@endpush
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="page-content">
<!-- Start content -->
<div class="">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Edit User</h4>
				</div>
			</div>
		</div>
		
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="{{ route('permission.update', $row->id) }}" enctype="multipart/form-data">
							@method('put')
							@csrf
							<div class="row">
							<div class="col-md-6 form-group">
											<label>Permission for View Button</label>
											<div class="form-check mb-3">
												<input type="radio" id="block_view" name="block_view" value="2" {{ (old('block_view', @$row->block_view) == 2) ? 'checked' : '' }}>
												<label for="now">Disable</label>&nbsp;&nbsp;
												<input type="radio" id="block_view" name="block_view" value="1" {{ (old('block_view', @$row->block_view) == 1) ? 'checked' : '' }}>
												<label for="later">Enable</label>
												<div class="text-danger">{{ $errors->first('block_view')}}</div>
											</div>
										</div>
										<div class="col-md-6 form-group">
											<label>Permission for download button</label>
											<div class="form-check mb-3">
												<input type="radio" id="dnd_disbale" name="block_download" value="2" {{ (old('block_download', @$row->block_download) == 2) ? 'checked' : '' }}>
												<label for="now">Disable</label>&nbsp;&nbsp;
												<input type="radio" id="dnd_enable" name="block_download" value="1" {{ (old('block_download', @$row->block_download) == 1) ? 'checked' : '' }}>
												<label for="later">Enable</label>
												<div class="text-danger">{{ $errors->first('block_download')}}</div>
											</div>
										</div>

										<div class="col-md-6 form-group">
											<label>Permission for Number Shown in Reports</label>
											<div class="form-check mb-3">
												<input type="radio" id="dnd_disbale" name="number_permission" value="2" {{ (old('number_permission', @$row->number_permission) == 2) ? 'checked' : '' }}>
												<label for="now">Disable</label>&nbsp;&nbsp;
												<input type="radio" id="dnd_enable" name="number_permission" value="1" {{ (old('number_permission', @$row->number_permission) == 1) ? 'checked' : '' }}>
												<label for="later">Enable</label>
												<div class="text-danger">{{ $errors->first('number_permission')}}</div>
											</div>
										</div>
								
							</div>

						
							<div class="row">
								<div class="col-md-6 form-group">
									<button name="submitBtn" class="btn btn-primary" type="submit">Save</button>
									<button class="btn btn-danger m-l-15" type="reset">Cancel</button>
								</div>
						</form>
						</div> <!-- end col -->
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


@endpush