@extends('reseller.layout.app')
@section('title', 'Sounds - All')
@push('headerscript')
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />


<style>
  .red-row {
    background-color: red !important;
    color:white !important;
  }
</style>
@endpush
@section('content')
    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <div class="page-content">
        <!-- Start content -->
        <div class="">
            <div class="container-fluid">
                <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">All Voice Files</h4>

                                    <!-- <div class="page-title-right">
                                         <a href="{{ route('resellersound.create') }}" class="btn btn-primary btn-sm"><i
                                class="fa fa-plus"></i> Add Voice File</a>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                 <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                            <div class="card">
                                    <div class="card-body">
                            <div class="clearfix"></div>
                            @if(count($reseller) != '0' )
                            <form action="{{request()->url()}}" method="get">
								<div class="row p-2">
									<div class="offset-sm-9 col-md-3">
										<select name="user" id="user" class="form-control selectpicker" onchange="this.form.submit()">
											<option value="">Select Reseller</option>
											@foreach($reseller as $rr) 
											<option @if(request()->user == $rr->id) selected @endif value="{{$rr->id}}">{{$rr->first_name}} {{$rr->last_name}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</form>
                            @endif

                                <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                    width="100%" id="datatable">
                                    <thead>
                                        <tr>
                                            <th>S.NO.</th>
                                            <!--<th>Check</th>-->
                                            <th>File Name</th>
                                            <th>Type</th>
                                            <th>Uploaded By</th>
                                            <th>Duration</th>
                                            <th>Upload Date</th>
                                            <th>Aproved Date</th>
                                            <th></th>
                                            <th>Status</th>   

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sound as $r)
                                            <tr>
                                                <td class="product-p">
                                                    <span class="product-price-wrapper">
                                                        <span class="">{{ $loop->iteration }}</span>
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">

                                                        {{ $r->name }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">

                                                        {{ $r->type }}
                                                    </span>
                                                </td>
                                                @php
                                                $user_detail   =   App\Models\User::where('id',$r->user_id)->first();
                                                @endphp
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        {{ @$user_detail->first_name }} {{ @$user_detail->last_name }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">

                                                        {{ $r->duration }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">

                                                        {{ date('d-m-Y H:i:s ',strtotime($r->created_at)) }}
                                                    </span>
                                                </td>
                                                 <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">

                                                        {{ date('d-m-Y H:i:s ',strtotime($r->updated_at)) }}
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                <!-- center modal -->
                                                <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center{{ $r->id }}"><i class="bx bx bx-play"></i> </button>

                                                <div class="modal fade bs-example-modal-center{{ $r->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Voice Clip</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                            <audio controls>
                                                                <source src="{{asset($r->voiceclip)}}" type="audio/ogg">
                                                                Your browser does not support the audio tag.
                                                            </audio>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </td>
                                                <td class="product-headline text-left wide-column ">
                                                    <div id="{{$r->id}}" class=" d-block text-center">
                                                        @if($r->status == 0)
                                                         <i class="text-danger"><img width="20" height="20" src="https://img.icons8.com/ios-glyphs/30/FA5252/hourglass--v1.png" alt="hourglass--v1"/></i>  
                                                        @else
                                                        <i class="fa fa-check text-success " aria-hidden="true"></i>      
                                                        @endif
                                                    </div>
                                                    
                                              </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- container -->
        </div> <!-- content -->
    </div>
@endsection
@push('footerscript')
<script src="{{asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('skote/layouts/assets/js/pages/datatables.init.js')}}"></script>
<script src="{{asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

    <script>
        $('.modal').on('hide.bs.modal', function () { //Change #myModal with your modal id
            $('audio').each(function(){
                this.pause(); // Stop playing
                this.currentTime = 0; // Reset time
        }); 
        })
        
        $('.number').keyup(function(e) {
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
        });
    </script>
@endpush
