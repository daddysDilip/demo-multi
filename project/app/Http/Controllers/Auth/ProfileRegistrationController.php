<?php

namespace App\Http\Controllers\Auth;


use App\Category;
use App\Http\Controllers\Controller;
use App\Profile;
use App\UserProfile;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileRegistrationController extends Controller
{

    protected $redirectTo = '/account';


    public function __construct()
    {
        $this->middleware('guest:profile');
    }


    public function showRegistrationForm()
    {
        $themename = get_theme_name();
        return view($themename.'registeruser');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
       // $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect('user/dashboard');
    }

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('profile');
    }

    protected function registered(Request $request, $user)
    {
        //
    }

    public function exist_email(Request $request)
    {
        $title_exists = (count(\App\UserProfile::where('email', '=', $request->input('email'))->get()) > 0) ? false : true;
        return response()->json($title_exists);  
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
		$companyid = get_company_id();
        return UserProfile::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
			'company_id' => $companyid
        ]);
    }
}
