<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use URL;
use Session;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
 
    public function adminlogin(Request $request)
    {  
        $companyid = get_company_id();
        if (Auth::attempt(['email' => $request->email,'password' => $request->password,'company_id' => $companyid,'status' => 1], false)){
            return redirect()->intended('admin/dashboard');
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

    public function logout(Request $request)
    { 
        Auth::logout();
        Session::flush();
        return redirect('admin/login'); 
    }

}
