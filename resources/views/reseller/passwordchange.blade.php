@extends('reseller.layout.app')
@section('title','bbps - Password')
@push('headerscript')

@endpush
@section('content')
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="page-content">
    
<div class="container-fluid">
    <div class="row">
                            <div class="col-12">
                                <div class=" d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18"><i class="bx bx-lock"></i> Change Password</h4>

                                    

                                </div>
                            </div>
                        </div>
<div class="row">
    
<div class="col-lg-12"style="margin-top: 25px;">
  <div class="dashboard-tab cart-wrapper p-5 bg-white rounded-lg shadow-xs mb-3">
  <!--  <div class="row">-->
  <!--   <div class="col-lg-4 offset-sm-4 text-center">-->
  <!--    <h2 class="text-center"><strong style="color: #33439b;">Change Password</strong></h2>-->
  <!--    <br>-->
  <!--  </div>-->
  <!--</div>  -->
  <form action="{{ url('reseller/resellerupdatepassword') }}" method="post" enctype="multipart/form-data" onsubmit="submitBtn.disabled = true; return true;">
    @csrf
    <div class="row">
      <div class="col-lg-6 mb-3">
        <div class="form-gorup">
          <label class="mont-font fw-600 font-xsss" for="comment-name">Old Password <span class="text-danger">*</span></label>
          <input type="password" name="oldpassword" value="" placeholder="Old Password" class="form-control" required="">
        </div>        
        <div class="text-danger">{{ $errors->first('oldpassword')}}</div>
      </div>

      <div class="col-lg-6 mb-3">
        <div class="form-gorup">
          <label class="mont-font fw-600 font-xsss" for="comment-name">New Password <span class="text-danger">*</span></label>
          <input type="password" name="password" value="" class="form-control" placeholder="New Password" required="">
        </div>        
           <div class="text-danger">{{ $errors->first('password')}}</div>
      </div>
    </div>

 <div class="row">
      <div class="col-lg-6 mb-3">
        <div class="form-gorup">
          <label class="mont-font fw-600 font-xsss" for="comment-name">Password Confirmation <span class="text-danger">*</span></label>
         <input type="password" name="password_confirmation" placeholder="Password Confirmation" class="form-control" required="">
        </div>        
        <div class="text-danger">{{ $errors->first('password_confirmation')}}</div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 mb-5">
          <input type="submit" name="submitBtn" class="btn btn-primary m-t-10 btn-sm" value="Submit">
         <input type="reset" name="cancel" class="btn btn-danger m-t-10 btn-sm" value="Cancel">
      </div>
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
@push('footerscript')

<script type="text/javascript">
    $(function() {
        $('#datatables').DataTable({
        });
    });
        $(function() {
        $('#datatables1').DataTable({
        });
    });
    
</script>
@endpush