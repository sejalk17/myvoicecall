@extends('reseller.layout.app')
@section('title', 'bbps - profile')
@push('headerscript')
@endpush
@section('content')
    
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
         <div class="col-lg-12">
        <div class="dashboard-tab cart-wrapper p-5 bg-white rounded-lg shadow-xs mb-3">
           
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18"><i class="bx bx-user-circle"></i> Profile</h4>
                    </div>
                </div>
            </div>
          
            <form method="post" action="{{ url('reseller/resellerupdateprofile') }}" enctype="multipart/form-data">
                @csrf
                 <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name', Auth::user()->first_name) }}" placeholder="Enter First Name" required=""/>
                                    <div class="text-danger">{{ $errors->first('first_name')}}</div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name', Auth::user()->last_name) }}" placeholder="Enter Last Name" />
                                    <div class="text-danger">{{ $errors->first('last_name')}}</div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" required=""
                                    value="{{ old('email', Auth::user()->email) }}" placeholder="Enter Email" readonly>
                                    <div class="text-danger">{{ $errors->first('email')}}</div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>User name</label>
                                    <input type="text" class="form-control" name="username" required=""
                                    value="{{ old('username', Auth::user()->username) }}" placeholder="Enter Username" readonly>
                                    <div class="text-danger">{{ $errors->first('username')}}</div>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile</label>
                                    <input type="text" class="form-control" name="mobile" required=""
                                    value="{{ old('mobile', Auth::user()->mobile) }}" placeholder="Enter Mobile No." readonly>
                                    <div class="text-danger">{{ $errors->first('mobile')}}</div>
                                </div>



                                

                                <div class="col-md-6 form-group">
                                    <label>Logo</label>
                                    <input type="file" class="form-control" accept="image/*" name="logo_image" 
                                    value="{{ old('name', Auth::user()->logo_image) }}">
                                    <div class="text-danger">{{ $errors->first('logo_image')}}</div>
                                    <img width="80px" src="{{asset(App\Models\UserDetail::where('user_id',Auth::user()->id)->value('logo_image'))}}" alt="">
                                </div>


                                
                               



                                   

                                <div class="col-md-6 form-group">
                                    <label>Address</label>
                                    <input type="text" class="form-control" name="address" 
                                    value="{{ old('address', App\Models\UserDetail::where('user_id',Auth::user()->id)->value('address')) }}" placeholder="Enter Address">
                                    <div class="text-danger">{{ $errors->first('address')}}</div>
                                </div>

                                <div class="col-md-6 form-group">
                                    <label>Company Name</label>
                                    <input type="text" class="form-control" name="company_name" 
                                    value="{{ old('company_name', App\Models\UserDetail::where('user_id',Auth::user()->id)->value('company_name')) }}" placeholder="Enter Company Name">
                                    <div class="text-danger">{{ $errors->first('company_name')}}</div>
                                </div>


                              
                            </div>

                
                <div class="row">
                    <div class="col-md-6 form-group">
                                        <button class="btn btn-primary" type="submit">Save</button>
                                        <button class="btn btn-danger m-l-15" type="reset">Cancel</button>
                                </div>
                   
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
   
</div>
</div>
</div>
@endsection