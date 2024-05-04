    
    <?php $__env->startSection('title', 'Users - All'); ?>
    <?php $__env->startPush('headerscript'); ?>
    <link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />     
    <style>
    .red-row {
        background-color: red !important;
        color:white !important;
    }
    .select2-container--default .select2-selection--single {
    background-color: #fff;
    border: 1px solid #aaa;
    border-radius: 4px;
    height: 38px !important;
    padding: 4px !important;
}
.select2-container {
    box-sizing: border-box;
    display: inline-block;
    margin: 0;
    position: relative;
    vertical-align: middle;
    width: 100% !important;
}
    </style>
    <?php $__env->stopPush(); ?>
    <?php $__env->startSection('content'); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="page-content">
            <!-- Start content -->
            <div class="">
                <div class="container-fluid">
                    <?php if(session()->has('error')): ?>
                    <div class="alert alert-danger">
                        <?php echo e(session()->get('error')); ?>

                    </div>
                    <?php endif; ?>
                    <?php if(session()->has('success')): ?>
                    <div class="alert alert-success">
                        <?php echo e(session()->get('success')); ?>

                    </div>
                    <?php endif; ?>
                            <div class="row">
                                <div class="col-12">
                                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                        <h4 class="mb-sm-0 font-size-18"><i class="bx bxs-user-rectangle"></i> Users</h4>

                                        <div class="page-title-right">
                                            <a href="<?php echo e(route('user.create')); ?>" class="btn btn-primary btn-sm"><i
                                    class="fa fa-plus"></i> Add   User</a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
                                <div class="card">
                                        <div class="card-body overflow-x-auto">
                                <div class="clearfix"></div>
                                <form action="<?php echo e(request()->url()); ?>" method="get">
                                <div class="row p-2">
                                    <div class="offset-sm-9 col-md-3">
                                        <select name="user" id="user" class="form-control selectpicker" onchange="this.form.submit()">
                                            <option value="">Select Reseller</option>
                                            <?php $__currentLoopData = $reseller; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <option <?php if(request()->user == $rr->id): ?> selected <?php endif; ?> value="<?php echo e($rr->id); ?>"><?php echo e($rr->first_name); ?> <?php echo e($rr->last_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </form>
                                    <table class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                                        width="100%" id="datatable">
                                        <thead>
                                            <tr>
                                                <th>S.NO.</th>
                                                <!--<th>Check</th>-->
                                                <th>User Name</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone </th>
                                                <th>Credit</th>
                                                <th>User Role</th>
                                                <th>Date & Time </th>
                                                <th>Action </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="modal fade bs-example-modal-center<?php echo e($r->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"><?php echo e($r->first_name.' '.$r->last_name); ?> ( Wallet Amount: <?php echo e($r->wallet); ?> )</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    <form action="<?php echo e(route('user.updateWallet')); ?>" method="post"> 
                                                                        <?php echo csrf_field(); ?>
                                                                        <input type="hidden" name="id" value="<?php echo e($r->id); ?>">
                                                                        <div class="from-group">
                                                                        <label for="amount">Promo Balance</label>
                                                                        <input type="text" name="amount" value="0" class="form-control number" min="1">
                                                                        </div>
                                                                        <div class="from-group">
                                                                        <label for="transactional_wallet">Reseller Balance</label>
                                                                        <input type="text" name="reseller_wallet" value="0" class="form-control number" min="1">
                                                                        </div>
                                                                        <div class="from-group mt-3" style="float: right">
                                                                        <input type="submit" value="Add" class="btn btn-primary">
                                                                        </div>
                                                                    </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <tr>
                                                    <td class="product-p">
                                                        <span class="product-price-wrapper">
                                                            <span class=""><?php echo e($loop->iteration); ?></span>
                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            <?php echo e($r->username); ?>

                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            <?php echo e($r->first_name); ?>

                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            <?php echo e($r->last_name); ?>

                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            <?php echo e($r->email); ?>

                                                        </span>
                                                        <br/>
                                                        <span class="product-price-wrapper" style="display:none;">
                                                            <?php echo e($r->actual_password); ?>

                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            <?php echo e($r->mobile); ?>

                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            <?php echo e($r->wallet); ?>

                                                        </span>
                                                    </td>
                                                    <td>
                                                    <?php 
                                                    $rolename = DB::table('roles')
                                                    ->select('name')
                                                    ->where('id', function($query) use ($r) {
                                                        $query->select('role_id')
                                                            ->from('model_has_roles')
                                                            ->where('model_id', $r->id);
                                                    })
                                                    ->value('name');
                                                    ?>
                                                    <span class="product-price-wrapper">

                                                            <?php echo e($rolename); ?>

                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">
                                                        <span class="product-price-wrapper">

                                                            <?php echo e(date('d-m-Y H:i:s ',strtotime($r->created_at))); ?>

                                                        </span>
                                                    </td>
                                                    <td class="product-headline text-left wide-column">

                                                        <span class="product-price-wrapper">
                                                        <a href="<?php echo e(route('user.edit',$r->id)); ?>" class="btn btn-success btn-rounded"><i class="fa fa-pencil-alt"></i></a>
                                                            <!-- <?php if($r->status=="1"): ?>
                                                            <a href="<?php echo e(url('admin/blockuser',$r->id)); ?>" class="btn btn-success btn-rounded"><i class="fa fa-unlock"></i></a>
                                                            <?php else: ?>
                                                            <a href="<?php echo e(url('admin/blockuser',$r->id)); ?>" class="btn btn-danger btn-rounded"><i class="fa fa-lock"></i></a>
                                                            <?php endif; ?> -->
                                                        </span>
                                                        <button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center<?php echo e($r->id); ?>">Wallet</button>
                                                    
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->
            </div> <!-- content -->
        </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('footerscript'); ?>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/js/pages/datatables.init.js')); ?>"></script> 

    <!-- Responsive examples -->
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
    <script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet"/>
    <script>
         $(".selectpicker").select2();
        $('.number').keyup(function(e) {
            if (/\D/g.test(this.value)) {
                    this.value = this.value.replace(/\D/g, '');
            }
        });
    </script>
    <?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/user/index.blade.php ENDPATH**/ ?>