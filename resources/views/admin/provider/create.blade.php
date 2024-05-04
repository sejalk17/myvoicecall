@extends('admin.layout.app')
@section('title', 'bbps - Create Provider ')
@section('content')



    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Create Provider</h4>



                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">


                            <form class="" method="POST" action="{{ route('provider.store') }}"
                                novalidate>
                                @csrf
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Provider </label>
                                        <input class="form-input form-control" type="text" id="provider" name="provider"
                                            value="{{old('provider')}}">
                                            <span class="text-danger small">{{$errors->first('provider')}}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Cli </label>
                                        <input class="form-input form-control" type="text" id="cli" name="cli"
                                            value="{{old('cli')}}">
                                            <span class="text-danger small">{{$errors->first('cli')}}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Phone Number</label>
                                        <input class="form-input form-control number" type="text" id="number" name="number"
                                            value="{{old('number')}}" maxlength="10" minlength="10">
                                            <span class="text-danger small">{{$errors->first('number')}}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Landline Number </label>
                                        <input class="form-input form-control number" type="text" id="landline" name="landline"
                                            value="{{old('landline')}}">
                                            <span class="text-danger small">{{$errors->first('landline')}}</span>
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <div class="col-md-12">
                                        <label for="example-date-input" class="col-md-2 col-form-label">Api url</label>
                                        <input class="form-input form-control" type="text" id="apiurl" name="apiurl"
                                            value="{{old('apiurl')}}">
                                            <span class="text-danger small">{{$errors->first('apiurl')}}</span>
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



 
@endpush
