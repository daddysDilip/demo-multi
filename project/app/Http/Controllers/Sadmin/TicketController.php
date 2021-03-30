<?php

namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Ticketfiles;
use App\TicketPriority;
use App\Ticket;
use App\TicketStatus;
use App\TicketReply;
use App\User;
use App\Company;
use App\Settings;
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
        $ticket = Ticket::all();
        return view('sadmin.ticketlist',compact('ticket'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $news
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $ticket = Ticket::findOrFail($id);
        //$ticketfiles = Ticketfiles::where('ticketid',$id)->get();
        $treply = TicketReply::where('ticketid',$id)->get();
        $allstatus = TicketStatus::all();  
        $company = Company::where('id',$ticket->company_id)->get();
        $companysetting = Settings::where('company_id',$ticket->company_id)->get();
        return view('sadmin.ticketdetails',compact('ticket','treply','allstatus','company','companysetting'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\News  $news
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
    }

    public function status($id, $tempcode)
    {
        $ticket = Ticket::where('tempcode',$tempcode);
        $input['ticketstatus'] = $id;

        $ticket->update($input);
        return back()->with('message','Ticket Status Updated Successfully.');
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
    public function destroy($id)
    {
        //
    }
}
