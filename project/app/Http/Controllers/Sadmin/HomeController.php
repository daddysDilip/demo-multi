<?php


namespace App\Http\Controllers\Sadmin;

use App\Http\Controllers\Controller;
use App\Counter;
use App\UserProfile;
use App\Order;
use App\OrderedProducts;
use App\Company;
use App\Planupgradepay;
use App\Buytheme;
use App\Contactus;
use App\Ticket;
use Illuminate\Http\Request;
use Carbon\Carbon; 
use DB;
use Auth;
use Mail;
use Session;

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
            return redirect('sadmin/accessdenied');
        }

        $companyid = get_company_id();
        
        $date = \Carbon\Carbon::today()->subDays(7);

        $newcompany = Company::whereRaw('DATE(created_at) BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()')->orderBy('id','desc')->get();

        $upgradeplan = Planupgradepay::join('company', 'company.id', '=', 'planupgradepay.company_id')->join('plans', 'plans.id', '=', 'planupgradepay.planid')->whereRaw('DATE(planupgradepay.created_at) BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()')->orderBy('planupgradepay.id','desc')->select(DB::raw("planupgradepay.*,company.comapany_name,plans.plantype"))->get();

        $buytheme = Buytheme::join('company', 'company.id', '=', 'buythemes.company_id')->join('themes', 'themes.id', '=', 'buythemes.themeid')->whereRaw('DATE(buythemes.created_at) BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()')->orderBy('buythemes.id','desc')->select(DB::raw("buythemes.*,company.comapany_name,themes.themename"))->get();

        $expireplan = Planupgradepay::join('company', 'company.id', '=', 'planupgradepay.company_id')->whereRaw('DATE(planupgradepay.expiry_date) BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 7 DAY)')->orderBy('planupgradepay.id','desc')->select(DB::raw("planupgradepay.*,company.comapany_name"))->get();

        $newinquiry = Contactus::whereRaw('DATE(created_at) BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW()')->where('company_id',0)->orderBy('id','desc')->get();

        $newticket = Ticket::where('tickets.ticketstatus',1)->get();

        return view('sadmin.dashboard',compact('newcompany','upgradeplan','buytheme','expireplan','newinquiry','newticket'));
    }

    public function monthlygraph()
    {
        
        $monthname = array('Jan','Feb','March','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');

        $data_points = array();

        for($i=1;$i<12;$i++)
        {

            $month_name = date("M", mktime(0, 0, 0, $i, 10));

            $upgradeplanlist =  DB::select("select * from planupgradepay where YEAR(`created_at`) = YEAR(CURDATE()) and DATE_FORMAT(created_at,'%b') = '".$month_name."'");
            $upgradeplancount = count($upgradeplanlist);

            $buythemelist =  DB::select("select * from buythemes where YEAR(`created_at`) = YEAR(CURDATE()) and DATE_FORMAT(created_at,'%b') = '".$month_name."'");
            $buythemecount = count($buythemelist);

            $point = array("ts" =>  $month_name ,"d1" =>  $upgradeplancount,"d2" =>  $buythemecount);

            array_push($data_points, $point);   
            
        }
        //echo json_encode($data);
        echo json_encode($data_points, JSON_NUMERIC_CHECK);
    }

    public function yearlygraph()
    {

        $data_points = array();
        //$pcount = $this->db->select("*,YEAR(CreatedOn) as year")->get('SC_Planupgradepay')->result();

        $fdate = date('Y', strtotime('+10 years'));

        for($i=date('Y');$i<=$fdate;$i++)
        {
            $upgradeplanlist =  DB::select("select * from planupgradepay where YEAR(`created_at`) = '".$i."'");
            $upgradeplancount = count($upgradeplanlist);

            $buythemelist =  DB::select("select * from buythemes where YEAR(`created_at`) = '".$i."'");
            $buythemecount = count($buythemelist); 

            $point = array("ts" =>  $i ,"d1" => $upgradeplancount, "d2" => $buythemecount);
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
            return redirect('sadmin/dashboard')->with('success','Mail Sent Successfully.');
        }
        else
        {
            return redirect('sadmin/dashboard')->with('error','Mail Not Sent.');
        } 
    }
}
