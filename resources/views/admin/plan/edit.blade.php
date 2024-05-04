@extends('admin.layout.app')
@section('title', 'bbps - Edit Provider ')
@section('content')
<div class="page-content">
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Edit Plan</h4>
				</div>
			</div>
		</div>
		<!-- end page title -->
        <form class="" method="POST" action="{{ route('plan.update',$row->id) }}" novalidate>
        @csrf
        @method('PUT')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Title </label>
                                        <input class="form-input form-control" type="text" id="provider" name="title"
                                            value="{{old('title',$row->title)}}">
                                        <span class="text-danger small">{{$errors->first('provider')}}</span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Amount </label>
                                        <input class="form-input form-control" type="number" id="amount" name="amount"
                                            value="{{old('amount',$row->amount)}}">
                                        <span class="text-danger small">{{$errors->first('amount')}}</span>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Plan Type </label>
                                        <select name="plan_type" id="plan_type" class="form-select" required>
                                            <option value="monthly" {{ (old('plan_type', @$row->plan_type) == "monthly") ? 'selected' : '' }}>Monthly</option>
                                            <option value="yearly" {{ (old('plan_type', @$row->plan_type) == "yearly") ? 'selected' : '' }}>Yearly</option>
                                        </select>
                                        <div class="text-danger small">{{ $errors->first('plan_type')}}</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-4 col-form-label">Daily Message </label>
                                        <input class="form-input form-control" type="number" id="daily_msg" name="daily_msg"
                                            value="{{old('daily_msg',$row->daily_msg)}}">
                                        <span class="text-danger small">{{$errors->first('daily_msg')}}</span>
                                    </div>


                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-4 col-form-label">OBD calling</label>
                                        <input type="radio" id="obd" name="obd" value="0" {{ (old('obd', @$row->obd) == "0") ? 'checked' : '' }}>
                                        <label for="obd"> No</label>
                                        <input type="radio" id="obd" name="obd" value="1" {{ (old('obd', @$row->obd) == "1") ? 'checked' : '' }}>
                                        <label for="obd"> Yes</label>
                                        <div class="text-danger small">{{ $errors->first('obd')}}</div>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-4 col-form-label">DTMF</label>
                                        <input type="radio" id="dtmf" name="dtmf" value="0" {{ (old('dtmf', @$row->dtmf) == "0") ? 'checked' : '' }}>
                                        <label for="dtmf"> No</label>
                                        <input type="radio" id="dtmf" name="dtmf" value="1" {{ (old('obd', @$row->dtmf) == "1") ? 'checked' : '' }}>
                                        <label for="dtmf"> Yes</label>
                                        <div class="text-danger small">{{ $errors->first('dtmf')}}</div>
                                    </div>


                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-4 col-form-label">Call Patching</label>
                                        <input type="radio" id="call_patching" name="call_patching" value="0" {{ (old('call_patching', @$row->call_patching) == "0") ? 'checked' : '' }}>
                                        <label for="call_patching"> No</label>
                                        <input type="radio" id="call_patching" name="call_patching" value="1" {{ (old('call_patching', @$row->call_patching) == "1") ? 'checked' : '' }}>
                                        <label for="call_patching"> Yes</label>
                                        <div class="text-danger small">{{ $errors->first('call_patching')}}</div>
                                    </div>


                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-4 col-form-label">IBD</label>
                                        <input type="radio" id="ibd" name="ibd" value="0" {{ (old('ibd', @$row->ibd) == "0") ? 'checked' : '' }}>
                                        <label for="ibd"> No</label>
                                        <input type="radio" id="ibd" name="ibd" value="1" {{ (old('ibd', @$row->ibd) == "1") ? 'checked' : '' }}>
                                        <label for="ibd"> Yes</label>
                                        <div class="text-danger small">{{ $errors->first('ibd')}}</div>
                                    </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mt-4">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
	    </form>
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