        <!-- Begin page -->
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="<?php echo e(url('admin/home')); ?>" class="logo logo-dark">
                                <span class="logo-sm">
                                      <h2 class="logo">FlipKart</h2>
                                </span>
                                <span class="logo-lg">
                                    <h2 class="logo">FlipKart</h2>
                                    <!--   <h2 class="logo">FlipKart</h2> -->
                                </span>
                            </a>

                            <a href="<?php echo e(url('admin/home')); ?>" class="logo logo-light">
                                <span class="logo-sm">
                                      <h2 class="logo">FlipKart</h2>
                                </span>
                                <span class="logo-lg">
                                      <h2 class="logo">FlipKart</h2>
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect "
                            id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars text-white"></i>
                        </button>

                        <!-- App Search-->
                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item noti-icon waves-effect"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="mdi mdi-magnify text-white"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">

                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..."
                                                aria-label="Recipient's username">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i
                                                        class="mdi mdi-magnify  text-white"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect"
                                data-bs-toggle="fullscreen">
                                <i class="bx bx-fullscreen text-white"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon waves-effect"
                                id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="bx bx-bell bx-tada text-white"></i>
                                <span class="badge bg-danger rounded-pill">3</span>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-notifications-dropdown">
                                <div class="p-3">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="m-0" key="t-notifications"> Notifications </h6>
                                        </div>
                                        <div class="col-auto">
                                            <a href="#!" class="small" key="t-view-all"> View All</a>
                                        </div>
                                    </div>
                                </div>
                                <div data-simplebar style="max-height: 230px;">
                                    <a href="javascript: void(0);" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                    <i class="bx bx-cart"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1" key="t-your-order">Your order is placed</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-grammer">If several languages coalesce the
                                                        grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                            key="t-min-ago">3 min ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript: void(0);" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <img src="<?php echo e(asset('skote/layouts/assets/images/users/avatar-3.jpg')); ?>"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">James Lemire</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-simplified">It will seem like simplified
                                                        English.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                            key="t-hours-ago">1 hours ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript: void(0);" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <div class="avatar-xs me-3">
                                                <span class="avatar-title bg-success rounded-circle font-size-16">
                                                    <i class="bx bx-badge-check"></i>
                                                </span>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1" key="t-shipped">Your item is shipped</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-grammer">If several languages coalesce
                                                        the grammar</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                            key="t-min-ago">3 min ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>

                                    <a href="javascript: void(0);" class="text-reset notification-item">
                                        <div class="d-flex">
                                            <img src="<?php echo e(asset('skote/layouts/assets/images/users/avatar-4.jpg')); ?>"
                                                class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">Salena Layfield</h6>
                                                <div class="font-size-12 text-muted">
                                                    <p class="mb-1" key="t-occidental">As a skeptical Cambridge
                                                        friend of mine occidental.</p>
                                                    <p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span
                                                            key="t-hours-ago">1 hours ago</span></p>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="p-2 border-top d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                        <i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">View
                                            More..</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect"
                                id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <img class="rounded-circle header-profile-user"
                                    src="<?php echo e(asset('skote/layouts/assets/images/users/avatar-1.jpg')); ?>"
                                    alt="Header Avatar">

                                <span class="d-none d-xl-inline-block ms-1 text-white" key="t-henry">Admin</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block text-white"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item text-danger"
                                    href="#"><?php echo e(Auth::user()->reference_id); ?></a>
                                <a class="dropdown-item" href="<?php echo e(url('admin/adminprofile')); ?>"><i
                                        class="bx bx-user"></i>Profile</a>
                                <a class="dropdown-item" href="<?php echo e(url('admin/adminpassword')); ?>"> <i
                                        class="bx bx-lock"></i> Password</a>
                                <!--<div class="dropdown-divider"></div>-->
                                <a class="dropdown-item text-danger" href="<?php echo e(route('logout')); ?>"
                                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                                    <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span
                                        key="t-logout">Logout</span>
                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                    class="d-none">
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
                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Menu</li>
                            <li>
                                <a href="<?php echo e(url('admin/home')); ?>" class="waves-effect">
                                    <i class="  bx bx-home-circle"></i>
                                    <span key="t-chat">Dashboard</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(url('admin/user')); ?>" class="waves-effect">
                                    <i class="bx bxs-user-rectangle"></i>
                                    <span key="t-chat">User Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(url('admin/sound')); ?>" class="waves-effect">
                                    <i class="bx bx-video-recording"></i>
                                    <span key="t-chat">Sound Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(url('admin/campaign')); ?>" class="waves-effect">
                                    <i class="bx bxs-volume-full"></i>
                                    <span key="t-chat">Campaign Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('provider.index')); ?>" class="waves-effect">
                                    <i class="bx bxs-phone-outgoing"></i>
                                    <span key="t-chat">Provider Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(url('admin/plan')); ?>" class="waves-effect">
                                    <i class="bx bxs-volume-full"></i>
                                    <span key="t-chat">Plan Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('channel.index')); ?>" class="waves-effect">
                                    <i class="bx bxs-key"></i>
                                    <span key="t-chat">Channel Management</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo e(route('admincamptype.uploadFile')); ?>" class="waves-effect">
                                    <i class="bx bxs-key"></i>
                                    <span key="t-chat">Upload Report Form panel</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo e(route('admincamptype.uploadFile')); ?>" class="waves-effect">
                                    <i class="bx bxs-key"></i>
                                    <span key="t-chat">Upload Report Form panel</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo e(route('blocknumber.index')); ?>" class="waves-effect">
                                    <i class="fa fa-wallet"></i>
                                    <span key="t-chat">Block Number Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('adminreport.index')); ?>" class="waves-effect">
                                    <i class='bx bxs-report'></i>
                                    <span key="t-chat">Report Management</span>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo e(route('admincamptype.index')); ?>" class="waves-effect">
                                    <i class='bx bxs-widget'></i>
                                    <span key="t-chat">Camp Type Management</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?php echo e(route('adminspeeddata.index')); ?>" class="waves-effect">
                                    <i class='bx bxs-widget'></i>
                                    <span key="t-chat">Speed Data</span>
                                </a>
                            </li>
                         
                            <!-- <li>
                                <a href="<?php echo e(route('websetting.index')); ?>" class="waves-effect">
                                    <i class='bx bxs-cog'></i>
                                    <span key="t-chat">Web Setting Management</span>
                                </a>
                            </li> -->
                         
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->
<?php /**PATH F:\xampp\htdocs\myvoicecall\resources\views/admin/layout/header.blade.php ENDPATH**/ ?>