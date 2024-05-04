<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\LoginLog;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

protected function credentials(\Illuminate\Http\Request $request)
    {
        //return $request->only($this->username(), 'password');
        return [$this->username() => $request->{$this->username()}, 'password' => $request->password, 'status' => '1'];
    }

    protected function authenticated(Request $request, $user)
    {
        if($user->hasRole('superadmin'))
        {
            $this->loginlog($user->id);
            return redirect("superadmin/home");
        }
        else if($user->hasRole("admin"))
        {
            $this->loginlog($user->id);
            return redirect("admin/home");
        }
        else if($user->hasRole("superdistributor"))
        {
            $this->loginlog($user->id);
            return redirect("superdistributor/home");
        }
        else if($user->hasRole("distributor"))
        {
            $this->loginlog($user->id);
            return redirect("distributor/home");
        }
        else if($user->hasRole("retailer"))
        {
            $this->loginlog($user->id);
            return redirect("retailer/home");
        }
        else if($user->hasRole("user"))
        {
            $this->loginlog($user->id);
            return redirect("user/home");
        }
        else if($user->hasRole("reseller"))
        {
            $this->loginlog($user->id);
            return redirect("reseller/home");
        }
        else if($user->hasRole("businessmanager"))
        {
            $this->loginlog($user->id);
            return redirect("businessmanager/home");
        }
        else if($user->hasRole("agentuser"))
        {
            $this->loginlog($user->id);
            return redirect("agentuser/home");
        } 
        else if($user->hasRole("agentmanager"))
        {
            $this->loginlog($user->id);
            return redirect("agentmanager/home");
        }
    }

    public function loginlog($id){

        $loginLog = new LoginLog;
        $loginLog->user_id = $id;
        $loginLog->login_date = date("Y-m-d");
        $loginLog->login_time = date("H:i:s");
        $loginLog->login_mode = "Web_application";
        $loginLog->login_type = "2";
        $loginLog->created_at = date("Y-m-d H:i:s");
        $loginLog->updated_at = date("Y-m-d H:i:s");
        $loginLog->save();
}

}
