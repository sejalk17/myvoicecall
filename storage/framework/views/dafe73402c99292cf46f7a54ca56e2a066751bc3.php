<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Login | FILPKART</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
		<meta content="Themesbrand" name="author" />
		<!-- App favicon -->
		<link rel="shortcut icon" href="<?php echo e(asset('skote/layouts/assets/images/logo.png')); ?>">
		<!-- Bootstrap Css -->
		<link href="<?php echo e(asset('skote/layouts/assets/css/bootstrap.min.css')); ?>" id="bootstrap-style" rel="stylesheet"
			type="text/css" />
		<!-- Icons Css -->
		<link href="<?php echo e(asset('skote/layouts/assets/css/icons.min.css')); ?>" rel="stylesheet" type="text/css" />
		<!-- App Css-->
		<link href="<?php echo e(asset('skote/layouts/assets/css/app.min.css')); ?>" id="app-style" rel="stylesheet" type="text/css" />
		<style>
			.btn-primary.outline-btn{
				background: transparent;
    			color: #556ee6;
			}
		</style>
	</head>
	<body>
		<div class="account-pages pt-sm-5">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8 col-lg-6 col-xl-5">
						<div class="card overflow-hidden">
							<div class="bg-primary bg-soft login-page" >
								<div class="row">
									<div class="col-7">
										<div class="text-primary p-4">
											<h5 class="text-primary" style="color:#fff !important">Welcome Back !</h5>
											<p style="color:#fff !important">Sign in to continue to <b>FILPKART</b>.</p>
										</div>
									</div>
									<div class="col-5">
										<img src="https://myvoicecall.com/skote/layouts/assets/images/logo-light.png"
											alt="" class="img-fluid" style="margin-top:20px">
									</div>
								</div>
							</div>
							<div class="card-body pt-0">
								<div class="auth-logo">
									<a href="#" class="auth-logo-light">
										<div class="avatar-md profile-user-wid mb-4">
											<span class="avatar-title rounded-circle bg-light">
											<img src="<?php echo e(asset('skote/layouts/assets/images/voice.png')); ?>"
												alt="" class="rounded-circle" height="34">
											</span>
										</div>
									</a>
									<a href="#" class="auth-logo-dark">
										<div class="avatar-md profile-user-wid mb-4">
											<span class="avatar-title rounded-circle bg-light">
											<img src="<?php echo e(asset('skote/layouts/assets/images/voice.png')); ?>"
												alt="" class="rounded-circle" height="34">
											</span>
										</div>
									</a>
								</div>
								<div class="p-2">
									<?php if(session('plan_expired')): ?>
									<div class="alert alert-danger">
										<?php echo e(session('plan_expired')); ?>

									</div>
									<?php endif; ?>
									<form method="POST" action="<?php echo e(route('login')); ?>">
										<?php echo csrf_field(); ?>
										<div class="mb-3">
											<label for="email" class="form-label"><?php echo e(__('Username')); ?></label>
											<input id="username" type="text"
												class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="username"
												value="<?php echo e(old('username')); ?>" placeholder="Enter UserName" required
												autocomplete="username" autofocus>
											<?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
											<span class="invalid-feedback" role="alert">
											<strong><?php echo e($message); ?></strong>
											</span>
											<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
										</div>
										<div class="mb-3">
											<label class="form-label"><?php echo e(__('Password')); ?></label>
											<div class="input-group auth-pass-inputgroup">
												<input type="password" id="password"
													class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
													name="password" placeholder="Enter password" aria-label="Password"
													aria-describedby="password-addon">
												<?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
												<span class="invalid-feedback" role="alert">
												<strong><?php echo e($message); ?></strong>
												</span>
												<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
												<button class="btn btn-light " type="button" id="password-addon"><i
													class="mdi mdi-eye-outline"></i></button>
											</div>
										</div>
										<div class="form-check">
											<input class="form-check-input" type="checkbox" name="remember"
											id="remember-check" <?php echo e(old('remember') ? 'checked' : ''); ?>>
											<label class="form-check-label" for="remember-check">
											<?php echo e(__('Remember Me')); ?>

											</label>
										</div>
										<div class="mt-3 d-grid">
											<button class="btn btn-primary waves-effect waves-light"
												type="submit"><?php echo e(__('Login')); ?></button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- end account-pages -->
		<!-- JAVASCRIPT -->
		<script src="<?php echo e(asset('skote/layouts/assets/libs/jquery/jquery.min.js')); ?>"></script>
		<script src="<?php echo e(asset('skote/layouts/assets/libs/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
		<script src="<?php echo e(asset('skote/layouts/assets/libs/metismenu/metisMenu.min.js')); ?>"></script>
		<script src="<?php echo e(asset('skote/layouts/assets/libs/simplebar/simplebar.min.js')); ?>"></script>
		<script src="<?php echo e(asset('skote/layouts/assets/libs/node-waves/waves.min.js')); ?>"></script>
		<!-- App js -->
		<script src="<?php echo e(asset('skote/layouts/assets/js/app.js')); ?>"></script>
	</body>
</html><?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/auth/login.blade.php ENDPATH**/ ?>