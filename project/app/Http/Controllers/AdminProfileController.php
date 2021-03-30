<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
        //$this->userid = Auth::user()->id;
    }

    public function index()
    {
        $companyid = get_company_id();
        $admin = User::where('company_id',$companyid)->first();
        return view('admin.adminprofile' , compact('admin'));
    }

    public function password()
    {
        $companyid = get_company_id();
        $admin = User::where('company_id',$companyid)->first();
        return view('admin.adminchangepass' , compact('admin'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($subdomain,$id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain,$id)
    {
        $companyid = get_company_id();
        $userid = get_user_id();

        $user = User::where('id',$userid)->where('company_id',$companyid)->first();

        $input = $request->all();

        if ($file = $request->file('photo')){
            $photo = time().$request->file('photo')->getClientOriginalName();
            $file->move('assets/images/admin',$photo);
            $input['photo'] = $photo;

            if($user->photo != '')
            {
                unlink('assets/images/admin/'.$user->photo);
            }
        }

        if ($request->cpass){
            if (Hash::check($request->cpass, $user->password)){

                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    Session::flash('error', 'Confirm Password Does Not match.');
                    return redirect('admin/adminprofile');
                }
            }else{
                Session::flash('error', 'Admin Profile Updated Successfully.');
                return redirect('admin/adminprofile');
            }
        }
        //return $request->cpass;
        //return "Not..";
        $user->update($input);
        Session::flash('message', 'Admin Profile Updated Successfully.');
        return redirect('admin/adminprofile');
    }

    public function old_password(Request $request)
    {
        $companyid = get_company_id();
        $id = $request->input('id');
        $userid = get_user_id();

        $user = User::where('id',$userid)->where('company_id',$companyid)->first();

        $cpass = $request->input('cpass');

        if ($cpass){
            if (Hash::check($cpass, $user->password)){
                echo json_encode(true);
            }
            else
            {
                echo json_encode(false);
            }
        }
    }

    public function changepass(Request $request, $subdomain,$id)
    {
        $companyid = get_company_id();
        $userid = get_user_id();
        $user = User::where('id',$userid)->where('company_id',$companyid)->first();

        $input['password'] = "";
        if ($request->cpass){
            if (Hash::check($request->cpass, $user->password)){

                if ($request->newpass == $request->renewpass){
                    $input['password'] = Hash::make($request->newpass);
                }else{
                    Session::flash('error', 'Confirm Password Does not match.');
                    return redirect('admin/adminpassword');
                }
            }else{
                Session::flash('error', 'Current Password Does not match');
                return redirect('admin/adminpassword');
            }
        }

        $user->update($input);
        Session::flash('message', 'Admin Password Updated Successfully.');
        return redirect('admin/adminpassword');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        //
    }
}
