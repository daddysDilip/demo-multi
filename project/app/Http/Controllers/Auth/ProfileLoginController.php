<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Response;
use URL;

class ProfileLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:profile');
    }

    public function showLoginFrom(){
        $themename = get_theme_name();
        return view($themename.'userlogin');
    }

    public function login(Request $request)
    {
        $companyid = get_company_id();
        if (Auth::guard('profile')->attempt(['email' => $request->email,'password' => $request->password,'company_id' => $companyid], false))
        {
            if($request->checkoutlogin == '1')
            {
                return redirect()->intended('checkout');
            }
            else
            {
                return redirect()->intended('user/dashboard');
            }
               
        }

        //return redirect()->back()->withInput($request->only('email'));
        return $this->sendFailedLoginResponse($request);
    }

    public function Userlogin(Request $request){

        $authSuccess = Auth::guard('profile')->attempt(['email' => $request->email,'password' => $request->password]);

        if($authSuccess) 
        {
            return response()->json([
                'auth' => $authSuccess,
                'intended' => URL::previous()
            ]);
        }
        else
        {
            echo json_encode(false); 
        }

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

    public function old_password(Request $request)
    {
        // $id = $request->input('id');
        // $user = User::findOrFail($id);
        // $cpass = $request->input('cpass');

        // if ($cpass){
        //     if (Hash::check($cpass, $user->password)){
        //         echo json_encode(true);
        //         die();
        //     }
        //     else
        //     {
        //         echo json_encode('Your Current Password is Incorrect...');
        //         die();
        //     }
        //     echo json_encode(true);
        // }

        $title_exists = (count(\App\UserProfile::where('email', '=', $request->input('email'))->get()) > 0) ? false : true;
        return response()->json($title_exists);  
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




}
