
<?php $__env->startSection('title','Create User'); ?>
<?php $__env->startPush('headerscript'); ?>
<link href="<?php echo e(asset('theme/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')); ?>" rel="stylesheet">
<link href="https://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
					<h4 class="mb-sm-0 font-size-18">Create User</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-md-12 col-lg-12 col-sm-12">
				<div class="card">
					<div class="card-body">
						<form method="POST" action="<?php echo e(route('user.store')); ?>" enctype="multipart/form-data">
							<?php echo csrf_field(); ?>

							<!--  For Both Type of user --->
							<div class="row">
								<div class="col-md-6 form-group">
									<label>First Name</label>
									<input type="text" name="first_name" class="form-control" value="<?php echo e(old('first_name')); ?>" placeholder="Enter First Name" required=""/>
									<div class="text-danger"><?php echo e($errors->first('first_name')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Last Name</label>
									<input type="text" name="last_name" class="form-control" value="<?php echo e(old('last_name')); ?>" placeholder="Enter Last Name" required=""/>
									<div class="text-danger"><?php echo e($errors->first('last_name')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Email</label>
									<input type="email" class="form-control" name="email" required=""
										value="<?php echo e(old('email')); ?>" placeholder="Enter Email">
									<div class="text-danger"><?php echo e($errors->first('email')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>User name</label>
									<input type="text" class="form-control" name="username" required=""
										value="<?php echo e(old('username')); ?>" placeholder="Enter Username">
									<div class="text-danger"><?php echo e($errors->first('username')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Mobile</label>
									<input type="text" class="form-control" name="mobile" required=""
										value="<?php echo e(old('mobile')); ?>" placeholder="Enter Mobile No.">
									<div class="text-danger"><?php echo e($errors->first('mobile')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Password</label>
									<input type="password" class="form-control" name="password" required=""
										value="<?php echo e(old('password')); ?>" placeholder="Enter Password">
									<div class="text-danger"><?php echo e($errors->first('password')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>User Role</label>
									<select name="role" required="" class="form-select">
									<?php $__currentLoopData = $role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option <?php if(old('role') == $value): ?> selected <?php endif; ?>  value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('role')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Logo</label>
									<input type="file" class="form-control" accept="image/*" name="logo_image"
										value="<?php echo e(old('logo_image')); ?>">
									<div class="text-danger"><?php echo e($errors->first('logo_image')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Address</label>
									<input type="text" class="form-control" name="address" required=""
										value="<?php echo e(old('address')); ?>" placeholder="Enter Address">
									<div class="text-danger"><?php echo e($errors->first('address')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Company Name</label>
									<input type="text" class="form-control" name="company_name" required=""
										value="<?php echo e(old('company_name')); ?>" placeholder="Enter Company Name">
									<div class="text-danger"><?php echo e($errors->first('company_name')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>User Plan</label>
									<select name="user_plan" required="" class="form-select" id="user_plan">
										<option value="0"> No Plan </option>
										<?php $__currentLoopData = $plan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option <?php if(old('user_plan') == $value->id): ?> selected <?php endif; ?> value="<?php echo e($value->id); ?>"><?php echo e($value->title); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('user_plan')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Credit(Wallet)</label>
									<input type="text" class="form-control" name="wallet" required=""
										value="<?php echo e(old('wallet')); ?>" placeholder="Enter Credit">
									<div class="text-danger"><?php echo e($errors->first('wallet')); ?></div>
								</div>

								<div class="col-md-6 form-group" id="user_plan_start_div" style="display:none;">
									<label>Plan start date</label>
									<input type="text" class="form-control" name="user_plan_start_date" 
										value="<?php echo e(old('user_plan_start_date')); ?>" placeholder="yyyy/mm/dd" id="user_plan_start_date">
									<div class="text-danger"><?php echo e($errors->first('user_plan_start_date')); ?></div>
								</div>
								<div class="col-md-6 form-group" id="user_plan_end_div" style="display:none;">
									<label>Plan End date</label>
									<input type="text" class="form-control" name="user_plan_end_date"
										value="<?php echo e(old('user_plan_end_date')); ?>" placeholder="yyyy/mm/dd" id="user_plan_end_date">
									<div class="text-danger"><?php echo e($errors->first('user_plan_end_date')); ?></div>
								</div>
							<div>
							
							<!--  For FLIPKART  calling --->
							<div class="row">
								<div class="col-md-12 form-group">
									<h3 class="text-center" style="margin-top:20px; background-color:#e1e3e4; padding:15px 0">For FLIPKART  calling</h3>
								</div>
								<div class="col-md-6 form-group">
									<label>Cts Number</label>
									<select name="ctsNumber[]" id="ctsNumber" class="form-select" multiple="multiple">
										<option  >Choose...</option>
										<?php $__currentLoopData = $ctsNumberArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option <?php if(old('ctsNumber') == $key): ?> selected <?php endif; ?> value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('apiProvider')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>User type</label>
									<select name="user_type"  required="" class="form-select">
									<?php $__currentLoopData = $userType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option <?php if(old('user_type') == $key): ?> selected <?php endif; ?> value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('user_type')); ?></div>
								</div>
                                <div class="col-md-6 form-group">
									<label>Campaign Type</label>
									<select name="camp_type" class="form-select">
										<option value="">Select Type</option>
										<?php $__currentLoopData = $soundType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option <?php if(old('camp_type') == $key): ?> selected <?php endif; ?> value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('type')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Retry Attempt</label>
									<select name="retry_option"  required="" class="form-select">
									<?php $__currentLoopData = $retryOption; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
									<option <?php if(old('retry_option') == $key): ?> selected <?php endif; ?> value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
									<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('retry_option')); ?></div>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-md-6 form-group">
											<label>API</label>
											<div class="form-check mb-3">
												<input type="radio" id="api_disable" name="api_status" value="0" <?php if(old('api_status') == "0"): ?> checked <?php else: ?> checked <?php endif; ?> >
												<label for="now">Disable</label>&nbsp;&nbsp;
												<input type="radio" id="api_enable" name="api_status" value="1" <?php if(old('api_status') == "1"): ?> checked <?php endif; ?>>
												<label for="later">Enable</label>
												<div class="text-danger"><?php echo e($errors->first('api_status')); ?></div>
											</div>
										</div>
										<div class="col-md-6 form-group">
											<label>DND</label>
											<div class="form-check mb-3">
												<input type="radio" id="dnd_disbale" name="dnd_status" value="0" <?php if(old('dnd_status') == "0"): ?> checked <?php else: ?> checked <?php endif; ?>>
												<label for="now">Disable</label>&nbsp;&nbsp;
												<input type="radio" id="dnd_enable" name="dnd_status" value="1" <?php if(old('dnd_status') == "1"): ?> checked <?php endif; ?>>
												<label for="later">Enable</label>
												<div class="text-danger"><?php echo e($errors->first('dnd_status')); ?></div>
											</div>
										</div>
									</div>
								</div>
								
							<div>
							
							<div class="row">

								<div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Filpkart calling</label>
                                    <input type="radio" id="obd" name="obd" value="0">
                                    <label for="obd"> No</label>
                                    <input type="radio" id="obd" name="obd" value="1" checked>
                                    <label for="obd"> Yes</label>
									<div class="text-danger small"><?php echo e($errors->first('obd')); ?></div>
                                </div>

                                <div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">DTMF </label>
                                    <input type="radio" id="obd" name="dtmf" value="0" checked>
                                    <label for="dtmf"> No</label>
                                    <input type="radio" id="obd" name="dtmf" value="1">
                                    <label for="dtmf"> Yes</label>
									<div class="text-danger small"><?php echo e($errors->first('dtmf')); ?></div>
                                </div>

								<div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Whatsapp Message </label>
                                    <input type="radio" id="whtsapp_msg" name="whtsapp_msg" value="0" checked>
                                    <label for="dtmf"> No</label>
                                    <input type="radio" id="whtsapp_msg" name="whtsapp_msg" value="1">
                                    <label for="dtmf"> Yes</label>
									<div class="text-danger small"><?php echo e($errors->first('whtsapp_msg')); ?></div>
                                </div>

                                <div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Call Patching </label>
                                    <input type="radio" id="obd" name="call_patching" value="0" checked>
                                    <label for="call_patching"> No</label>
                                    <input type="radio" id="obd" name="call_patching" value="1">
                                    <label for="call_patching"> Yes</label>
									<div class="text-danger small"><?php echo e($errors->first('call_patching')); ?></div>
                                </div>

                                <div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">IBD </label>
                                    <input type="radio" id="ibd" name="ibd" value="0" checked>
                                    <label for="ibd"> No</label>
                                    <input type="radio" id="ibd" name="ibd" value="1">
                                    <label for="ibd"> Yes</label>
									<div class="text-danger small"><?php echo e($errors->first('ibd')); ?></div>
                                </div>
								
								<div class="col-md-12">
                                    <label for="example-date-input" class="col-md-4 col-form-label">Filpkart Campaign Schedule</label>
                                    <input type="radio" id="obd_schedule" name="obd_schedule" value="0" checked>
                                    <label for="obd_schedule"> No</label>
                                    <input type="radio" id="obd_schedule" name="obd_schedule" value="1">
                                    <label for="obd_schedule"> Yes</label>
									<div class="text-danger small"><?php echo e($errors->first('obd_schedule')); ?></div>
                                </div>
						
								<div class="col-md-6 form-group">
									<label>Account start date</label>
									<input type="text" class="form-control" name="plan_start_date" required=""
										value="<?php echo e(old('plan_start_date')); ?>" placeholder="yyyy/mm/dd" id="plan_start_date">
									<div class="text-danger"><?php echo e($errors->first('plan_start_date')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Account End date</label>
									<input type="text" class="form-control" name="plan_end_date" required=""
										value="<?php echo e(old('plan_end_date')); ?>" placeholder="yyyy/mm/dd" id="plan_end_date">
									<div class="text-danger"><?php echo e($errors->first('plan_end_date')); ?></div>
								</div>
								<br>
							</div>
                            <div class="row" id="tabdata">
                            <button type="button" id="addrow"class="btn btn-info pull-right m-l-20">
                                <i class="fa fa-plus"></i></button>
                                <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>Plan type</label>
                                    <select name="plan_type[0][]"  required="" class="form-select">
                                        <?php $__currentLoopData = $planType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if(old('plan_type') == $key): ?> selected <?php endif; ?> value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <div class="text-danger"><?php echo e($errors->first('plan_type')); ?></div>
                                </div>
                                
                                <div class="col-md-6 form-group ">
									<label>Price</label>
									<div class="price-gap">

										<input type="text" name="plan_type[0][]" class="form-control" value="<?php echo e(old('price')); ?>" placeholder="Price" />
										<div class="text-danger"><?php echo e($errors->first('price')); ?></div>
									</div>
								</div>
                                </div>
                                
                            </div>

							<!--  For Agent calling --->
							<div class="row">
								<div class="col-md-12 form-group">
									<h3 class="text-center" style="margin-top:20px; background-color:#e1e3e4; padding:15px 0">
										For Agent Calling
									</h3>
								</div>
								<div class="col-md-6 form-group">
									<label>No Of active Agent</label>
									<input type="text" name="active_agent" class="form-control" value="<?php echo e(old('active_agent')); ?>" placeholder="No of active Agent" />
									<div class="text-danger"><?php echo e($errors->first('active_agent')); ?></div>
								</div>
								<div class="col-md-6 form-group">
									<label>Cts Number (Agent Calling)</label>
									<select name="agentCtsNumber[]" id="agentCtsNumber" class="form-select" multiple="multiple">
										<option  >Choose...</option>
										<?php $__currentLoopData = $ctsAgentNumberArray; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
										<option <?php if(old('agentCtsNumber') == $key): ?> selected <?php endif; ?> value="<?php echo e($key); ?>"><?php echo e($value); ?></option>
										<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
									<div class="text-danger"><?php echo e($errors->first('apiProvider')); ?></div>
								</div>
							<div>
							
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
<script src="//cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>

	const userPlan = document.getElementById('user_plan');
	const userPlanStartDate = document.getElementById('user_plan_start_div');
	const userPlanEndDate = document.getElementById('user_plan_end_div');
	var originalDate = new Date();

	userPlan.addEventListener('change', function() {
		var selectedValue = userPlan.value; // Get the selected value of the select box
		// Assuming you want to show retryDuration when a specific option is selected
		if (selectedValue > 0 ) {
			userPlanStartDate.style.display = 'block';
			userPlanEndDate.style.display = 'block';
			var newEndDate = new Date(originalDate.getFullYear(), originalDate.getMonth() + 1, originalDate.getDate());
			jQuery('#user_plan_start_date').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			jQuery('#user_plan_end_date').datepicker({
				dateFormat: 'yy-mm-dd'
			});
			jQuery('#user_plan_start_date').datepicker('setDate', '0');
			jQuery('#user_plan_end_date').datepicker('setDate', newEndDate);
		} else {
			userPlanStartDate.style.display = 'none';
			userPlanEndDate.style.display = 'none';
		}
	});


	jQuery('#plan_end_date').datepicker({
	    dateFormat: 'yy-mm-dd'
	});
	
	var newDate = new Date(originalDate.getFullYear(), originalDate.getMonth() + 3, originalDate.getDate());
	

	jQuery('#plan_end_date').datepicker('setDate', newDate);
	jQuery('#plan_start_date').datepicker({
	    dateFormat: 'yy-mm-dd',
	});
	

	
	

	$('#plan_start_date').datepicker('setDate', '0');
</script>
<script>
	$(document).ready(function() {
	  $('#ctsNumber').select2();
	  $('#agentCtsNumber').select2();
	});

    let i = 11;
    $('#addrow').on("click", function () {
        var newRow = $("<tr>");
        var cols = "";
        cols += '<div class="row"><div class="col-md-6 form-group"><select name="plan_type[' + i + '][]" required class="form-select" id=product_id_' + i + ' required><?php $__currentLoopData = $planType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key =>$prow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($key); ?>"><?php echo e($prow); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>';
        cols += ' <div class="col-md-6 form-group"><input class="form-control" type="text" name="plan_type[' + i + '][]"  id=hsn_' + i + ' " required placeholder="Price"><button type="button" id="delbtn" class="btn btn-danger btn-sm"><i class="fa fa-minus"></i></button></div></div>';
            i++;
        newRow.append(cols);
        $("#tabdata").append(cols);
    });
    $("#tabdata").on("click", "#delbtn", function () {
        $(this).closest('.row').remove();
        i--;
    });

    
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/user/create.blade.php ENDPATH**/ ?>