<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Resgistration | OBD</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
		<meta content="Themesbrand" name="author" />
		<!-- App favicon -->
		<link rel="shortcut icon" href="{{ asset('skote/layouts/assets/images/logo.png') }}">
		<!-- Bootstrap Css -->
		<link href="{{ asset('skote/layouts/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet"
			type="text/css" />
		<!-- Icons Css -->
		<link href="{{ asset('skote/layouts/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- App Css-->
		<link href="{{ asset('skote/layouts/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
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
							<div class="bg-primary bg-soft" style="background-color:#152063 !important">
								<div class="row">
									<div class="col-7">
										<div class="text-primary p-4">
											<h5 class="text-primary" style="color:#fff !important">Welcome Back !</h5>
											<p style="color:#fff !important">Register to continue to <b>OBD</b>.</p>
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
											<img src="{{ asset('skote/layouts/assets/images/voice.png') }}"
												alt="" class="rounded-circle" height="34">
											</span>
										</div>
									</a>
									<a href="#" class="auth-logo-dark">
										<div class="avatar-md profile-user-wid mb-4">
											<span class="avatar-title rounded-circle bg-light">
											<img src="{{ asset('skote/layouts/assets/images/voice.png') }}"
												alt="" class="rounded-circle" height="34">
											</span>
										</div>
									</a>
								</div>
								<div class="p-2">
									@if (session('plan_expired'))
									<div class="alert alert-danger">
										{{ session('plan_expired') }}
									</div>
									@endif
									<form method="POST" action="{{ url('storeregister') }}" enctype="multipart/form-data">
										@csrf

                                        <div class="mb-3">
											<label for="name" class="form-label">{{ __('Name') }}</label>
											<input id="name" type="text"
												class="form-control @error('name') is-invalid @enderror" name="name"
												value="{{ old('name') }}" placeholder="Enter Name Who Create Account" required
												autocomplete="name" autofocus>
											@error('name')
											<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>


										<div class="mb-3">
											<label for="first_name" class="form-label">{{ __('First Name') }}</label>
											<input id="first_name" type="text"
												class="form-control @error('first_name') is-invalid @enderror" name="first_name"
												value="{{ old('first_name') }}" placeholder="Enter First Name" required
												autocomplete="first_name" autofocus>
											@error('first_name')
											<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

                                        <div class="mb-3">
											<label for="last_name" class="form-label">{{ __('Last Name') }}</label>
											<input id="last_name" type="text"
												class="form-control @error('last_name') is-invalid @enderror" name="last_name"
												value="{{ old('last_name') }}" placeholder="Enter Last Name"
												autocomplete="last_name" autofocus>
											@error('last_name')
											<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

                                        <div class="mb-3">
											<label for="email" class="form-label">{{ __('Email') }}</label>
											<input id="email" type="text"
												class="form-control @error('email') is-invalid @enderror" name="email"
												value="{{ old('email') }}" placeholder="Enter Email" required
												autocomplete="email" autofocus>
											@error('email')
											<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

                                        <div class="mb-3">
											<label for="username" class="form-label">{{ __('User name') }}</label>
											<input id="username" type="text"
												class="form-control @error('username') is-invalid @enderror" name="username"
												value="{{ old('username') }}" placeholder="Enter User name" required
												autocomplete="username" autofocus>
											@error('username')
											<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

                                        <div class="mb-3">
											<label for="mobile" class="form-label">{{ __('Mobile No') }}</label>
											<input id="mobile" type="text"
												class="form-control @error('mobile') is-invalid @enderror" name="mobile"
												value="{{ old('mobile') }}" placeholder="Enter Mobile No" required
												autocomplete="mobile" autofocus>
											@error('mobile')
											<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

                                        <!-- <label for="password">Password</label>
                                         <input id="password" type="password" name="password" required>
                                         @error('password')
                                         <strong>{{ $message }}</strong>
                                         @enderror
                                         <label for="password_confirmation">Confirm Password</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required> -->


                                        <div class="mb-3">
                                            <label class="password">{{ __('Password') }}</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                                    name="password" placeholder="Enter password" aria-label="Password" aria-describedby="password-addon">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="password_confirmation">{{ __('Confirm Password') }}</label>
                                            <div class="input-group auth-pass-inputgroup">
                                                <input type="password" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror"
                                                    name="password_confirmation" placeholder="Confirm password" aria-label="Confirm Password"
                                                    aria-describedby="password-addon">
                                                @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                                <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                            </div>
                                        </div>


                                        <div class="mb-3">
											<label for="address" class="form-label">{{ __('Address') }}</label>
											<input id="address" type="text"
												class="form-control @error('v') is-invalid @enderror" name="address"
												value="{{ old('address') }}" placeholder="Enter Address" required
												autocomplete="address" autofocus>
											@error('address')
											<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>

                                        <div class="mb-3">
											<label for="company_name" class="form-label">{{ __('Company Name') }}</label>
											<input id="company_name" type="text"
												class="form-control @error('v') is-invalid @enderror" name="company_name"
												value="{{ old('company_name') }}" placeholder="Enter Company Name" required
												autocomplete="company_name" autofocus>
											@error('company_name')
											<span class="invalid-feedback" role="alert">
											<strong>{{ $message }}</strong>
											</span>
											@enderror
										</div>


										
										<div class="mt-3 d-grid">
											<button class="btn btn-primary waves-effect waves-light"
												type="submit">{{ __('Register') }}</button>
										</div>
									</form>
									<div class="mt-3 d-grid">
										<a href="{{ route('login') }}" class="btn btn-primary outline-btn waves-effect waves-light">{{ __('Login') }}</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>
		<!-- end account-pages -->
		<!-- JAVASCRIPT -->
		<script src="{{ asset('skote/layouts/assets/libs/jquery/jquery.min.js') }}"></script>
		<script src="{{ asset('skote/layouts/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('skote/layouts/assets/libs/metismenu/metisMenu.min.js') }}"></script>
		<script src="{{ asset('skote/layouts/assets/libs/simplebar/simplebar.min.js') }}"></script>
		<script src="{{ asset('skote/layouts/assets/libs/node-waves/waves.min.js') }}"></script>
		<!-- App js -->
		<script src="{{ asset('skote/layouts/assets/js/app.js') }}"></script>
	</body>
</html>