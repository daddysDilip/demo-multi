<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Mail;

class EmailcomposeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.emailcompose');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discountadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $from = 'tarangtesting@gmail.com';
        $from_name = 'Estorewhiz';
        $to = $request['to']; 
        if(isset($request['cc']))
        {
            $cc = $request['cc'];
        }
        else
        {
            $cc = '';
        }
        
        if(isset($request['bcc']))
        {
            $bcc = $request['bcc'];
        }
        else
        {
            $bcc = '';
        }
        
        $subject = $request['subject'];
        $message = $request['message'];

        $headers  = "From: tarangtesting@gmail.com\r\nX-Mailer: php\r\n";
        $headers .= "MIME-Version: 1.0\r\n"; #Define MIME Version
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n"; #Set content type
        $headers .= "CC: $cc\r\n"; #Your CC Mail List
        $headers .= "Bcc: $bcc\r\n"; #Your BCC Mail List
        
        if(mail($to,$subject,$message,$headers))
        {
            return redirect('admin/emailcompose')->with('success','Mail Sent Successfully.');
        }
        else
        {
            return redirect('admin/emailcompose')->with('error','Mail Not Sent.');
        }  

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
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
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain,$id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        //
    }
}
