<!doctype html>
<html lang="en">
<head>
        <meta charset="utf-8" />
        <title>User</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose User & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('skote/layouts/assets/images/logo.png')}}">

        <!-- Bootstrap Css -->
        <link href="{{asset('skote/layouts/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('skote/layouts/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('skote/layouts/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
@stack('headerscript')

    </head>

    <body data-sidebar="dark">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

@include('user.layout.header')

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

            @section('content')@show

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> 
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                <span class="pull-right">Designed and Developed with <span style="color:red">♥</span> by   <em><u> FLIPKART </u></em></span> 
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="{{asset('skote/layouts/assets/images/layouts/layout-1.jpg')}}" class="img-thumbnail" alt="layout images">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="{{asset('skote/layouts/assets/images/layouts/layout-2.jpg')}}" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="{{asset('skote/layouts/assets/images/layouts/layout-3.jpg')}}" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="{{asset('skote/layouts/assets/images/layouts/layout-4.jpg')}}" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                        <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                    </div>

            
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{asset('skote/layouts/assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('skote/layouts/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('skote/layouts/assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{asset('skote/layouts/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{asset('skote/layouts/assets/libs/node-waves/waves.min.js')}}"></script>

       

        <!-- App js -->
        <script src="{{asset('skote/layouts/assets/js/app.js')}}"></script>
        @stack('footerscript')

        @php





        $planId             =   App\Models\User::where('id', Auth::user()->id)->value('user_plan');
        if($planId != 0){

            
        }

        $pattern = '/Voice File Status is (\w+)/';
        $username = 'amitgoyal';
        $password = '123123';
        $text = 'Voice File Status is';
        $voiceStatus = 0;
        try {
            $sounddata = App\Models\Sound::orderBy('id','desc')->where('provider','Videocon')->where('status','0')->where('user_id',Auth::user()->id)->get();
            foreach($sounddata as $r){
                $voiceid = $r->voice_id;
            $response = Http::post("http://103.132.146.183/VoxUpload/api/Values/CheckStatus?username=$username&password=$password&voiceid=$voiceid");
            if ($response->successful()) {
                if (preg_match($pattern, $response->body(), $matches)) {
                    $status = $matches[1];
                    $sound = App\Models\Sound::find($r->id);
                    if ($sound) {
                        if ($status == 'APPROVED') {
                            $sound->status = 1;
                        } elseif ($status == 'REJECTED') {
                            $sound->status = 2;
                        }
                        $sound->save();
                    }
                }
            }
        }
        } catch (RequestException $e) {
            //
        }
    @endphp
    </body>


</html>