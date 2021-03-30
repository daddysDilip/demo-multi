<?php

namespace App\Http\Controllers;

use App\Event;
use App\EventTranslations;
use DB;
use App\SectionTitles;
use Illuminate\Http\Request;
use File;
use URL;
use Carbon\Carbon; 
use Auth;
use Excel;


class EventController extends Controller
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
        $companyid = get_company_id();
        $titles = SectionTitles::where('company_id', '=', $companyid)->get();
        $event = Event::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.eventlist',compact('event','titles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.eventadd');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event();
        $event->fill($request->all());

        $createslug = str_slug($request->eventname, '-');
        $slugcheck = Event::where('slug','=',$createslug)->count();

        $slug="";
        if($slugcheck > 0 )
        {   
            $slug = $createslug."_".($slugcheck-1);
        }
        else
        {
            $slug = $createslug;
        }

        if ($file = $request->file('eventimage'))
        {
            $photo_name = str_random(3).$request->file('eventimage')->getClientOriginalName();
            $file->move('assets/images/event',$photo_name);
            $event['eventimage'] = $photo_name;
        }

        $date = Carbon::createFromFormat('d/m/Y', $event['eventdate']);
        $event['eventdate'] =  $date->format('Y-m-d');

        $event['tempcode'] = str_random(6);

        if ($request->status == "")
        {
            $event['status'] = 0;
        }
        else
        {
            $event['status'] = 1;
        }   
        $event['slug'] = $slug;
        $event['company_id'] = get_company_id();

        // dd($event);

        $event->save();

        $eventtrans = new EventTranslations();
        $eventtrans['eventid'] = $event->id;
        $eventtrans['eventname'] = $request->eventname;
        $eventtrans['description'] = $request->description;
        $eventtrans['langcode'] = $request->default_langcode;
        $eventtrans['company_id'] = get_company_id();
        $eventtrans->save();


            if($request->langcode != null)
        {

        foreach($request->langcode as $data => $transdata)
        {

            $eventalltrans = new EventTranslations();
            $eventalltrans['eventid'] = $event->id;
            $eventalltrans['eventname'] = $request->trans_eventname[$data];
            $eventalltrans['description'] = $request->trans_description[$data];
            $eventalltrans['langcode'] = $transdata;
            $eventalltrans['company_id'] = get_company_id();
            $eventalltrans->save();    
            
        }
    }




        return redirect('admin/event')->with('message',trans("app.EventAddMsg"));
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
        $event = Event::findOrFail($id);
        return view('admin.eventedit',compact('event'));
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
        $event = Event::findOrFail($id);
        $data = $request->all();

        $date = Carbon::createFromFormat('d/m/Y', $data['eventdate']);
        $data['eventdate'] =  $date->format('Y-m-d');

        if ($file = $request->file('eventimage')){
            $photo_name = str_random(3).$request->file('eventimage')->getClientOriginalName();
            $file->move('assets/images/event',$photo_name);
            $data['eventimage'] = $photo_name;

            if($event->eventimage != '')
            {
               unlink('assets/images/event/'.$event->eventimage);
            }
        }

        if ($request->status == "")
        {
            $data['status'] = 0;
        }
        else
        {
            $data['status'] = 1;
        }
       
        $event->update($data);

        $eventdeflang_exists = EventTranslations::where('langcode', '=', $request->default_langcode)->where('eventid', '=', $id)->first();

        if(count($eventdeflang_exists) > 0)
        {
            EventTranslations::where('langcode', '=', $request->default_langcode)->where('eventid', '=', $id)->update(['eventname' => $request->eventname, 'description' => $request->description]);
        }
        else
        {
            $eventtrans = new EventTranslations();
            $eventtrans['eventid'] = $id;
            $eventtrans['eventname'] = $request->eventname;
            $eventtrans['description'] = $request->description;
            $eventtrans['langcode'] = $request->default_langcode;
            $eventtrans['company_id'] = get_company_id();
            $eventtrans->save();
        }
        
            if($request->langcode != null)
        {


        foreach($request->langcode as $data => $transdata)
        {
            $eventlang_exists = EventTranslations::where('langcode', '=', $transdata)->where('eventid', '=', $id)->first();
            if(count($eventlang_exists) > 0)
            {

                EventTranslations::where('langcode', '=', $transdata)->where('eventid', '=', $id)->update(['eventname' => $request->trans_eventname[$data], 'description' => $request->trans_description[$data]]);
            }
            else
            {
                $eventalltrans = new EventTranslations();
                $eventalltrans['eventid'] = $id;
                $eventalltrans['eventname'] = $request->trans_eventname[$data];
                $eventalltrans['description'] = $request->trans_description[$data];
                $eventalltrans['langcode'] = $transdata;
                $eventalltrans['company_id'] = get_company_id();
                $eventalltrans->save();
            }
            
        }
    }

        return redirect('admin/event')->with('message',trans("app.EventUpdateMsg"));
    }

    public function status($subdomain,$id , $status)
    {
        $product = Event::findOrFail($id);
        $input['status'] = $status;

        $product->update($input);
        return redirect('admin/event')->with('message',trans("app.EventStatusUpdateMsg"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain,$id)
    {
        $event = Event::findOrFail($id);

        if($event->eventimage != '')
        {
            unlink('assets/images/event/'.$event->eventimage);
        }

        $event->delete();

        $eventtrans = EventTranslations::where('eventid',$id);
        $eventtrans->delete();

        return redirect('admin/event')->with('message',trans("app.EventDeleteMsg"));
    }



    public function deleteimage(Request $request , $subdomain ,$id )
    {
        $event = Event::findOrFail($id); 
       
        if($event->eventimage != '')
        {
            unlink('assets/images/event/'.$event->eventimage);
        }
       
        $data['eventimage'] = '';
        $updatedata = $event->update($data);
    }

    public function Exportdata()
    { 
        // dd('innn event');

        $companyid = get_company_id();
         
        $event = Event::where('company_id',$companyid)->orderBy('id','desc')->get();

        // dd($event);
          
        $eventArray = []; 

        $eventArray[] = ['Sr.NO','Event Name','Event Date','Featured Image','Event Details','status'];
        $i = 1;

        foreach ($event as $alldata) 
        {
            if($alldata->status == 1)
            {
                $status = 'Active';
            }
            else if($alldata->status == 0)
            {
                $status = 'Deactive';
            }

            $eventname = '';
            $description = '';

            $eventtrans = EventTranslations::where('eventid',$alldata->id)->where('langcode',get_defaultlanguage())->first();

            if(count($eventtrans) > 0)
            {
                $eventname = $eventtrans->eventname;
                $description = $eventtrans->description;
            }

            $date =date('jS M Y',strtotime($alldata->eventdate));

            $eventArray[] = array($i,$eventname,$date,$alldata->eventimage,$description,$status);
            $i++;
        }   
        Excel::create('Event', function($excel) use ($eventArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Event List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('Event List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($eventArray) {
                $sheet->fromArray($eventArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }


    public function import(Request $request)
    {

        // dd($request->all());
        $companyid = get_company_id();

        if($request->file('imported_file'))
        {
            $path = $request->file('imported_file')->getRealPath();
            $data = Excel::load($path, function($reader) {
            })->get();

            if(!empty($data) && $data->count())
            {
                $data = $data->toArray();
                for($i=0;$i<count($data);$i++)
                {
                  $dataImported[] = $data[$i];
                }
            }

            foreach ($dataImported as $value)
            {    
                $eventdate=date('Y-m-d',strtotime($value['event_date']));

                $createslug = str_slug($value['event_name'], '-');
                $slugcheck = Event::where('slug','=',$createslug)->count();

                $slug="";
                if($slugcheck > 0 )
                {   
                    $slug = $createslug."_".($slugcheck-1);
                }
                else
                {
                    $slug = $createslug;
                }
            

                if($value['status'] == 'Active')
                {
                    $status=1;
                } 
                else
                {
                    $status=0;
                }
                $image=$value['featured_image'];

                $event = new Event();
                $event['eventname'] = $value['event_name'];
                $event['eventimage'] = $image;
                $event['eventdate'] = $eventdate;
                $event['description'] = $value['event_details'];
                $event['slug'] = $slug;
                $event['status'] = $status;
                $event['tempcode'] = str_random(6);
                $event['company_id'] = $companyid;
                $event->save();

                

                $eventtrans = new EventTranslations();
                $eventtrans['eventid'] = $event->id;
                $eventtrans['eventname'] = $value['event_name'];
                $eventtrans['description'] = $value['event_details'];
                $eventtrans['langcode'] = get_defaultlanguage();
                $eventtrans['company_id'] = get_company_id();
                $eventtrans->save();

            }
            // die();

        }
        return back();
    }


    public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                          


                        0 =>'eventimage',
                        1 =>'eventname',
                        2 =>'eventdate',
                        3 =>'status',
                        4 =>'action',
                         );
  
        $totalData = Event::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = Event::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Event::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('eventname', 'LIKE',"%{$search}%")
                            ->orWhere('eventdate', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Event::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('eventname', 'LIKE',"%{$search}%")
                            ->orWhere('eventdate', 'LIKE',"%{$search}%")
                            ->count();
                         // dd($totalFiltered);
        }
   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {

            // $etitle=EventTranslations::where('eventid',$post->id)->where('langcode',app()->getLocale() )->first()->eventname;

             if($post->eventimage != '')
            {
        $image= "<img style='width: 300px;height: 100px;' src='".url("/")."/assets/images/event/".$post->eventimage."'>";
              }
               else
               {
        
        $image="<img src='".url("/")."/assets/images/placeholder.jpg' alt='product thumbnail' class='img-responsive' width='300' height='300' style='width: 300px;height: 100px;'>";
              }
                   
                  
                $nestedData['eventimage'] =$image;
                $nestedData['eventname'] =$post->eventname;
                $nestedData['eventdate']= date('jS M Y',strtotime($post->eventdate));

                       if($post->status == 1)
                 {
                  $nestedData['status'] = "<a href='".url('admin/event')."/status/$post->id}}/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }                                       
                elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/event')."/status/$post->id}}/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                }
                              
$nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='event/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";

                $data[] = $nestedData;
                $i++;
            }
        }          
        $json_data=array(
                  "draw"            => intval($request->input('draw')),  
                  "recordsTotal"    => intval($totalData),  
                  "recordsFiltered" => intval($totalFiltered), 
                  "data"            => $data   
                    );

        // dd($json_data);

       echo json_encode($json_data,JSON_UNESCAPED_UNICODE ); 
        
    }  


}
