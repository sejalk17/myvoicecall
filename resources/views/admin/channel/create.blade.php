@extends('admin.layout.app')
@section('title', 'bbps - Create Provider ')
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
            <form class="" method="POST" action="{{ route('channel.store') }}"  novalidate>
            @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            
                            <div class="mb-3 row">
                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-2 col-form-label">Number </label>
                                    <input class="form-input form-control" type="text" id="ctsNumber" name="ctsNumber"
                                        value="{{old('ctsNumber')}}">
                                        <span class="text-danger small">{{$errors->first('ctsNumber')}}</span>
                                </div>
                                <div class="col-md-6">
                                    <label for="example-date-input" class="col-md-2 col-form-label">Server </label>
                                    <select name="channelserver" required="" class="form-select">
										<option value="">Select Type</option>
										<option value="daksh" selected>Daksh</option>
										<option value="obdivr">OBDIVR</option>
										
									</select>
                                        <span class="text-danger small">{{$errors->first('ctsNumber')}}</span>
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
