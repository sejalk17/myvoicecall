
<?php $__env->startSection('title','Create Campaign'); ?>
<?php $__env->startPush('headerscript'); ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css" rel="stylesheet" type="text/css">
<link href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
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
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Create Campaign</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="<?php echo e(route('campaign.store')); ?>" enctype="multipart/form-data">
							<?php echo csrf_field(); ?>
							<div class="row">
								
								<div class="col-md-6 form-group">
									<label>Provider / Cli / Username / Service No</label>
									<select name="ukey" id="ukey" class="form-select" required>
										<option value="">Select Provider / Cli / Username / Service No</option>
										<?php $__currentLoopData = $ukey; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($r->id); ?>"><?php echo e($r->provider); ?> / <?php echo e($r->cli); ?> / <?php echo e($r->username); ?> / <?php echo e($r->number); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('ukey')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Campaign Type</label>
									<select name="type" required="" class="form-select">
										<option value="">Select Type</option>
										<?php $__currentLoopData = $soundType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('type')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<div class="row">
										<div class="col-md-6 form-group">
									<label>Schedule</label><br>
										<input type="radio" id="now" name="schedule" value="0" checked>
										<label for="now">Now</label>&nbsp;&nbsp;
										<input type="radio" id="later" name="schedule" value="1">
										<label for="later">Later</label>
										<div class="text-danger"><?php echo e($errors->first('schedule')); ?></div>
									</div>
									<div class="col-md-6 form-group">
										<label>Upload Type</label><br>
										<input type="radio" id="csv" name="upload_type" onclick="uploadTypeCheck('csv')" value="csv" checked>
										<label for="csv">Csv</label>&nbsp;&nbsp;
										<input type="radio" id="manual" onclick="uploadTypeCheck('manual')" name="upload_type" value="manual">
										<label for="manual">Manual</label>
										<div class="text-danger"><?php echo e($errors->first('schedule')); ?></div>
									</div>
								</div>
								</div>
								<div class="col-md-6 form-group" id="upload-data">
									<label>Upload Data</label>
									<input type="file" class="form-control" accept=".csv" id="excel_file_upload" name="excel_file_upload" required=""
										value="<?php echo e(old('excel_file_upload')); ?>">
									<div class="text-danger"><?php echo e($errors->first('excel_file_upload')); ?></div>
								</div>
								<div class="col-md-6 form-group" id="manual-data" style="display: none;">
									<label>Manual Data</label>
									<textarea name="manual_data" cols="30" rows="5" maxlength="1200" class="form-control" id="manual_data"><?php echo e(old('manual_data')); ?></textarea>
									<div class="text-danger"><?php echo e($errors->first('manual_data')); ?></div>
								</div>
								
								<div class="col-md-6 form-group">
									<label>Voice List</label>
									<select name="voiceclip" required="" class="form-select">
										<option value="">Select Type</option>
										<?php $__currentLoopData = $soundList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option value="<?php echo e($r->id); ?>"><?php echo e($r->name); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('voiceclip')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Retry Attempt</label>
									<select name="retry_attempt" required="" class="form-select">
										<option value="0">No Retry</option>
										<option value="1">1</option>
										<option value="2">2</option>
									</select>
									<div class="text-danger"><?php echo e($errors->first('retry_attempt')); ?></div>
								</div>
								<div class="col-md-6 form-group">
                                    <label>Plan type</label>
                                    <select name="plan_type"  required="" class="form-select">
                                    <?php $__currentLoopData = $planType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if(old('plan_type') == $key): ?> selected <?php endif; ?> value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="text-danger"><?php echo e($errors->first('plan_type')); ?></div>
                                </div>
								<div class="col-md-6 form-group">
									<label>Dur. Between Retry(In hours)</label>
									<select name="retry_duration" required="" class="form-select">
										<option value="0">Immediate</option>
										<option value="15">15 min</option>
										<option value="30">30 min</option>
										<option value="60">1 Hr</option>
									</select>
									<div class="text-danger"><?php echo e($errors->first('retry_duration')); ?></div>
								</div>
								
								<div class="col-md-6 form-group" id="schedule" style="display: none;">
									<label>Schedule date</label>
									<input type="text" class="form-control" name="schedule_datetime" id="schedule_datetime" value="<?php echo e(old('schedule_datetime')); ?>" placeholder="dd/mm/yyyy hh:mm"/>
									<div class="text-danger"><?php echo e($errors->first('schedule_datetime')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Plan End date</label>
									<input class="form-control" type="text" id="camp_end_datetime" name="camp_end_datetime" value="<?php echo e(old('camp_end_datetime')); ?>" placeholder="dd/mm/yyyy hh:mm">
									<div class="text-danger"><?php echo e($errors->first('camp_end_datetime')); ?></div>
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.js"></script>
<script>
	jQuery('#schedule_datetime').datetimepicker();
	jQuery('#camp_end_datetime').datetimepicker({
	    language: 'en',
	    format: 'yyyy-MM-dd hh:mm'
	});
</script>
<script>
	const showInputRadio = document.getElementById('later');
	const hideInputRadio = document.getElementById('now');
	const inputBox = document.getElementById('schedule');
	
	showInputRadio.addEventListener('change', function () {
	    if (showInputRadio.checked) {
	        inputBox.style.display = 'block';
	    }
	});
	
	hideInputRadio.addEventListener('change', function () {
	    if (hideInputRadio.checked) {
	        inputBox.style.display = 'none';
	    }
	});


	function uploadTypeCheck(type){
		if(type == 'csv'){
			$('#manual-data').hide();
			$('#upload-data').show();
            $('#excel_file_upload').attr('required',true);
            $('#manual_data').attr('required',false);
		}else{
			$('#manual-data').show();
			$('#upload-data').hide();
            $('#excel_file_upload').attr('required',false);
            $('#manual_data').attr('required',true);
		}
	}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/campaign/create.blade.php ENDPATH**/ ?>