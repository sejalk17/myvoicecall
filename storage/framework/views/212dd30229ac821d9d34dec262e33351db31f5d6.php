<div id="layout-wrapper">
    <header id="page-topbar">
        <div class="navbar-header">
            <div class="d-flex">
                <div class="navbar-brand-box">
                    <a href="<?php echo e(url('user/home')); ?>" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(asset('skote/layouts/assets/images/logo-light.png')); ?>" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('skote/layouts/assets/images/logo-light.png')); ?>" alt="" style="width: 76%;height: 40px;">
                        </span>
                    </a>

                    <a href="<?php echo e(url('user/home')); ?>" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="<?php echo e(asset('skote/layouts/assets/images/logo-light.png')); ?>" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset('skote/layouts/assets/images/logo-light.png')); ?>" alt="" style="width: 76%;height: 40px;">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                    <i class="fa fa-fw fa-bars text-white"></i>
                </button>
            </div>

            <div class="d-flex">
                <div class="dropdown d-inline-block d-lg-none ms-2">
                    <button type="button" class="btn header-item noti-icon waves-effect text-white" id="page-header-search-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-magnify  text-white"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify  text-white"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php
                    $userWallet = Auth::user()->wallet;
                ?>
                <div class="dropdown d-none d-lg-inline-block ms-1">
                    <a href="<?php echo e(route('userwallet.index')); ?>" type="button" class="btn  waves-effect waves-light bg-blue text-white" ><i class="bx bx-check-square v-center text-white"></i> Credit: <?php echo e(number_format($userWallet)); ?></a>

                    <button type="button" class="btn header-item noti-icon waves-effect " data-bs-toggle="fullscreen">
                        <i class="bx bx-fullscreen text-white"></i>
                    </button>
                </div>

                <div class="dropdown d-inline-block">
                    <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php if(App\Models\UserDetail::where('user_id',auth()->user()->id)->value('logo_image') != null): ?>
                    <img class="rounded-circle header-profile-user" src="<?php echo e(asset(App\Models\UserDetail::where('user_id',auth()->user()->id)->value('logo_image'))); ?>"
                            alt="Header Avatar">
                    <?php else: ?>
                        <img class="rounded-circle header-profile-user" src="<?php echo e(asset('skote/layouts/assets/images/users/avatar-1.jpg')); ?>"
                            alt="Header Avatar">
                    <?php endif; ?>
                        <span class="d-none d-xl-inline-block ms-1 text-white" key="t-henry"><?php echo e(Auth::user()->first_name); ?></span>
                        <i class="mdi mdi-chevron-down d-none d-xl-inline-block text-white"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item text-danger" href="#"><?php echo e(Auth::user()->reference_id); ?></a>
                        <a class="dropdown-item" href="<?php echo e(url('user/userprofile')); ?>"> 
                            <i class="bx bx-user"></i>  Profile
                        </a>
                        <a class="dropdown-item" href="<?php echo e(url('user/userpassword')); ?>">
                             <i class="bx bx-lock"></i>  Password
                        </a>
                        <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"
                            onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                            <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> 
                            <span key="t-logout">Logout</span>
                        </a>

                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ========== Left Sidebar Start ========== -->
    <div class="vertical-menu">
       <div data-simplebar class="h-100">
            <div id="sidebar-menu">
                <ul class="metismenu list-unstyled" id="side-menu">
                    <li class="menu-title" key="t-menu">Menu</li>
                    <li>
                        <a href="<?php echo e(url('user/home')); ?>" class="waves-effect">
                            <i class="  bx bx-home-circle"></i>
                            <span key="t-chat">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('user/usersound')); ?>" class="waves-effect">
                            <i class="bx bx-video-recording"></i>
                            <span key="t-chat">Sound Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('user/usercampaign')); ?>" class="waves-effect">
                            <i class="bx bxs-volume-full"></i>
                            <span key="t-chat">Campaign Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(url('user/userwallet')); ?>" class="waves-effect">
                            <i class="fa fa-wallet"></i>
                            <span key="t-chat">Wallet Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('userreport.index')); ?>" class="waves-effect">
                            <i class='bx bxs-report'></i>
                            <span key="t-chat">Report Management</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo e(route('userreport.checkxlsx')); ?>" class="waves-effect">
                            <i class='bx bxs-report'></i>
                            <span key="t-chat">Test check for Excel</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo e(url('user/usercampaignclone')); ?>" class="waves-effect">
                            <i class='bx bxs-report'></i>
                            <span key="t-chat">Campaing Clone Mgmt</span>
                        </a>
                    </li>

                    <li>
                        <a href="<?php echo e(url('user/usercampaignreplica')); ?>" class="waves-effect">
                            <i class='bx bxs-report'></i>
                            <span key="t-chat">Campaing Replica Mgmt</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/user/layout/header.blade.php ENDPATH**/ ?>