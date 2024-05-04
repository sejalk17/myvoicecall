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
            <form class="" method="POST" action="{{ route('blocknumber.store') }}"  enctype="multipart/form-data">
            @csrf
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            
                                <div class="mb-3 row">
                                    <div class="col-md-6 form-group" id="manual-data">
                                        <label>Manual Data (Max 100 Number)</label>
                                        <textarea name="manual_data" cols="30" rows="5" maxlength="1200" class="form-control" id="manual_data">{{old('manual_data')}}</textarea>
                                        <div class="text-danger">{{ $errors->first('manual_data')}}</div>
                                    </div> 

                                    <div class="col-md-6 form-group" id="upload-data">
                                        <label>Upload Data</label> Download Sample File <a href="{{asset('uploads/sample.xlsx')}}" download>from here</a> <br/><span style="color:red; font-size:16px;">Sample file is changed so please use new file</span>
                                        <input type="file" class="form-control" accept=".xlsx" id="excel_file_upload" name="excel_file_upload"
                                            value="{{ old('excel_file_upload') }}">
                                        <div class="text-danger">{{ $errors->first('excel_file_upload')}}</div>
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
