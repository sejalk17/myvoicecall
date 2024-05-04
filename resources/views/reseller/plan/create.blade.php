@extends('reseller.layout.app')
@section('title', 'Plan - Create Plan ')
@section('content')



<div class="page-content">
    <div class="container-fluid">
       <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0 font-size-18">Create Provider</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <form class="" method="POST" action="{{ route('resellerplan.store') }}"  novalidate>
            @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-2 col-form-label">Title </label>
                                    <input class="form-input form-control" type="text" id="title" name="title"
                                        value="{{old('title')}}" required>
                                        <span class="text-danger small">{{$errors->first('title')}}</span>
                                </div>

                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-2 col-form-label">Amount </label>
                                    <input class="form-input form-control" type="number" id="amount" name="amount"
                                        value="{{old('amount')}}" required>
                                        <span class="text-danger small">{{$errors->first('amount')}}</span>
                                </div>

                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-2 col-form-label">Plan Type </label>
                                    <select name="plan_type" id="plan_type" class="form-select" required>
										<option value="monthly">Monthly</option>
										<!-- <option value="yearly">Yearly</option> -->
									</select>
									<div class="text-danger small">{{ $errors->first('plan_type')}}</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Daily Message </label>
                                    <input class="form-input form-control" type="number" id="daily_msg" name="daily_msg" value="{{old('daily_msg')}}" required>
                                        <span class="text-danger small">{{$errors->first('daily_msg')}}</span>
                                </div>

                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-4 col-form-label">OBD calling</label>
                                    <input type="radio" id="obd" name="obd" value="0">
                                    <label for="obd"> No</label>
                                    <input type="radio" id="obd" name="obd" value="1" checked>
                                    <label for="obd"> Yes</label>
									<div class="text-danger small">{{ $errors->first('obd')}}</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-4 col-form-label">DTMF </label>
                                    <input type="radio" id="obd" name="dtmf" value="0" checked>
                                    <label for="dtmf"> No</label>
                                    <input type="radio" id="obd" name="dtmf" value="1">
                                    <label for="dtmf"> Yes</label>
									<div class="text-danger small">{{ $errors->first('dtmf')}}</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Call Patching </label>
                                    <input type="radio" id="obd" name="call_patching" value="0" checked>
                                    <label for="call_patching"> No</label>
                                    <input type="radio" id="obd" name="call_patching" value="1">
                                    <label for="call_patching"> Yes</label>
									<div class="text-danger small">{{ $errors->first('call_patching')}}</div>
                                </div>

                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-4 col-form-label">IBD </label>
                                    <input type="radio" id="ibd" name="ibd" value="0" checked>
                                    <label for="ibd"> No</label>
                                    <input type="radio" id="ibd" name="ibd" value="1">
                                    <label for="ibd"> Yes</label>
									<div class="text-danger small">{{ $errors->first('ibd')}}</div>
                                </div>
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
    
    </div> 
</div>
</div>
</div>
@endsection
@push('footerscript')
  




@endpush
