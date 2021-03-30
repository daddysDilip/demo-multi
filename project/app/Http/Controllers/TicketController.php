<?php

namespace App\Http\Controllers;

use App\Ticketfiles;
use App\TicketPriority;
use App\Ticket;
use App\TicketStatus;
use App\TicketReply;
use App\User;
use App\Company;
use DB;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;

class TicketController extends Controller
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
        $companyid =get_company_id();
        $ticket = Ticket::where('company_id',$companyid)->get();
        return view('admin.ticketlist',compact('ticket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tpriority = TicketPriority::all();
        $tstatus = TicketStatus::all();
        return view('admin.ticketadd',compact('tpriority','tstatus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $companyid =get_company_id();
        $user = User::where('company_id',$companyid)->get();

        $ticket = new Ticket();
        $ticket->fill($request->all());

        $ticketfile = new Ticketfiles();
        $ticketfile->fill($request->all());

        if ($file = $request->file('image'))
        {
            $photo_name = $request->file('image')->getClientOriginalName(); 
            $ticketfile['extension'] = $request->file('image')->getClientOriginalExtension(); 
            $ticketfile['filesize'] = $request->file('image')->getSize();
            $ticketfile['filetype'] = $request->file('image')->getMimeType(); 
            $file->move('assets/images/ticket',$photo_name);
            $ticketfile['filename'] = $photo_name;
        }
        
        $ticket['company_id'] = $companyid;
        $ticket['tempcode'] = str_random(6);

        if(isset($ticket['status']))
        {
            $ticket['status'] = 1;
        }
        else
        {
            $ticket['status'] = 0;
        }

        $ticket['created_by'] = get_user_id();

        $ticket->save();
        $lastid = $ticket->id;

        $ticketfile['ticketid'] = $lastid;
        $ticketfile['userid'] = get_user_id();

        if($lastid)
        {
            $ticketfile->save();
        }

        return redirect('admin/tickets')->with('message','New Ticket Added Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function show($subdomain,$id)
    {
        $ticket = Ticket::findOrFail($id);
        //$ticketfiles = Ticketfiles::where('ticketid',$id)->get();
        $treply = TicketReply::where('ticketid',$id)->get();
        $company = Company::where('id',$ticket->company_id)->get();
        return view('admin.ticketdetails',compact('ticket','treply','company'));
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

    public function addreply(Request $request)
    {
        $companyid = get_company_id();
        $user = User::where('company_id',$companyid)->get();

        $ticket = new TicketReply();
        $ticket->fill($request->all());

        $ticket['userid'] = get_user_id();  
        $ticket['timestamp'] = date('Y-m-d H:i:s');
        $ticket['files'] = 0;

        $ticket->save();
        $lastid = $ticket->id;

        if(!empty($lastid))
        {
            if ($files = $request->file('files')){
                foreach ($files as $file){

                    $ticketfile = new Ticketfiles;
                    $ticketfile->fill($request->all());

                    $photo_name = $file->getClientOriginalName(); 
                    $ticketfile['extension'] = $file->getClientOriginalExtension(); 
                    $ticketfile['filesize'] = $file->getSize();
                    $ticketfile['filetype'] = $file->getMimeType(); 
                    $file->move('assets/images/ticket',$photo_name);
                    $ticketfile['filename'] = $photo_name;
                    $ticketfile['timestamp'] = date('Y-m-d H:i:s');
                    $ticketfile['userid'] = get_user_id(); 

                    $ticketfile['replyid'] = $lastid;
                    $ticketfile->save();
                }
            }

            $total = Ticketfiles::where('replyid',$lastid)->get();
            if(count($total) != '')
            {
                $reply = TicketReply::findOrFail($lastid);
                $input = $request['Files'];
                $input['files'] = 1;
                $reply->update($input);
            }

        }

        return back();
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
