@extends('admin.layout.app')
@push('headerscript')

@endpush
@section('content')
    <div style="padding-top:10% !important">
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
                                                <strong>Action has been taken successfully!!
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
    </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h2 class="card-title text-center">Upload Processed File <span style="display: flex;"><a href="{{ asset('format/adminformat.csv') }}" download="" class="btn btn-sm btn-info">SampleFormat for uploading</a> </span></h2>
                            <hr>
                              <form method="POST" action="{{ url('admin/uploadprocessedSubmit') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="validationCustom01" class="form-label"><strong>Upload File <span class="text-danger">*</span></strong></label>
                                        <input type="file" class="form-control number" id="validationCustom01" name="file" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="text-danger">{{ $errors->first('amount') }}</div>
                                    </div>
                                </div>
                                </div>
                            <div class="row">    
                                <div class="col-md-12 mt-4">
                                    <input type="submit" class="btn btn-primary btn-xs btn-rounded" value="Submit">
                                </div>
                            </div>
                        </form>
                            <br>    <br>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    <!-- End Page-content -->

@endsection
@push('footerscript')
  

@endpush