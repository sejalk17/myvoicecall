@extends('admin.layout.app')
@push('headerscript')
<style>
    .toast-success{
        background-color: #04AA6D;
        top: 10%;
    }
  </style>
    <!-- DataTables -->
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

@endpush
@section('content')
    <div style="padding-top:10% !important">
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
                    <div class="card">
                        <div class="card-body">

                            <h2 class="card-title text-center">Camp Type</h2>
                            <div class="col-md-4 mt-4">
                                {{-- <a href="{{ route('ukey.create') }}"> <input type="create_amount"
                                        class="btn btn-primary" value="Create Ukey"></a> --}}
                            </div>
                            <hr>
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                               
                                <!-- <input type="button" name="check" value="Deselect All" class="btn btn-primary" onclick='deSelect()'> -->
                                <thead>
                                   
                                    <tr>
                                        {{-- <th><input type="checkbox" name="check" value="Check" class="btn btn-primary" onclick='selects()'> --}}
                                        </th>
                                        <th>S.No.</th>
                                        <th>Type</th>
                                        {{-- <th>Status</th> --}}
                                        {{-- <th>Username</th>
                                        <th>Ukey / Password</th>
                                        <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($lists as $r)
                                        <tr>
                                            {{-- <td><input type="checkbox" name="chk" id=""></td> --}}
                                            <td>{{ $loop->iteration }}</td>
                                           
                                        
                                            <td>
                                                {{ $r->camp }}
                                            </td>
                                            {{-- <td>
                                                <input type="checkbox" data-id="{{ $r->id }}" name="status" class="js-switch" {{$r->status == 1 ? 'checked' : '' }}>
                                            </td> --}}
                                            {{-- <td>
                                                {{ $r->username }}
                                            </td>
                                            <td>
                                                {{ $r->ukey }}
                                            </td>
                                            <td>
                                                <a href="{{route('ukey.edit',$r->id)}}" class="btn btn-success btn-rounded"><i class="fa fa-pencil-alt"></i></a>
                                            </td> --}}
                                           
                                           
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

@endsection
@push('footerscript')
    <script src="{{ asset('skote/layouts/assets/js/pages/form-validation.init.js') }}"></script>
    <!-- Required datatable js -->
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Buttons examples -->
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}">
    </script>
    <script src="{{ asset('skote/layouts/assets/libs/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- Responsive examples -->
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}">
    </script>
    <!-- Datatable init js -->
    <script src="{{ asset('skote/layouts/assets/js/pages/datatables.init.js') }}"></script>

    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    {{-- <script src="http://code.jquery.com/jquery-3.4.1.js"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>
    <style>
        .toast-success{
            background-color: #04AA6D;
            top: 10%;
        }
      </style>
    <script>let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

        elems.forEach(function(html) {
            let switchery = new Switchery(html,  { size: 'small' });
        });
        
        

        $(document).ready(function(){
    $('.js-switch').change(function () {
      
        let status = $(this).prop('checked') === true ? 1 : 0;
        let ID = $(this).data('id');
        
        if (confirm("Are you sure you want to change the camp type status?")) {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('admincamptype.statusUpdate') }}",
                data: {'status': status, 'id': ID}, 
                success: function (data) {
                    toastr.options.closeButton = true;
                    toastr.options.closeMethod = 'fadeOut';
                    toastr.options.closeDuration = 100;
                    toastr.success(data.message);
                    console.log(data.message);
                }
            });
        } else {
            $(this).prop('checked', !status);
            return false;
        }
    });
});
        
        </script>
 
@endpush
