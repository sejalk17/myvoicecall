@extends('admin.layout.app')
@section('title', 'bbps - profile')
@push('headerscript')


@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18"><i class="bx bx-user-circle"></i> Profile</h4>

                                    

                                </div>
                            </div>
                        </div>
        <div class="row">
            <div class="flash-message">
                @foreach (['danger', 'warning', 'success', 'info'] as $msg)
                    @if (Session::has('alert-' . $msg))
                        <section>
                            <div class="row">
                                <div class="col-sm-12 col-lg-12">
                                    <center>
                                        <div data-example-id="simple-alerts" class="bs-example">
                                            <div role="alert" class="alert alert-success">
                                                <strong>Thank you your request has been Submitted
                                                    Successfully! Please wait untill your Request Approves!
                                                </strong>
                                            </div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </section>
                    @endif
                @endforeach
            </div> <!-- end .flash-message -->
        </div>
        
        <div class="row">
            
    <div class="col-lg-12">
        <div class="dashboard-tab cart-wrapper p-5 bg-white rounded-lg shadow-xs mb-3">
            <!--<div class="row">-->
            <!--    <div class="col-lg-4 offset-sm-4 text-center">-->
            <!--        <h2 class="text-center" style="margin-top: 25px;"><strong style="color: #33439b;">Profile-->
            <!--                Details</strong></h2>-->

            <!--    </div>-->
            <!--</div>-->
            <form method="post" action="{{ url('admin/adminupdateprofile') }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">First Name</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->first_name) }}"
                                class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('name', Auth::user()->last_name) }}"
                                class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                    @php
                        $userdetail = App\Models\UserDetail::where('user_id', Auth::user()->id)->first();
                    @endphp

                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Aadhar No.</label>
                            <input type="text" name="aadhar_no" value="{{ $userdetail->aadhar_no }}"
                                class="form-control">

                        </div>
                    </div>

                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Phone No</label>
                            <input type="text" name="phone_no" value="{{ $userdetail->phone_no }}" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">D.O.B</label>
                            <input type="date" name="dob" value="{{ $userdetail->dob }}" class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Address</label>
                            <input type="text" name="address" value="{{ $userdetail->address }}" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">City</label>
                            <input type="text" name="city" value="{{ $userdetail->city }}" class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">State</label>
                            <input type="text" name="state" value="{{ $userdetail->state }}" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Pin Code</label>
                            <input type="text" name="pincode" value="{{ $userdetail->pincode }}" class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Pan No.</label>
                            <input type="text" name="pan_no" value="{{ $userdetail->pan_no }}" class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Bank Name</label>
                            <input type="text" name="bank_name" value="{{ $userdetail->bank_name }}"
                                class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Account Holder Name</label>
                            <input type="text" name="account_holder_name" value="{{ $userdetail->account_holder_name }}"
                                class="form-control">

                        </div>
                    </div>
                </div>
                <div class="row">
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">IFSC</label>
                            <input type="text" name="ifsc_code" value="{{ $userdetail->ifsc_code }}"
                                class="form-control">

                        </div>
                    </div>
                     <div class="col-sm-6 mb-3 ">
                        <div class="form-group fg-line">
                            <label class="fg-label">Cheque</label>
                            <input type="file" name="cheque" value="{{ $userdetail->cheque }}" class="form-control">

                        </div>
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6 form-group">
                        
                    <button type="submit" class="btn btn-primary m-t-10 waves-effect">Save</button>
                 
                    <button type="reset" class="btn btn-danger m-t-10 waves-effect">Cancel</button>
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
    </div>
@endsection
