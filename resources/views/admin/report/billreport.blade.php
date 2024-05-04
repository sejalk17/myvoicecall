@extends('admin.layout.app')
@push('headerscript')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<!-- DataTables -->
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css" integrity="sha512-gp+RQIipEa1X7Sq1vYXnuOW96C4704yI1n0YB9T/KqdvqaEgL6nAuTSrKufUX3VBONq/TPuKiXGLVgBKicZ0KA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.min.js" integrity="sha512-mh+AjlD3nxImTUGisMpHXW03gE6F4WdQyvuFRkjecwuWLwD2yCijw4tKA3NsEFpA1C3neiKhGXPSIGSfCYPMlQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
@section('content')
<div style="padding-top:10% !important">
    <div class="row">
        <div class="flash-message">
            @if (Session::has('message'))
            <center>
                <h6 class="alert {{ Session::get('alert-class', 'alert-info') }}">
                    <b>{{ Session::get('message') }}</b>
                </h6>
            </center>
            @endif
        </div> <!-- end .flash-message -->
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <h2 class="card-title text-center">Wallet Requests</h2>
                    <hr>
                    <form action="{{ url('admin/Downloadcompletetablereport') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-4">
                                Date Range
                                <div>
                                    <input style="background: #000; cursor: pointer; padding: 10px 10px; color:#fff; border: 1px solid #ccc; width: 100%" type="text" id="reportrange" name="reportrange">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                Select User
                                {!! Form::select('retailer',[''=>'-Select Retailer-']+ $retailer,
                                old('retailer'),
                                ['class'=>'form-control','id'=>'retailer_id','name'=>'retailer']) !!}
                            </div>
                            <div class="col-sm-2">
                                <div class="card border-0 w-100 p-0">
                                    <div class="card-body">
                                        <input type="submit" class="btn btn-info btn-sm" value="Download CSV">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <div class="card border-0 w-100 p-0">
                                    <div class="card-body">
                                        Sum of all data 
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                    @csrf
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>S.No.</th>
                                <th>Bill For</th>
                                <th>Retailer Name</th>
                                <th>Customer Name</th>
                                <th>Bill Number</th>
                                <th>Unique Id</th>
                                <th>Amount</th>
                                <th>Due Date</th>
                                <th>Operator/Board</th>
                                <th>Status</th>
                                <th>created_at</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <br> <br>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
</div> <!-- container-fluid -->
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
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $(function() {
        $('#datatable-buttons').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            destroy: true,
            ajax: {
                url: '{{ url('
                admin / getbillreportdata ') }}',
                data: function(d) {
                    d.reportrange = $('#reportrange').val();
                    d.retailer = $('#retailer_id').val();
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    searchable: false
                },
                {
                    data: 'utility_for',
                    name: 'utility_for'
                },
                {
                    data: 'retailer_name',
                    name: 'retailer_name'
                },
                {
                    data: 'customer_name',
                    name: 'customer_name'
                },
                {
                    data: 'bill_number',
                    name: 'bill_number'
                },
                {
                    data: 'unique_id',
                    name: 'unique_id'
                },
                {
                    data: 'bill_amount',
                    name: 'bill_amount'
                },
                {
                    data: 'due_date',
                    name: 'due_date'
                },
                {
                    data: 'operator',
                    name: 'operator'
                },
                {
                    data: 'admin_status',
                    name: 'admin_status'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'description',
                    name: 'description'
                },
            ]
        });
    });
</script>



<script>
    $(function() {
        $("#retailer_id").on('change', function() {
            $('#datatable-buttons').DataTable().draw(false)
        })
    })
</script>

<script>
    $(function() {
        $("#reportrange").on('change', function() {
            $('#datatable-buttons').DataTable().draw(false)
        })
    })
</script>


<script type="text/javascript">
    $(function() {

        var start = moment().subtract(29, 'days');
        var end = moment();

        function cb(start, end) {
            $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cb);

        cb(start, end);

    });
</script>

<script>
    $('.number').keyup(function(e) {
        if (/\D/g.test(this.value)) {
            this.value = this.value.replace(/\D/g, '');
        }
    });
</script>
<script language="javascript">
    $(function() {
        // add multiple select / deselect functionality
        $("#selectall").click(function() {
            $('.name').attr('checked', this.checked);
        });
        // if all checkbox are selected, then check the select all checkbox
        // and viceversa
        $(".name").click(function() {
            if ($(".name").length == $(".name:checked").length) {
                $("#selectall").attr("checked", "checked");
            } else {

                $("#selectall").removeAttr("checked");
            }
        });
    });
    $("#checkAll").click(function() {
        $('input:checkbox').not(this).prop('checked', this.checked);
    });
</script>

@endpush