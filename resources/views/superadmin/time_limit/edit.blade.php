@extends('admin.layout.app')
@section('title','bbps - Edit time_limit ')
@section('content')



<div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Time Limit</h4>

                                    

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                    {!! Form::model($row, ['method'=>'patch','route' => ['time_limit.update', $row->id]]) !!}
                                        
                                    novalidate>
                                    @csrf
                                     <div class="mb-3 row">
                                            <label for="example-time-local-input" class="col-md-2 col-form-label">
                                                Till Time</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="time" name="time_limit" value="T13:45:00"
                                                    id="example-datetime-local-input">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-date-input" class="col-md-2 col-form-label">Date </label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="date" name="date_limit" value="2019-08-19"
                                                    id="example-date-input">
                                            </div>
                                        </div>
                                        <!-- <div class="mb-3 row">
                                            <label for="example-time-local-input" class="col-md-2 col-form-label">
                                                UpTo Time</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="time" name="upto_time" value="T13:45:00"
                                                    id="example-datetime-local-input">
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            <label for="example-date-input" class="col-md-2 col-form-label">Upto Date</label>
                                            <div class="col-md-10">
                                                <input class="form-control" type="date" name="upto_date" value="2019-08-19"
                                                    id="example-date-input">
                                            </div>
                                        </div> -->
                                      
                                    </div>
                                    <div class="col-md-4 mt-4">
                                            <input type="submit" class="btn btn-primary" value="Submit">
                                        </div>
                                </div>
                                </form>
                            </div> <!-- end col -->
                            
                        </div>
                        </div>
                        </div>
@endsection
@push('footerscript')
   

@endpush
