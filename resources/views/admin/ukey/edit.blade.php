@extends('admin.layout.app')
@section('title', 'bbps - Edit Provider ')
@section('content')



    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit Ukey</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <form class="" method="POST" action="{{ route('ukey.update',$row->id) }}"
                                novalidate>
                                @csrf
                                @method('PUT')
                                <div class="mb-3 row">
                                    <div class="col-md-4 form-group">
                                        <label>Api Provider</label>
                                        <select name="apiProvider" id="apiProvider" required="" class="form-select" onchange="getCli();">
                                            <option value="">Choose...</option>
                                        @foreach ($apiProvider as $key => $value)
                                            <option @if(old('apiProvider',$row->provider) == $key) selected @endif value="{{$key}}">{{ $value }}</option>
                                        @endforeach
                                        </select>
                                        <div class="text-danger">{{ $errors->first('apiProvider')}}</div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>CLI</label>
                                        <select name="cli" id="cli" required="" class="form-select" onchange="getServiceNo();">
                                            <option value="">Choose...</option>
                                        </select>
                                        <div class="text-danger">{{ $errors->first('cli')}}</div>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label>Service No</label>
                                        <select name="service_no" id="service_no" required="" class="form-select">
                                            <option value="">Choose...</option>
                                        </select>
                                        <div class="text-danger">{{ $errors->first('service_no')}}</div>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Username</label>
                                        <input class="form-input form-control" type="text" id="username" name="username"
                                            value="{{old('username',$row->username)}}">
                                            <span class="text-danger small">{{$errors->first('username')}}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Ukey / Password</label>
                                        <input class="form-input form-control" type="text" id="key" name="key"
                                            value="{{old('key',$row->ukey)}}">
                                            <span class="text-danger small">{{$errors->first('key')}}</span>
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
        </form>
<!-- 
        <select name="cars" id="cars" onchange="getval()">
            <option value="1">Volvo</option>
            <option value="2">Saab</option>
            <option value="3">Opel</option>
            <option value="4">Audi</option>
            <option value="5">Audi</option>
          </select> -->

    </div> <!-- end col -->

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


<script>
 
        getCli();
    function getCli(){
        $('#cli').empty();
        @if(old('apiProvider'))
        var provider = "{{old('apiProvider')}}";
        @else
        var provider = $('#apiProvider').val();
        @endif
        $('#apiProvider').val();
        $.ajax({
            type: "GET",
            url: "{{route('user.getCli')}}",
            dataType: "json",
            data:{'provider':provider,'selectvalue':"{{old('cli',$row->cli)}}"},
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
        var selectedval = "{{old('service_no',json_encode(['l_no' => $row->landline,'n_no'=>$row->number]))}}";
        $.ajax({
            type: "GET",
            url: "{{route('user.getServiceNo')}}",
            dataType: "json",
            data:{'provider':$('#apiProvider').val(),'cli':$('#cli').val(),'selectvalue':selectedval},
            success: function (result) {
                $('#service_no').html(result);
                        },
            error: function (status) {
                alert("Result: " + status);
            }
        });
    }
</script>


 
@endpush
