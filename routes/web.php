<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/cc', function () {
    Artisan::call('cache:clear');
    echo '<script>
        alert("cache clear Success")
    </script>';
});
Route::get('/ccc', function () {
    Artisan::call('config:cache');
    echo '<script>
        alert("config cache Success")
    </script>';
});
Route::get('/vc', function () {
    Artisan::call('view:clear');
    echo '<script>
        alert("view clear Success")
    </script>';
});
Route::get('/cr', function () {
    Artisan::call('route:cache');
    echo '<script>
        alert("route clear Success")
    </script>';
});
Route::get('/coc', function () {
    Artisan::call('config:clear');
    echo '<script>
        alert("config clear Success")
    </script>';
});
Route::get('/storage123', function () {
    Artisan::call('storage:link');
    echo '<script>
        alert("linked")
    </script>';
});

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();
Route::get('register', 'App\Http\Controllers\Auth\RegisterController@showRegistrationForm')->name('register');

//Route::get('/','App\Http\Controllers\HomeController@index');

Route::any('/', function () {
    return view('auth.login');
});

Route::Post('contact_store', 'App\Http\Controllers\HomeController@contact_store');
Route::get('registeruser', 'App\Http\Controllers\HomeController@registeruser');

Route::get('undermaintainance', 'App\Http\Controllers\HomeController@undermaintainance');
Route::post('storeregister', 'App\Http\Controllers\HomeController@storeregister');
Route::get('databasecopy', 'App\Http\Controllers\admin\CampaignController@databasecopy');
Route::get('refundCreditByFunction', 'App\Http\Controllers\admin\CampaignController@refundCreditByFunction');
Route::get('startScheduleCampaign', 'App\Http\Controllers\admin\CampaignController@startScheduleCampaign');
Route::get('startDailyScheduleCampaign', 'App\Http\Controllers\admin\CampaignController@startDailyScheduleCampaign');
Route::get('changeStatusForCampaign', 'App\Http\Controllers\admin\CampaignController@changeStatusForCampaign');
Route::get('checkMobileNumberLast5status', 'App\Http\Controllers\admin\CampaignController@checkMobileNumberLast5status');
Route::get('updateVipNumbers', 'App\Http\Controllers\admin\CampaignController@updateVipNumbers');
Route::get('speedDataForCampaign', 'App\Http\Controllers\admin\CampaignController@speedDataForCampaign');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['role:superadmin', 'auth'], 'namespace' => 'App\Http\Controllers\superadmin', 'prefix' => 'superadmin'], function () {
    Route::get('home', 'HomeController@index');
    Route::get('walletview', 'HomeController@walletview');
    Route::get('approve/{x}', 'HomeController@approve');
    Route::POST('requestUpdate', 'HomeController@requestUpdate');
    Route::Resource('sa_time_limit', 'TimelimitController');
    Route::Resource('sa_amount_limit', 'AmountLimitController');
    Route::Resource('sa_limit', 'LimitController');
    Route::get('superadminprofile', 'HomeController@superadminprofile');
    Route::Post('superadminupdateprofile', 'HomeController@superadminupdateprofile');
    Route::get('superadminpassword', 'HomeController@superadminpassword');
    Route::Post('superadminupdatepassword', 'HomeController@superadminupdatepassword');
});

Route::group(['middleware' => ['role:admin', 'auth'], 'namespace' => 'App\Http\Controllers\admin', 'prefix' => 'admin'], function () {
    Route::get('home', 'HomeController@index');
    
    Route::get('channel/addctsnumberuser', 'ChannelController@addctsnumberuser')->name('channel.addctsnumberuser');
    Route::post('channel/addctsnumbersave', 'ChannelController@addctsnumbersave')->name('channel.addctsnumbersave');
    Route::get('adminspeeddata/createdirect', 'SpeedDataController@createdirect')->name('adminspeeddata.createdirect');
    Route::post('adminspeeddata/storedirect', 'SpeedDataController@storedirect')->name('adminspeeddata.storedirect');
     /* ------------------------------ Resource Route --------------------------------------- */
    Route::Resource('provider', 'ProviderController');
    Route::Resource('ukey', 'UkeyController');
    Route::Resource('user', 'UserController');
    Route::Resource('sound', 'SoundController');
    Route::Resource('campaign', 'CampaignController');
    Route::Resource('adminwallet', 'WalletController');
    Route::Resource('adminreport', 'ReportController');
    Route::Resource('admincamptype', 'CampTypeController');
    Route::Resource('adminspeeddata', 'SpeedDataController');
    Route::Resource('websetting', 'SettingController');
    Route::Resource('channel', 'ChannelController');
    Route::Resource('plan', 'PlanController');
    Route::Resource('blocknumber', 'BlockNumberController');
    Route::Resource('permission', 'PermissionController');
     /* ------------------------------ Post Route --------------------------------------- */
    Route::post('requestUpdate', 'HomeController@requestUpdate');
    Route::post('uploadprocessedSubmit', 'HomeController@uploadprocessedSubmit');
    Route::post('adminupdateprofile', 'HomeController@adminupdateprofile');
    Route::post('adminupdatepassword', 'HomeController@adminupdatepassword');
    Route::post('allreject', 'HomeController@allreject');
    Route::post('Downloadtablereport', 'HomeController@Downloadtablereport');
    Route::Post('Downloadcompletetablereport', 'HomeController@Downloadcompletetablereport');
    Route::post('Downloadwallettablereport', 'HomeController@Downloadwallettablereport');
    Route::post('user-update-wallet', 'UserController@updateWallet')->name('user.updateWallet');
     /* ------------------------------ Get Route --------------------------------------- */
    Route::get('registerview', 'HomeController@registerview');
    Route::get('contact', 'HomeController@contactShow');
    Route::get('filterDateBase', 'HomeController@filterDateBase')->name('admin.filterDateBase');
    Route::get('billview', 'HomeController@billview');
    Route::get('getbilldata', 'HomeController@getbilldata');
    Route::get('walletview', 'HomeController@walletview');
    Route::get('approve/{x}', 'HomeController@approve');
    Route::get('registerapprove/{uid}', 'HomeController@registerapprove');
    Route::get('registerreject/{uid}', 'HomeController@registerreject');
    Route::get('uploadprocessed', 'HomeController@uploadprocessed');
    Route::get('adminprofile', 'HomeController@adminprofile');
    Route::get('adminpassword', 'HomeController@adminpassword');
    Route::get('sound/approveStatus/{id?}', 'SoundController@approveStatus');
    Route::get('campaign/downloadFile/{id?}', 'CampaignController@downloadFile');
    Route::get('campaign/campaignStartStop/{status?}/{id?}', 'CampaignController@campaignStartStop');
    Route::get('campaign/refundCredit/{id?}', 'CampaignController@refundCredit');
    
    Route::get('campaign/retryCampaign/{type?}/{id?}', 'CampaignController@retryCampaign');
    Route::get('campaign/resend/{id?}', 'CampaignController@resendCampaign');
    Route::get('getbillreportdata', 'HomeController@getbillreportdata');
    Route::get('report', 'HomeController@reportdata');
    Route::get('reports', 'HomeController@reports');
    Route::get('walletreport', 'HomeController@walletreport');
    Route::get('getwalletreportdata', 'HomeController@getwalletreportdata');
    Route::get('user-getCli', 'UserController@getcli')->name('user.getCli');
    Route::get('user-getServiceNo', 'UserController@getServiceNo')->name('user.getServiceNo');
    Route::get('user-getUkey', 'UserController@getUkey')->name('user.getUkey');
    Route::get('camp-type-statusUpdate', 'CampTypeController@statusUpdate')->name('admincamptype.statusUpdate');
    Route::get('camp-type-uploadfile', 'CampTypeController@uploadFile')->name('admincamptype.uploadFile');
    Route::post('camp-type-uploadfilestore', 'CampTypeController@uploadFileStore')->name('admincamptype.uploadFileStore');
    Route::get('ukey-statusUpdate', 'UkeyController@statusUpdate')->name('adminukey.statusUpdate');
    Route::get('channel-statusUpdate', 'channelController@statusUpdate')->name('channel.statusUpdate');
    Route::get('databasecopy', 'CampaignController@databasecopy');
});

Route::group(['middleware' => ['role:superdistributor', 'auth'], 'namespace' => 'App\Http\Controllers\superdistributor', 'prefix' => 'superdistributor'], function () {
    Route::get('home', 'HomeController@index');
    Route::get('wallet_request', 'HomeController@wallet_request');
    Route::POST('walletstore', 'HomeController@walletstore');
    Route::get('walletview', 'HomeController@walletview');
    Route::get('approve/{x}', 'HomeController@approve');
    Route::POST('requestUpdate', 'HomeController@requestUpdate');
    Route::get('superdistributorprofile', 'HomeController@superdistributorprofile');
    Route::Post('superdistributorupdateprofile', 'HomeController@superdistributorupdateprofile');
    Route::get('superdistributorpassword', 'HomeController@superdistributorpassword');
    Route::Post('superdistributorupdatepassword', 'HomeController@superdistributorupdatepassword');
    Route::GET('notificationview', 'HomeController@notificationview');

    //reports
    Route::Post('Downloadwallettablereport', 'HomeController@Downloadwallettablereport');
    Route::Post('Downloadtablereport', 'HomeController@Downloadtablereport');
    Route::get('getbillreportdata', 'HomeController@getbillreportdata');
    Route::get('report', 'HomeController@reportdata');
    Route::get('reports', 'HomeController@reports');
    Route::get('walletreport', 'HomeController@walletreport');
    Route::get('getwalletreportdata', 'HomeController@getwalletreportdata');
});



Route::group(['middleware' => ['role:reseller', 'auth'], 'namespace' => 'App\Http\Controllers\reseller', 'prefix' => 'reseller'], function () {
    Route::get('home', 'HomeController@index');
     /* ------------------------------ Resource Route --------------------------------------- */
    Route::Resource('resellerwallet', 'WalletController');
    Route::Resource('reselleruser', 'UserController');
    Route::Resource('resellersound', 'SoundController');
    Route::Resource('resellercampaign', 'CampaignController');
    Route::Resource('resllerreport', 'ReportController');
    Route::Resource('resellerplan', 'PlanController');
     /* ------------------------------ Post Route --------------------------------------- */
    Route::post('resellerupdateprofile', 'HomeController@resellerupdateprofile');
    Route::post('resellerupdatepassword', 'HomeController@resellerupdatepassword');
    Route::post('user-update-wallet', 'UserController@updateWallet')->name('reseller.userupdateWallet');
     /* ------------------------------ Get Route --------------------------------------- */
    Route::get('resellerprofile', 'HomeController@resellerprofile');
    Route::get('resellerpassword', 'HomeController@resellerpassword');
    Route::get('filterDateBase', 'HomeController@filterDateBase')->name('reseller.filterDateBase');
});

Route::group(['middleware' => ['role:businessmanager', 'auth'], 'namespace' => 'App\Http\Controllers\businessmanager', 'prefix' => 'businessmanager'], function () {


    Route::get('businesscampaign/createtest', 'BusinessCampaignController@createtest')->name('businesscampaign.createtest');
    Route::get('businesscampaign/downloadFile/{id?}', 'BusinessCampaignController@downloadFile');
    Route::get('home', 'HomeController@index');
    /* ------------------------------ Resource Route --------------------------------------- */
    Route::Resource('businesscampaign', 'BusinessCampaignController');
    Route::Resource('bmuser', 'UserController'); 
    //  /* ------------------------------ Post Route --------------------------------------- */
    Route::post('bmupdateprofile', 'HomeController@bmupdateprofile');
    Route::post('bsupdatepassword', 'HomeController@bsupdatepassword');
    //  /* ------------------------------ Get Route --------------------------------------- */
    Route::get('bmprofile', 'HomeController@bmprofile');
    Route::get('bspassword', 'HomeController@bspassword');
    Route::get('bmuser-statusUpdate', 'UserController@statusUpdate')->name('bmuser.statusUpdate');

});




Route::group(['middleware' => ['role:user', 'auth','checkPlanEndDate'], 'namespace' => 'App\Http\Controllers\user', 'prefix' => 'user'], function () {
    Route::get('home', 'HomeController@index');
    Route::get('usercampaign/usercampaignmonthdata', 'CampaignController@campaignMonthData')->name('usercampaign.usercampaignmonthdata');
    Route::get('usercampaign/createtts', 'CampaignController@createCampaignWithName')->name('usercampaign.createtts');
    Route::get('usercampaign/uploadreport', 'CampaignController@uploadReportsObd')->name('usercampaign.uploadreport');
    Route::post('usercampaign/uploadstore', 'CampaignController@storeReportsObd')->name('usercampaign.uploadstore');
    Route::post('usercampaign/ttsstore', 'CampaignController@storeCampaignWithName')->name('usercampaign.ttsstore');
    Route::post('usercampaign/usercampaigdatastore', 'CampaignController@campaignMonthDataStore')->name('usercampaign.usercampaigdatastore');
    Route::get('userreport/checkxlsx', 'ReportController@checkxlsx')->name('userreport.checkxlsx');
    Route::post('userreport/xlsxstore', 'ReportController@xlsxstore')->name('userreport.xlsxstore');
    /* ------------------------------ Resource Route --------------------------------------- */
    Route::Resource('usersound', 'SoundController');
    Route::Resource('usercampaign', 'CampaignController');
    Route::Resource('usercampaignclone', 'CampaignCloneController');
    Route::Resource('usercampaignreplica', 'CampaignReplicaController');
    Route::Resource('userwallet', 'WalletController');
    Route::Resource('userreport', 'ReportController');
    Route::Resource('userwhatstapp', 'WhatsappSettingsController');
    
    
    Route::get('usercampaign/downloadFile/{id?}', 'CampaignController@downloadFile');
    Route::get('usercampaign/retryCampaign/{type?}/{id?}', 'CampaignController@retryCampaign');
   
     /* ------------------------------ Post Route --------------------------------------- */
    Route::post('userupdateprofile', 'HomeController@userupdateprofile');
    Route::post('userupdatepassword', 'HomeController@userupdatepassword');
    Route::post('walletstore', 'HomeController@walletstore');
     /* ------------------------------ Get Route --------------------------------------- */
    Route::get('wallet_request', 'HomeController@wallet_request');
    Route::get('userprofile', 'HomeController@userprofile');
    Route::get('userpassword', 'HomeController@userpassword');
    Route::get('filterDateBase', 'HomeController@filterDateBase')->name('user.filterDateBase');
});


Route::group(['middleware' => ['role:agentuser', 'auth'], 'namespace' => 'App\Http\Controllers\agentuser', 'prefix' => 'agentuser'], function () {
    Route::get('home', 'HomeController@index');
    /* ------------------------------ Resource Route --------------------------------------- */
    Route::Resource('clicktocall', 'ClickToCallController');
    // Route::Resource('usercampaign', 'CampaignController');
    // Route::Resource('userwallet', 'WalletController');
    // Route::Resource('userreport', 'ReportController');
    // Route::get('usercampaign/downloadFile/{id?}', 'CampaignController@downloadFile');
     /* ------------------------------ Post Route --------------------------------------- */
    Route::post('agentuserupdateprofile', 'HomeController@agentuserupdateprofile');
    Route::post('agentuserupdatepassword', 'HomeController@agentuserupdatepassword');
    // Route::post('walletstore', 'HomeController@walletstore');
     /* ------------------------------ Get Route --------------------------------------- */
    // Route::get('wallet_request', 'HomeController@wallet_request');
    Route::get('agentuserprofile', 'HomeController@agentuserprofile');
    Route::get('agentuserpassword', 'HomeController@agentuserpassword');
    // Route::get('filterDateBase', 'HomeController@filterDateBase')->name('user.filterDateBase');
});


Route::group(['middleware' => ['role:agentmanager', 'auth'], 'namespace' => 'App\Http\Controllers\agentmanager', 'prefix' => 'agentmanager'], function () {
    Route::get('home', 'HomeController@index');
    Route::get('campaigndata', 'HomeController@campaigndata');
    Route::get('campaignagentdata/{id}', 'HomeController@campaignagentdata');
    Route::get('clicktocall/{id}', 'HomeController@clicktocall');
   
});
