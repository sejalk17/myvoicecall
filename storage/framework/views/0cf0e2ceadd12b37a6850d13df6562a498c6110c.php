
<?php $__env->startSection('title','Create User'); ?>
<?php $__env->startPush('headerscript'); ?>
<link href="<?php echo e(asset('theme/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')); ?>" rel="stylesheet">
<style>
	.col-md-6{
	margin-bottom:10px;
	}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
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
					<h4 class="mb-sm-0 font-size-18">Create User</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="<?php echo e(route('adminspeeddata.store')); ?>" enctype="multipart/form-data">
							<?php echo csrf_field(); ?>
							<div class="row">
								<div class="col-md-6 form-group">
									<label>File Name</label>
									<select name="campaigns[]" id="campaigns" class="form-select" multiple>
										<option  >Choose...</option>
										<?php $__currentLoopData = $campaign; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option <?php if(old('campaigns') == $r->id): ?> selected <?php endif; ?> value="<?php echo e($r->id); ?>"><?php echo e($r->campaign_name); ?> (<?php echo e($r->total_count); ?>) (<?php echo e($r->username); ?>)</option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
								
								<br>
							</div>
							<div class="row">
								<div class="col-md-6 form-group">
									<button name="submitBtn" class="btn btn-primary" type="submit">Save</button>
									<button class="btn btn-danger m-l-15" type="reset">Cancel</button>
								</div>
						</form>
						</div> <!-- end col -->
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo e(asset('theme/default/assets/js/fastclick.js')); ?>"></script>
<script src="<?php echo e(asset('theme/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
$(document).ready(function() {
	  $('#campaigns').select2();
	});
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/speeddata/create.blade.php ENDPATH**/ ?>