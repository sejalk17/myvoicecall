@extends('admin.layout.app')
@section('title','Create User')
@push('headerscript')

<style>
	.col-md-6{
	margin-bottom:10px;
	}

nav > .nav.nav-tabs{

border: none;
  color:#fff;
  border-radius:0;
}
nav > div a.nav-item.nav-link,
nav > div a.nav-item.nav-link.active
{
    color:#000;
}

</style>
@endpush
@section('content')
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
					<h4 class="mb-sm-0 font-size-18">Web Setting</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
                            <div class="row">
                                <div class="col-xs-12 ">
                                  <nav>
                                    <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                      <a class="nav-item nav-link active" id="nav-demoUkey-tab" data-toggle="tab" href="#nav-demoUkey" role="tab" aria-controls="nav-demoUkey" aria-selected="true">Demo Ukey</a>
                                      {{-- <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile" role="tab" aria-controls="nav-profile" aria-selected="true">Demo Ukey</a> --}}
                                    </div>
                                  </nav>
                                  <div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
                                    <div class="tab-pane fade show active p-3" id="nav-demoUkey" role="tabpanel" aria-labelledby="nav-demoUkey-tab">
                                        <h4>Demo Ukey Form</h4>
                                        <form action="{{route('websetting.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="form_type" id="form_type" value="demoUkey" >
                                        <div class="mb-3 row">
                                            <div class="col-md-4 form-group">
                                                <label>Api Provider</label>
                                                <select name="demo_apiProvider" id="apiProvider" required="" class="form-select" onchange="getCli();">
                                                    <option value="">Choose...</option>
                                                @foreach ($apiProvider as $key => $value)
                                                    <option  @if (!empty(getSiteSettings('demo_apiProvider'))) @if(old('demo_apiProvider',getSiteSettings('demo_apiProvider')->_value) == $key) selected @endif @endif value="{{$key}}">{{ $value }}</option>
                                                @endforeach
                                                </select>
                                                <div class="text-danger">{{ $errors->first('demo_apiProvider')}}</div>
                                            </div>
            
                                            <div class="col-md-4 form-group">
                                                <label>CLI</label>
                                                <select name="demo_cli" id="cli" required="" class="form-select" onchange="getServiceNo();">
                                                    <option value="">Choose...</option>
                                                </select>
                                                <div class="text-danger">{{ $errors->first('demo_cli')}}</div>
                                            </div>
                                            <div class="col-md-4 form-group">
                                                <label>Service No</label>
                                                <select name="demo_service_no" id="service_no" required="" class="form-select">
                                                    <option value="">Choose...</option>
                                                </select>
                                                <div class="text-danger">{{ $errors->first('demo_service_no')}}</div>
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <div class="col-md-4">
                                                <label for="example-date-input" class="col-form-label">Username</label>
                                                <input class="form-input form-control" required type="text" id="username" name="demo_username"
                                                    value="@if(!empty(getSiteSettings('demo_username'))){{ getSiteSettings('demo_username')->_value }}@endif">
                                                    <span class="text-danger small">{{$errors->first('demo_username')}}</span>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="example-date-input" class="col-form-label">Password</label>
                                                <input class="form-input form-control" required type="text" id="key" name="demo_key"
                                                    value="@if(!empty(getSiteSettings('demo_key'))){{ getSiteSettings('demo_key')->_value }}@endif">
                                                    <span class="text-danger small">{{$errors->first('demo_key')}}</span>
                                            </div>
                                            <div class="col-md-4">
                                                <label for="example-date-input" class=" col-form-label">Url</label>
                                                <input class="form-input form-control" required type="text" id="url" name="demo_url"
                                                    value="@if(!empty(getSiteSettings('demo_url'))){{ getSiteSettings('demo_url')->_value }}@endif">
                                                    <span class="text-danger small">{{$errors->first('demo_url')}}</span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <button name="submitBtn" class="btn btn-primary" type="submit">Save</button>
                                                <button class="btn btn-danger m-l-15" type="reset">Cancel</button>
                                            </div>
                                            </div>
                                        </form>
                                    </div>
                                    {{-- <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                                      Et et consectetur ipsum labore excepteur est proident excepteur ad velit occaecat qui minim occaecat veniam. Fugiat veniam incididunt anim aliqua enim pariatur veniam sunt est aute sit dolor anim. Velit non irure adipisicing aliqua ullamco irure incididunt irure non esse consectetur nostrud minim non minim occaecat. Amet duis do nisi duis veniam non est eiusmod tempor incididunt tempor dolor ipsum in qui sit. Exercitation mollit sit culpa nisi culpa non adipisicing reprehenderit do dolore. Duis reprehenderit occaecat anim ullamco ad duis occaecat ex.
                                    </div> --}}
                                  </div>
                                
                                </div>
                              </div>
                        </div>
                      </div>
							
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
<link href="{{ asset('theme/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('theme/default/assets/js/fastclick.js')}}"></script>
<script src="{{ asset('theme/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
<script>
	$('#datepicker-autoclose').datepicker();
</script>
<script>
   
        getCli();
    function getCli(){
        $('#cli').empty();
        @if (!empty(getSiteSettings('demo_cli')))
         var selectedvc = "{{old('demo_cli',getSiteSettings('demo_cli')->_value)}}";
         @else
         var selectedvc = "{{old('demo_cli')}}";
         @endif
        var provider = $('#apiProvider').val();
        $('#apiProvider').val();
        $.ajax({
            type: "GET",
            url: "{{route('user.getCli')}}",
            dataType: "json",
            data:{'provider':provider,'selectvalue':selectedvc},
            success: function (result) {
                $('#cli').html(result);
                getServiceNo();
                        },
            error: function (status) {
                alert("Result: " + status);
            }
        });
    }

    function getServiceNo(){
        @if (!empty(getSiteSettings('demo_service_no')))
         var selectedvs = "{{old('demo_service_no',getSiteSettings('demo_service_no')->_value)}}";
         @else
         var selectedvs = "{{old('demo_service_no')}}";
         @endif
        $.ajax({
            type: "GET",
            url: "{{route('user.getServiceNo')}}",
            dataType: "json",
            data:{'provider':$('#apiProvider').val(),'cli':$('#cli').val(),'selectvalue':selectedvs},
            success: function (result) {
            console.log(result)
                $('#service_no').html(result);
                        },
            error: function (status) {
                alert("Result: " + status);
            }
        });
    }
    
</script>
@endpush
