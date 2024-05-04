
<?php $__env->startPush('headerscript'); ?>
    <!-- DataTables -->
    <link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')); ?>"
        rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')); ?>"
        rel="stylesheet" type="text/css" />

    <!-- Responsive datatable examples -->
    <link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')); ?>"
        rel="stylesheet" type="text/css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Dashboard -> <?php echo e(Auth::user()->first_name); ?></h4>
                    </div>
                </div>
                <?php
                $message = '';  
                    $userDetails = App\Models\UserDetail::where('user_id', Auth::user()->id)->first();

                    if ($userDetails) {
                        $planEndDate = strtotime($userDetails->plan_end_date); // Convert string to timestamp

                        // Calculate the difference in seconds for 7 days
                        $sevenDaysInSeconds = 7 * 24 * 60 * 60;
                       
                        // Check if the plan expiry is within the next 7 days
                        if ($planEndDate - time() <= $sevenDaysInSeconds) {
                            // Show an alert or flash a message
                            $message = 'Your plan will expire within 7 days. Please consider renewing. your Plan expiry date is ' . date('d M Y', strtotime($userDetails->plan_end_date));
                        }
                    }
                ?>
                <?php if($message): ?>
                    <div class="alert alert-danger text-center">
                        <b>
                            <?php echo e($message); ?></b>
                    </div>
                <?php endif; ?>
            </div>
            <div class="row">
                <div class="col-12 mb-3">
                    <div class="">
                        <div class=" ">
                            <!--<div class="row">-->
                            <div id="reportrange">
                                <i class="fa fa-calendar icon-gradient"></i>
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>
                        </div>
                        <!--</div>-->
                    </div>
                </div>
            </div>
            <?php
                $userWallet = Auth()->user()->wallet;
            ?>
            <div class="row ">
                <div class="col-xl-3">
                    <div class="card bg-blue">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h3 class="mb-0 f-26-bold"><?php echo e(number_format($userWallet)); ?></h3>
                                    <p class="text-bold-00">Credit</p>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                        <span class="avatar-title rounded-circle">
                                            <i class="rounded-circle">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"
                                                    viewBox="0 0 24 24">
                                                    <circle cx="15.5" cy="13.5" r="2.5" fill="currentColor" />
                                                    <path fill="currentColor"
                                                        d="M12 13.5c0-.815.396-1.532 1-1.988A2.47 2.47 0 0 0 11.5 11a2.5 2.5 0 1 0 0 5a2.47 2.47 0 0 0 1.5-.512a2.486 2.486 0 0 1-1-1.988z" />
                                                    <path fill="currentColor"
                                                        d="M20 4H4c-1.103 0-2 .897-2 2v12c0 1.103.897 2 2 2h16c1.103 0 2-.897 2-2V6c0-1.103-.897-2-2-2zM4 18V6h16l.002 12H4z" />
                                                </svg></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card mini-stats-wid bg-red">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 f-26-bold" id="campaign-count">
                                                0</h4>
                                            <p class="text-bold-00">Campaign</p>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                <span class="avatar-title red">
                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid bg-darkblue">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 f-26-bold" id="answered-count">
                                                0</h4>
                                            <p class="text-bold-00">Answered</p>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center ">
                                            <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                <span class="avatar-title rounded-circle darkblue ">
                                                    <i class="bx bx-archive-in font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid  bg-brown ">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 f-26-bold" id="notanswered-count">
                                                0</h4>
                                            <p class="text-bold-00">No Answered</p>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle  mini-stat-icon">
                                                <span class="avatar-title rounded-circle brown  ">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card mini-stats-wid  bg-brown ">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h4 class="mb-0 f-26-bold" id="answeredcredit-count">
                                                0</h4>
                                            <p class="text-bold-00">Credit Deduction</p>
                                        </div>
                                        <div class="flex-shrink-0 align-self-center">
                                            <div class="avatar-sm rounded-circle  mini-stat-icon">
                                                <span class="avatar-title rounded-circle brown  ">
                                                    <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end row -->
                </div>
            </div>
            <!-- end row -->



            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Latest Campaign</h4>
                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap mb-0">
                                    <thead class="table-light">
                                        <tr>

                                            <th class="align-middle">S.NO.</th>
                                            <th class="align-middle">Date</th>
                                            <th class="align-middle">Campaign Name</th>
                                            <th class="align-middle">Created By</th>
                                            <th class="align-middle">Total Count</th>
                                            <th class="align-middle">Answered</th>
                                            <th class="align-middle">Not Answered</th>


                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $campaign; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td class="product-p">
                                                    <span class="product-price-wrapper">
                                                        <span class=""><?php echo e($loop->iteration); ?></span>
                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        <?php echo e(date('d-m-Y', strtotime($r->created_at))); ?>

                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        <?php echo e($r->campaign_name); ?>

                                                    </span>
                                                </td>
                                                <?php
                                                    $user_detail = App\Models\User::where('id', $r->user_id)->first();
                                                ?>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        <?php echo e($user_detail->first_name); ?> <?php echo e($user_detail->last_name); ?>

                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        <?php echo e($r->total_count); ?>

                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        <?php echo e($r->success_count); ?>

                                                    </span>
                                                </td>
                                                <td class="product-headline text-left wide-column">
                                                    <span class="product-price-wrapper">
                                                        <?php echo e($r->failed_count); ?>

                                                    </span>
                                                </td>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- end table-responsive -->
                        </div>
                    </div>
                </div>
            </div>
           
            <!-- end row -->
        </div>
        <!-- container-fluid -->
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footerscript'); ?>
    <script src="<?php echo e(asset('skote/layouts/assets/js/pages/form-validation.init.js')); ?>"></script>
    <!-- Required datatable js -->
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <!-- Buttons examples -->
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js')); ?>">
    </script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/jszip/jszip.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/pdfmake/build/pdfmake.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/pdfmake/build/vfs_fonts.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.html5.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.print.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js')); ?>"></script>
    <!-- Responsive examples -->
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>">
    </script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')); ?>">
    </script>
    <!-- Datatable init js -->
    <script src="<?php echo e(asset('skote/layouts/assets/js/pages/datatables.init.js')); ?>"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $('.number').keyup(function(e) {
            if (/\D/g.test(this.value)) {
                this.value = this.value.replace(/\D/g, '');
            }
        });
    </script>


    <script type="text/javascript">
        jQuery(function() {

            var start = moment().startOf('year');
            var end = moment();

            function cb(start, end) {
                $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                //alert(start.format('YYYY-M-D'));
                // alert(end.format('YYYY-M-D'));

                $.ajax({
                    url: "<?php echo e(route('user.filterDateBase')); ?>",
                    method: 'GET',
                    dataType: "json",
                    data: {
                        'start': start.format('MMMM D, YYYY h:mm A'),
                        'end': end.format('MMMM D, YYYY h:mm A')
                    },
                    success: function(response) {
                        $('#campaign-count').text(response.campaign);
                        $('#answered-count').text(response.answered);
                        $('#notanswered-count').text(response.notanswered);
                        $('#answeredcredit-count').text(response.answeredCreditCount);
                    },
                    error: function(xhr, status, error) {
                        console.log('error:' + error);
                    }
                });
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
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                }
            }, cb);

            cb(start, end);

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('user.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/user/home.blade.php ENDPATH**/ ?>