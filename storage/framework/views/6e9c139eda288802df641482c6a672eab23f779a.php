
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
						<form method="POST" action="<?php echo e(route('sound.store')); ?>" enctype="multipart/form-data">
							<?php echo csrf_field(); ?>
							<div class="row">
								<div class="col-md-6 form-group">
									<label>File Name</label>
									<input class="form-control" type="text" id="camp_end_datetime" name="name" required value="<?php echo e(old('name')); ?>" placeholder="Enter File name">
									<div class="text-danger"><?php echo e($errors->first('name')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Type</label>
									<select name="type" required="" class="form-select">
										<option value="">Select Type</option>
										<?php $__currentLoopData = $soundType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option <?php if(old('type') == $key): ?> selected <?php endif; ?> value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('type')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Upload file</label>
									<input type="file" class="form-control" accept="audio/mp3,audio/wav" name="voiceclip" required=""
										value="<?php echo e(old('voiceclip')); ?>">
									<div class="text-danger"><?php echo e($errors->first('voiceclip')); ?></div>
								</div>

								<div class="col-md-6 form-group">
                                    <label>Api Provider</label>
                                    <select name="apiProvider" id="apiProvider" required="" class="form-select">
                                        <option value="">Choose...</option>
                                    <?php $__currentLoopData = $apiProvider; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if(old('apiProvider') == $key): ?> selected <?php endif; ?> value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="text-danger"><?php echo e($errors->first('apiProvider')); ?></div>
                                </div>
                                <div class="col-md-6 form-group">
									<label>Provider / Cli / Username</label>
									<select name="ukey" id="ukey" class="form-select">
										<option value="">Select Provider / Cli / Username</option>
										<?php $__currentLoopData = $ukey; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($r->id); ?>"><?php echo e($r->provider); ?> / <?php echo e($r->cli); ?> / <?php echo e($r->username); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('ukey')); ?></div>
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
<script>
	$('#datepicker-autoclose').datepicker();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/sound/create.blade.php ENDPATH**/ ?>