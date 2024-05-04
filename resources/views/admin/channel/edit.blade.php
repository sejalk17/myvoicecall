@extends('admin.layout.app')
@section('title', 'bbps - Edit Provider ')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Edit Provider</h4>
				</div>
			</div>
		</div>
		<!-- end page title -->
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body">
						<form class="" method="POST" action="{{ route('channel.update',$row->id) }}"
							novalidate>
						@csrf
						@method('PUT')
						<div class="mb-3 row">
                            <div class="col-md-6 form-group">
                                <label>Cts Number</label>
                                <input type="text" name="ctsNumber" class="form-control" value="{{ old('ctsNumber', $row->ctsNumber) }}" readonly/>
                                <div class="text-danger">{{ $errors->first('ctsNumber')}}</div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Channel Inactive Due to some reason</label>
                                <div class="form-check mb-3">
                                    <input type="radio" id="inactive" name="inactive" value="1" {{ (old('inactive', @$user_detail->inactive) == 0) ? 'checked' : '' }}>
                                    <label for="now">Yes</label>&nbsp;&nbsp;
                                    <input type="radio" id="inactive" name="inactive" value="0" {{ (old('inactive', @$user_detail->inactive) == 1) ? 'checked' : '' }}>
                                    <label for="later">No</label>
                                    <div class="text-danger">{{ $errors->first('inactive')}}</div>
                                </div>
                            </div>

                            <div class="col-md-6 form-group">
                                <label>Reason</label>
                                <input type="textarea" name="reason" class="form-control" value="{{ old('reason', $row->reason) }}"/>
                                <div class="text-danger">{{ $errors->first('reason')}}</div>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 mt-4">
			<input type="submit" class="btn btn-primary" value="Submit">
		</div>
	</div>
</div>
<!-- end col -->
</div>
</div>
</div>
@endsection
@push('footerscript')
<script>
	$('.number').keyup(function(e) {
	    if (/\D/g.test(this.value)) {
	        this.value = this.value.replace(/\D/g, '');
	    }
	});
</script>
<script>
	function getval() {
	    var e = document.getElementById("cars").value;
	    alert(e)
	}
</script>
@endpush