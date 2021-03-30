<?php

namespace App\Http\Controllers;

use App\UserProfile;
use Illuminate\Http\Request;
use App\Country;
use App\State;
use App\City;
use App\CustomerAddress;
use Auth;
use Excel;
class CustomerController extends Controller
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
        $customers = UserProfile::where('company_id',$companyid)->orderBy('id','desc')->get();
        return view('admin.customers',compact('customers'));
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

        // dd($id)

        $customer = UserProfile::findOrFail($id);

            $billingadd = CustomerAddress::where('customerid',$id)->first();

        

            // dd($billingadd);
        
        $country = Country::where('id',$billingadd->billing_country)->first()->countryname;

        $state = State::where('id',$billingadd->billing_state)->first()->statename;
        $city = City::where('id',$billingadd->billing_city)->first()->cityname;
        $scountry = Country::where('id',$billingadd->shipping_country)->first()->countryname;

        $sstate = State::where('id',$billingadd->shipping_state)->first()->statename;
        $scity = City::where('id',$billingadd->shipping_city)->first()->cityname;
        // dd($country,$state,$city);
        return view('admin.customerdetails',compact('customer','billingadd','country','state','city','scountry','sstate','scity'));
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

    public function email($subdomain,$id)
    {
        $customer = UserProfile::findOrFail($id);
        return view('admin.sendemail', compact('customer'));
    }

    public function sendemail(Request $request)
    {
        mail($request->to,$request->subject,$request->message);
        return redirect('admin/customers')->with('message','Email Send Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $subdomain, $id)
    {
        //
    }

    public function status($subdomain, $id, $status)
    {
        $customer = UserProfile::findOrFail($id);
        $input['status'] = $status;

        $customer->update($input);
        return redirect('admin/customers')->with('message','Customer Status Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($subdomain, $id)
    {
        $customer = UserProfile::findOrFail($id);
        $customer->delete();
        return redirect('admin/customers')->with('message','Customer Delete Successfully.');
    }


      public function Exportdata()
    {   

      

         $companyid = get_company_id();
        $customers = UserProfile::where('company_id',$companyid)->orderBy('id','desc')->get();

         $customersArray = []; 

         $customersArray[] = ['Sr.NO','Customer Name','Customer Email','Phone','Registred On','Status'];
       $i = 1;
         foreach ($customers as $alldata) 
         {
                       if($alldata->status == 1)
             {
                 $status = 'Active';
             }
             else if($alldata->status == 0)
             {
                 $status = 'Deactive';
             }

            // $createddate = date('d-m-Y H:ia',strtotime($alldata->created_at));
                $createddate=date("jS, M Y", strtotime($alldata->created_at));
                    // $demo=array_sum($alldata->quantities);
                      $name=$alldata->firstname." ".$alldata->lastname; 

            $customersArray[] = array($i,$name,$alldata->email,$alldata->phone,$createddate,$status);
            $i++;
        }

        Excel::create('Customer', function($excel) use ($customersArray) {

         // Set the spreadsheet title, creator, and description
             $excel->setTitle('Customer List');
             $excel->setCreator('Laravel')->setCompany('Laravel');
             $excel->setDescription('Customer List');

           // Build the spreadsheet, passing in the payments array
             $excel->sheet('sheet1', function($sheet) use ($customersArray) {
                $sheet->fromArray($customersArray, null, 'A1', false, false);
            });

     })->download('xlsx');
}


public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 

    
                        0 =>'firstname',
                        1 =>'email',
                        2 =>'phone',
                        3 =>'registeredOn',    
                        4 =>'status',
                        5 =>'action',
                         );
                    
    $totalData = UserProfile::where('company_id',$companyid)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir);
            
        if(empty($request->input('search.value')))
        {            
            $posts = UserProfile::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();
                         // dd($posts);
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  UserProfile::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('firstname', 'LIKE',"%{$search}%")
                            ->orWhere('lastname', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();



        $totalFiltered = UserProfile::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                            ->orWhere('firstname', 'LIKE',"%{$search}%")
                            ->orWhere('lastname', 'LIKE',"%{$search}%")
                            ->count();
                // dd($totalFiltered);
        }
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {
        


             $nestedData['firstname'] = $post->firstname.$post->lastname;
                $nestedData['email'] =$post->email;
                $nestedData['phone'] =$post->phone;
                $nestedData['registeredOn'] =date("jS, M Y", strtotime($post->created_at));
               if($post->status == 1)
                  {

                  $nestedData['status'] = "<a href='".url('admin/customers')."/status/".$post->id."/0'class='"."btn btn-success btn-xs'>Active</a>";

                 }
                          
               elseif($post->status == 0)
                {
                      $nestedData['status'] = "<a href='".url('admin/customers')."/status/".$post->id."/1'class='"."btn btn-danger btn-xs'>Deactive</a>";
                } 

        // $nestedData['action']="<div class='dropdown display-ib'>"."<a href='javascript:;' class='mrgn-l-xs' data-toggle='dropdown' data-hover='dropdown' data-close-others='true' aria-expanded='false'><i class='fa fa-cog fa-lg base-dark'></i></a>"."<ul class='dropdown-menu dropdown-arrow dropdown-menu-right'>"."<li>"."<a href='cms/".$post->id."/edit'><i class='fa fa-edit'></i> <span class='mrgn-l-sm'>Edit </span>". "</a></li><li><a href='#'"."onclick=".'"return delete_data('.$post->id.');">'."<i class='fa fa-trash'></i><span class='mrgn-l-sm'>Delete </span></a></a></li></ul></div>";

                $nestedData['action']=" <a href='"."customers/".$post->id."'class='btn btn-primary btn-xs'><i class='fa fa-check'></i>".trans('app.ViewDetails')."</a>"."&nbsp;<a href='"."customers/email/".$post->id."' class='btn btn-primary btn-xs'><i class='fa fa-send'></i>".trans('app.SendEmail')."</a>"."<a href='"."javascript:;' data-href='".url("/")."/admin/customers/delete/".$post->id."' data-toggle='modal' data-target='#confirm-delete' class='btn btn-danger btn-xs'><i class='fa fa-trash'></i>".trans('app.Delete')."</a><br>";
                
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
