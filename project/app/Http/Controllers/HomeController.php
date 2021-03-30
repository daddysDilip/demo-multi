<?php

namespace App\Http\Controllers;

use App\Counter;
use App\UserProfile;
use App\Order;
use App\OrderedProducts;
use App\Planupgradepay;
use App\Ticket;
use App\Buytheme;
use Illuminate\Http\Request;
use Carbon\Carbon; 
use DB;
use Auth;
use Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!has_permission('dashboard'))
        {
            return redirect('admin/accessdenied');
        }
        
        $companyid = get_company_id();

        $newcustomer = UserProfile::whereRaw('DATE(created_at) BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()')->where('company_id', '=', $companyid)->orderBy('id','desc')->get();

        $upgradeplan = Planupgradepay::join('company', 'company.id', '=', 'planupgradepay.company_id')->join('plans', 'plans.id', '=', 'planupgradepay.planid')->whereRaw('DATE(planupgradepay.created_at) BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()')->where('planupgradepay.company_id', '=', $companyid)->orderBy('planupgradepay.id','desc')->select(DB::raw("planupgradepay.*,company.comapany_name,plans.plantype"))->get();

        $expireplan = Planupgradepay::join('company', 'company.id', '=', 'planupgradepay.company_id')->whereRaw('DATE(planupgradepay.expiry_date) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)')->where('planupgradepay.company_id', '=', $companyid)->orderBy('planupgradepay.id','desc')->select(DB::raw("planupgradepay.*,company.comapany_name"))->get();

        $buytheme = Buytheme::join('company', 'company.id', '=', 'buythemes.company_id')->join('themes', 'themes.id', '=', 'buythemes.themeid')->whereRaw('DATE(buythemes.created_at) BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()')->where('buythemes.company_id', '=', $companyid)->orderBy('buythemes.id','desc')->select(DB::raw("buythemes.*,company.comapany_name,themes.themename"))->get();

        $gettitcket = Ticket::where('status',1)->where('company_id', '=', $companyid)->get();
        $ticket =[];

        foreach($gettitcket as $allticket)
        {
            if($allticket->ticketstatus == 4 || $allticket->ticketstatus == 5)
            {
                $ticket = Ticket::join('company', 'company.id', '=', 'tickets.company_id')->whereRaw('DATE(tickets.updated_at) BETWEEN DATE_SUB(NOW(), INTERVAL 1 DAY) AND NOW()')->where('tickets.company_id', '=', $companyid)->orderBy('tickets.id','desc')->select(DB::raw("tickets.*,company.comapany_name"))->get();

            }
            else if($allticket->ticketstatus == 2 || $allticket->ticketstatus == 3)
            {
                $ticket = Ticket::join('company', 'company.id', '=', 'tickets.company_id')->whereRaw('DATE(tickets.updated_at) BETWEEN DATE_SUB(NOW(), INTERVAL 4 DAY) AND NOW()')->where('tickets.company_id', '=', $companyid)->orderBy('tickets.id','desc')->select(DB::raw("tickets.*,company.comapany_name"))->get();
            }else
            {
                //$ticket ='';
            }
        }

        return view('admin.dashboard',compact('newcustomer','upgradeplan','expireplan','buytheme','ticket'));
    }

    public function monthlygraph()
    {
        $companyid = get_company_id();
        $data_points = array();

        for($i=1;$i<12;$i++)
        {

            $month_name = date("M", mktime(0, 0, 0, $i, 10));
            $date = date('Y');

            $ordercount =  DB::select("select SUM(pay_amount) as price from orders where YEAR(`booking_date`) = '".$date."' and DATE_FORMAT(booking_date,'%b') = '".$month_name."' and company_id = '".$companyid."'");

            $price = array();

            foreach ($ordercount as $value) {
                $price = $value->price;
                if($price == null)
                {
                    $totalprice = 0;
                }
                else
                {
                    $totalprice = $price;
                }
            }
            $point = array("ts" =>  $month_name ,"d1" => $totalprice);

            array_push($data_points, $point);   
            
        }
        //echo json_encode($data);
        echo json_encode($data_points, JSON_NUMERIC_CHECK);
    }

    public function yearlygraph()
    {
        $companyid = get_company_id();
        $data_points = array();
    
        for($i=date('Y');$i<=2025;$i++)
        {

            $ordercount =  DB::select("select SUM(pay_amount) as price from orders where DATE_FORMAT(booking_date,'%Y') = '".$i."' and company_id = '".$companyid."'");

            $price = array();

            foreach ($ordercount as $value) {
                $price = $value->price;
                if($price == null)
                {
                    $totalprice = 0;
                }
                else
                {
                    $totalprice = $price;
                }
            }
            $point = array("ts" =>  $i ,"d1" => $totalprice);

            array_push($data_points, $point);   
        }

        echo json_encode($data_points, JSON_NUMERIC_CHECK);
    }

    public function qucikmail(Request $request)
    {
        $from = 'noreply@dealonshop.com';
        $from_name = 'Shoppingcart';
        $to = $request['to']; 
        $subject = $request['subject'];
        $message = $request['message'];

        if(mail($to,$subject,$message))
        {
            return redirect('admin/dashboard')->with('success','Mail Sent Successfully.');
        }
        else
        {
            return redirect('admin/dashboard')->with('error','Mail Not Sent.');
        } 
    }
}
