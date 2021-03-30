<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use URL;
use Session;
     
class SadminLoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
 
    public function sadminlogin(Request $request)
    {
        //echo $session_id = Session::getId(); die();
        $companyid = get_company_id();
        $remember_me = $request->has('remember_me') ? true : false;
        if (Auth::attempt(['email' => $request->email,'password' => $request->password,'company_id' => $companyid,'status' => 1],  $remember_me)){
            // $user = auth()->user();
            // dd($user);
            return redirect()->intended('sadmin/dashboard');
        }

        return $this->sendFailedLoginResponse($request);
    }

   
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required', 'password' => 'required',
        ]);
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username()))
            ->withErrors($errors);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    public function SadminLoginForm()
    {
        if(Auth::check())
        {
           return redirect('sadmin/dashboard');
        }
        else
        {
            return view('sadmin.login');
        }
    }

    public function logout(Request $request)
    { 
        Auth::logout();
        Session::flush();
        return redirect('sadmin/login'); 
    }


}
