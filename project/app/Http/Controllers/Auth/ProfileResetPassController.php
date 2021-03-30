<?php

namespace App\Http\Controllers\Auth;

use App\UserProfile;
use App\User;
use App\Emailtemplates;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Mail;

class ProfileResetPassController extends Controller
{

    public function showAdminForgotForm(){
        return view('admin.forgotform');
    }

    //Reset Users Profile Password
    public function resetAdminPass(Request $request){

        $companyid = get_company_id();

        if (User::where('email', '=', $request->email)->where('company_id', $companyid)->count() > 0) {      
            $user = User::where('email', '=', $request->email)->where('company_id', $companyid)->firstOrFail();

            $username = $user->username;
            $email = $request->email;
            $autopass = str_random(8);
            $input['password'] = Hash::make($autopass);

            $user->update($input);

            $url = $request->root();
            $activatedcode = str_random(15);

            $emailtemplate =  Emailtemplates::where('Label','Admin-forgot-password')->where('company_id',$companyid)->get();

            $subject = $emailtemplate[0]->subject;
            $link = $url.'/admin/resetpassword/'.$activatedcode;
            $find =  array('{{username}}','{{link}}');
            $replace = array($username,$link);

            $headers = "MIME-Version: 1.0\r\n"; #Define MIME Version
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $message = str_replace($find,$replace,$emailtemplate[0]->content);

            $admin = User::where('email', $request->email)->where('company_id', $companyid);

            if(mail($request->email,$subject,$message,$headers))
            {
                $data['activationcode'] = $activatedcode;
                $admin->update($data);
            }
            else
            {
                Session::flash('error', 'Try Again.');
            }

            Session::flash('success', 'Check Your Mail Reset Link Sent To It.');  
            return redirect('/admin/forgotpassword');

        }else{
            // user not found
            Session::flash('error', 'No Account Found With This Email.');
            return redirect('/admin/forgotpassword');
        }
    }

    public function resetadminForm($subdomain,$activationcode)
    {
        $usr = User::where('activationcode', $activationcode)->get();
        
        if(count($usr)>0)
        {   
            $id = $usr[0]->id;
            return view('admin.resetpassword',compact('id'));
        }
        else
        {
            return redirect('admin/login');
        }   
    }
    
    public function adminnewpassword(Request $request)
    {
        $password = $request->new_password; 
        $id = $request->id; 
        $random = str_random(15);

        $user = User::where('id', $id);
      
        $data['password'] = bcrypt($password);
        $data['activationcode'] = '';
        $user->update($data);

        if($user)
        {
            return redirect('admin/login')->with('success','Your Password Successfully Changed.');
        }
        else
        {
            return redirect('/forgotview')->with('success', 'Try Again.');
        } 
    } 

    //Show Forgot Password Form
    public function showForgotForm(){
        $themename = get_theme_name();
        return view($themename.'forgotform');
    }

    //Reset Users Profile Password
    public function resetPass(Request $request){

        $subdomain = get_subdomain();

        $companyid = get_company_id();

        if (UserProfile::where('email', '=', $request->email)->where('company_id', $companyid)->count() > 0) {      
            $user = UserProfile::where('email', '=', $request->email)->where('company_id', $companyid)->firstOrFail();

            $name = $user->firstname." ".$user->lastname;
            $email = $request->email;
            $autopass = str_random(8);

            $url = $request->root();
            $activatedcode = str_random(15);

            $emailtemplate =  Emailtemplates::where('Label','Forgot-Password')->where('company_id',$companyid)->get();

            $subject = $emailtemplate[0]->subject;
            $link = $url.'/user/resetpassword/'.$activatedcode;
            $find =  array('{{name}}','{{link}}');
            $replace = array($name,$link);

            $headers = "MIME-Version: 1.0\r\n"; #Define MIME Version
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $message = str_replace($find,$replace,$emailtemplate[0]->content);

            $admin = UserProfile::where('email', $request->email)->where('company_id', $companyid);

            if(mail($request->email,$subject,$message,$headers))
            {
                $data['activationcode'] = $activatedcode;
                $admin->update($data);
            }
            else
            {
                Session::flash('error', 'Try Again.');
            }

            Session::flash('success', trans("app.CheckResetLinkMsg"));  
            return redirect('/user/forgot');

        }else{
            // user not found
            Session::flash('error', trans("app.NoAccountFoundMsg"));
            return redirect('/user/forgot');
        }
    }

    public function resetForm($subdomain,$activationcode)
    {
        $usr = UserProfile::where('activationcode', $activationcode)->get();
        $themename = get_theme_name();
        
        if(count($usr)>0)
        {   
            $id = $usr[0]->id;
            return view($themename.'resetpassword',compact('id'));
        }
        else
        {
            return redirect('/');
        }   
    }   

    public function usernewpassword(Request $request)
    {
        $password = $request->new_password; 
        $id = $request->id; 
        $random = str_random(15);

        $user = UserProfile::where('id', $id);
      
        $data['password'] = bcrypt($password);
        $data['activationcode'] = '';
        $user->update($data);

        if($user)
        {
            return redirect('/user/login')->with('success',trans("app.PasswordChangeMsg"));
        }
        else
        {
            return redirect('/user/forgot')->with('success', trans("app.TryAgain"));
        } 
    } 
}
