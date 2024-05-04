<!-- Begin page -->
<div id="layout-wrapper">
<header id="page-topbar">
	<div class="navbar-header">
		<div class="d-flex">
			<!-- LOGO -->
			<div class="navbar-brand-box">
				<a href="{{url('reseller/home')}}" class="logo logo-dark">
				<span class="logo-sm">
				<img src="{{asset('skote/layouts/assets/images/logo-light.png')}}" alt="" height="50">
				</span>
				<span class="logo-lg">
				<img src="{{asset('skote/layouts/assets/images/logo-light.png')}}" alt="" height="50">
				</span>
				</a>
				<a href="{{url('reseller/home')}}" class="logo logo-light">
				<span class="logo-sm">
				<img src="{{asset('skote/layouts/assets/images/logo-light.png')}}" alt="" height="50">
				</span>
				<span class="logo-lg">
				<img src="{{asset('skote/layouts/assets/images/logo-light.png')}}" alt="" height="50">
				</span>
				</a>
			</div>
			<button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
			<i class="fa fa-fw fa-bars"></i>
			</button>
			<!-- App Search-->
		</div>
		<div class="d-flex">
			<div class="dropdown d-inline-block d-lg-none ms-2">
			    
				<button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
					data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<i class="mdi mdi-magnify"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
					aria-labelledby="page-header-search-dropdown">
					<form class="p-3">
						<div class="form-group m-0">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
								<div class="input-group-append">
									<button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="dropdown d-none d-lg-inline-block ms-1">
			      @php
                $resellerWallet = Auth()->user()->reseller_wallet;
            @endphp
			      <button type="button" class="btn btn-success waves-effect waves-light"><i class="bx bx-check-square v-center"></i> Normal Credit: {{number_format($resellerWallet)}}</button>
				<button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
					</button>
			</div>

			<div class="dropdown d-none d-lg-inline-block ms-1">
			      @php
                $userWallet = Auth()->user()->wallet;
            @endphp
			      <button type="button" class="btn btn-success waves-effect waves-light"><i class="bx bx-check-square v-center"></i> Plan Credit: {{number_format($userWallet)}}</button>
				<button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
				<i class="bx bx-fullscreen text-white"></i>
				</button>
			</div>
			<div class="dropdown d-inline-block">
				<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
					data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<img class="rounded-circle header-profile-user" src="{{asset('skote/layouts/assets/images/users/avatar-1.jpg')}}"
					alt="Header Avatar">
				<span class="d-none d-xl-inline-block text-white" key="t-henry">Reseller</span>
				<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end">
					<!-- item-->
					<a class="dropdown-item text-danger" href="#">{{ Auth::user()->reference_id }}</a>
					<a class="dropdown-item" href="{{ url('reseller/resellerprofile') }}"> <i class="bx bx-user"></i> Profile</a>
					<a class="dropdown-item" href="{{ url('reseller/resellerpassword') }}"> <i class="bx bx-lock"></i> Password</a>
					<!--<div class="dropdown-divider"></div>-->
					<a class="dropdown-item text-danger" href="{{ route('logout') }}"
						onclick="event.preventDefault();
						document.getElementById('logout-form').submit();">
					<i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span>
					</a>
					<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
						@csrf
					</form>
				</div>
			</div>
		</div>
	</div>
</header>
<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
	<div data-simplebar class="h-100">
		<!--- Sidemenu -->
		<div id="sidebar-menu">
			<!-- Left Menu Start -->
			<ul class="metismenu list-unstyled" id="side-menu">
				<li class="menu-title" key="t-menu">Menu</li>
				<li>
					<a href="{{ url('reseller/home') }}" class="waves-effect">
					<i class="  bx bx-home-circle"></i>
					<span key="t-chat">Dashboard</span>
					</a>
				</li>
				<li>
					<a href="{{ url('reseller/reselleruser') }}" class="waves-effect">
					<i class="bx bxs-user-rectangle"></i>
					<span key="t-chat">User Management</span>
					</a>
				</li>
				<li>
					<a href="{{ url('reseller/resellersound') }}" class="waves-effect">
					<i class="bx bx-video-recording"></i>
					<span key="t-chat">Sound Management</span>
					</a>
				</li>
				<li>
					<a href="{{ url('reseller/resellercampaign') }}" class="waves-effect">
					<i class="bx bxs-volume-full"></i>
					<span key="t-chat">Campaign Management</span>
					</a>
				</li>
				@php
				$reseller = App\Models\User::where('status',1)->where('parent_id',Auth::user()->id)->whereHas('roles', function($q){
					$q->where('name','reseller');
				})->get();
				@endphp
				@if(count($reseller) != '0' )
				<li>
					<a href="{{ url('reseller/resellerplan') }}" class="waves-effect">
					<i class="bx bxs-volume-full"></i>
					<span key="t-chat">Plan Management</span>
					</a>
				</li>
				@endif
				<li>
					<a href="{{ route('resellerwallet.index') }}" class="waves-effect">
						<i class="fa fa-wallet"></i>
						<span key="t-chat">Wallet Management</span>
					</a>
				</li>
				<li>
					<a href="{{ route('resllerreport.index') }}" class="waves-effect">
						<i class='bx bxs-report'></i>
						<span key="t-chat">Report Management</span>
					</a>
				</li>
			</ul>
		</div>
		<!-- Sidebar -->
	</div>
</div>
<!-- Left Sidebar End -->