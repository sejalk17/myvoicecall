
<?php $__env->startSection('title', 'Sounds - All'); ?>
<?php $__env->startPush('headerscript'); ?>
<link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')); ?>" rel="stylesheet" type="text/css" />
<style>
	.red-row {
	background-color: red !important;
	color:white !important;
	}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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
						<h4 class="mb-sm-0 font-size-18"><i class="bx bx-video-recording"></i> Speed Data</h4>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
					<div class="card">
						<div class="card-body  overflow-x-auto">
							<div class="page-title-box d-sm-flex align-items-center justify-content-between">
								<div class="page-title-right">
									<a href="<?php echo e(route('adminspeeddata.create')); ?>" class="btn btn-primary btn-sm"><i
										class="fa fa-plus"></i> Speed Data for single campaign</a>
								</div>
								<div class="page-title-right">
									<a href="<?php echo e(route('adminspeeddata.createdirect')); ?>" class="btn btn-primary btn-sm"><i
										class="fa fa-plus"></i> Speed Data for multiple campaign</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- container -->
	</div>
	<!-- content -->
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('footerscript'); ?>
<script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
<script src="<?php echo e(asset('skote/layouts/assets/js/pages/datatables.init.js')); ?>"></script> 
<!-- Responsive examples -->
<script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')); ?>"></script>
<script src="<?php echo e(asset('skote/layouts/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')); ?>"></script>
<link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/speeddata/index.blade.php ENDPATH**/ ?>