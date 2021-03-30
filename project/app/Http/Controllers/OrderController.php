<?php

namespace App\Http\Controllers;

use App\Order;
use App\OrderedProducts;
use App\Product;
use App\Vendors;
use Illuminate\Http\Request;
use Auth;
use App\Discount;
use App\Company;
use App\Emailtemplates;
use App\Settings;
use App\UserProfile;
use PDF;
use Excel;

class OrderController extends Controller
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
        //Order::$withoutAppends = true;

        $orders = Order::where('company_id',$companyid)->orderBy('id','desc')->get();

        return view('admin.orderlist',compact('orders'));
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
          
       
        $order = Order::findOrFail($id);
        $products = OrderedProducts::where('orderid',$id)->get();
        $discount = Discount::where('id', $order->discount_id)->get();
        $customer = UserProfile::where('id', $order->customerid)->first();


        return view('admin.orderdetails',compact('order','products','discount','customer'));
    }

    public function status(Request $request,$subdomain,$id,$status)
    {

        $companyid = get_company_id();
        $mainorder = Order::findOrFail($id);
        $ordernumber = $mainorder->order_number;
        $name = $mainorder->customer_name;

        $company =  Company::join('cities','cities.id', '=', 'company.city')->where('company.id',$companyid)->first();
        $settings =  Settings::where('id',$companyid)->first();

        $currency = $settings->currency_sign;
        //print_r($company);
        $link = $request->root();
        $storename = $company->comapany_name;

        if($settings->logo != '') { 
           $logo = '<img src="'.$link.'/assets/images/company/'.$settings->logo.'" style="margin-bottom: 20px;">';
        }
        else{
            $logo = '';
        }
        
        $caddress = '<address><p style="margin:0px;"><span class="fw-medium font-lg mrgn-b-md show" style="font-weight:bold;margin:0px;">'.$mainorder->customer_name.'</span></p><p style="margin:0px;"><span class="show">'.$mainorder->customer_address.',</span></p><p style="margin:0px;"><span class="show">'.$mainorder->customer_city.' - '.$mainorder->customer_zip.'</span></p></address>';

        $subtotal=0;
        $grandtotal=0;


        $stat['status'] = $status;

        if ($status == "processing")
        {
            $orders = OrderedProducts::where('orderid',$id)->get();
            $productdetail = '';
            $discountval = '';
            
            $c=1;
            foreach ($orders as $payee) 
            {   
                $order = OrderedProducts::findOrFail($payee->id);
                $sts['status'] = "processing";
                $order->update($sts);

                $product = get_productdetail($payee->productid);

                $price = ($payee->cost)*($payee->quantity);
                $pshippingcost = $payee->shipcost;
                $ptax = $payee->tax;
                $finalptax = $price * ($ptax/100);
                $psubtotal = $price + $pshippingcost + $finalptax;

                $imgurl = $link.'/assets/images/products/'.\App\Product::findOrFail($payee->productid)->feature_image;

                if($mainorder->shippingmethod  == 'Per Product') { 
                    $prshipcost = '<span id="shipping_cost">Shipping Cost: '.$currency.' '.$payee->shipcost.'</span>';
                } 
                else
                {
                    $prshipcost = '';
                }
                if($mainorder->taxmethod  == 'Per Product') { 
                    $tax = $payee->tax;
                    $totaltax = ($payee->cost) * ($tax/100);
                    $prtax = '<span id="shipping_cost">Tax ('.$tax.'%): '.$currency.' '.$totaltax.'</span>';
                } 
                else
                {
                    $prtax = '';
                }

                $productdetail .='<tr style="background: #f5f5f5;">
                    <td style="text-align: center;"><span><img src="'.$imgurl.'" width="100px;" height="65px;"></span></td>
                    <td style="text-align: center;">'.$product[0]->title.'<br>'. $prshipcost.'<br>'.$prtax.'</td>
                    <td style="text-align: center;">'.$payee->quantity.'</td>
                    <td style="text-align: center;">'.$psubtotal.'</td>
                </tr>';

            }  
            
            if($mainorder->shippingmethod  == 'Per Product' && $mainorder->taxmethod  == 'Per Product')
            {
                $subtotal = '';
            }
            if($mainorder->shippingmethod  == 'Per Order' || $mainorder->taxmethod  == 'Per Order')
            {
                $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($mainorder->subtotal, 2).'</h5>';
            }
            else if(!empty($mainorder->discount_code))
            {
                $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($mainorder->subtotal, 2).'</h5>';
            }
            $voucher = Discount::where('code',$mainorder->discount_code)->get();
            
            if(!empty($mainorder->discount_code))
            {
                $vcode = '<h5>Discount - <span>('.$voucher[0]->code.') : ';
                if($voucher[0]->amounttype ==2) {
                    $discount = $mainorder->discountprice;
                    $discountval = '- '.$currency.' '.number_format($discount, 2);   
                } else if($voucher[0]->amounttype ==1) {
                    $discount = $mainorder->discountprice;
                    $discountval = $voucher[0]->discount.'% <br>- '.$currency.' '.number_format($discount, 2).'</h5>';
                }
            }
            else
            {
                $vcode = '';
            }

            if($mainorder->shippingmethod  == 'Per Order')
            {
                $shipcost = '<h5>Shipping : '.$currency.' '.$mainorder->shippingcharge.'</h5> ';
            }
            else
            {
                $shipcost = '';
            }

            if($mainorder->taxmethod  == 'Per Order')
            {
                if(!empty($mainorder->discount_code))
                {
                    $tax = $mainorder->tax;
                    $totalprice = ($mainorder->subtotal) - ($mainorder->discountprice) + ($mainorder->shippingcharge);
                    $totaltax = ($totalprice) * ($tax/100);
                }
                else
                {
                    $tax = $mainorder->tax;
                    $totalprice = ($mainorder->subtotal) - ($mainorder->discountprice) + ($mainorder->shippingcharge);
                    $totaltax = ($mainorder->subtotal + $mainorder->shippingcharge) * ($tax/100);
                }
                $taxcost = '<h5>Tax ('.$tax.'%) : '.$currency.' '.number_format($totaltax, 2).'</h5>';
            }
            else
            {
                $taxcost = '';
            }
            $totalprice = '<h5>Total : '.$currency.' '.$mainorder->pay_amount.'</h5>';

            $priceval = '<h5 style="margin:0px;">'.$subtotal.'</h5>
                        <h5 style="margin:0px;">'.$vcode.' '.$discountval.'</h5>
                        <h5 style="margin:0px;">'.$shipcost.'</h5>
                        <h5 style="margin:0px;">'.$taxcost.'</h5>
                        <h5 style="margin:0px;">'.$totalprice.'</h5>';

            $emailtemplate =  Emailtemplates::where('Label','In-Progress-Order-Mail')->where('company_id',$companyid)->get();

            $find =  array('{{link}}','{{Name}}','{{OrderID}}','{{productdetail}}','{{priceval}}','{{address}}','{{logo}}','{{storename}}');
            $replace = array($link,$name,$ordernumber,$productdetail,$priceval,$caddress,$logo,$storename);

            $headers = "MIME-Version: 1.0\r\n"; #Define MIME Version
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            $subject = str_replace($find,$replace,$emailtemplate[0]->subject);
            $message = str_replace($find,$replace,$emailtemplate[0]->content);
            
            mail($mainorder->customer_email,$subject,$message,$headers);
        }
        else if ($status == "completed")
        {
            $orders = OrderedProducts::where('orderid',$id)->get();
            $productdetail = '';
            $discountval = '';
            
            $c=1;

            foreach ($orders as $payee) {
                $order = OrderedProducts::findOrFail($payee->id);

                $sts['paid'] = "yes";
                $sts['status'] = "completed";
                $order->update($sts);

                $product = get_productdetail($payee->productid);

                $price = ($payee->cost)*($payee->quantity);
                $pshippingcost = $payee->shipcost;
                $ptax = $payee->tax;
                $finalptax = $price * ($ptax/100);
                $psubtotal = $price + $pshippingcost + $finalptax;

                $imgurl = $link.'/assets/images/products/'.\App\Product::findOrFail($payee->productid)->feature_image;

                if($mainorder->shippingmethod  == 'Per Product') { 
                    $prshipcost = '<span id="shipping_cost">Shipping Cost: '.$currency.' '.$payee->shipcost.'</span>';
                } 
                else
                {
                    $prshipcost = '';
                }
                if($mainorder->taxmethod  == 'Per Product') { 
                    $tax = $payee->tax;
                    $totaltax = ($payee->cost) * ($tax/100);
                    $prtax = '<span id="shipping_cost">Tax ('.$tax.'%): '.$currency.' '.$totaltax.'</span>';
                } 
                else
                {
                    $prtax = '';
                }

                $productdetail .='<tr style="background: #f5f5f5;">
                    <td style="text-align: center;"><span><img src="'.$imgurl.'" width="100px;" height="65px;"></span></td>
                    <td style="text-align: center;">'.$product[0]->title.'<br>'. $prshipcost.'<br>'.$prtax.'</td>
                    <td style="text-align: center;">'.$payee->quantity.'</td>
                    <td style="text-align: center;">'.$psubtotal.'</td>
                </tr>';
            }

            if($mainorder->shippingmethod  == 'Per Product' && $mainorder->taxmethod  == 'Per Product')
            {
                $subtotal = '';
            }
            if($mainorder->shippingmethod  == 'Per Order' || $mainorder->taxmethod  == 'Per Order')
            {
                $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($mainorder->subtotal, 2).'</h5>';
            }
            else if(!empty($mainorder->discount_code))
            {
                $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($mainorder->subtotal, 2).'</h5>';
            }
            $voucher = Discount::where('code',$mainorder->discount_code)->get();
            
            if(!empty($mainorder->discount_code))
            {
                $vcode = '<h5>Discount - <span>('.$voucher[0]->code.') : ';
                if($voucher[0]->amounttype ==2) {
                    $discount = $mainorder->discountprice;
                    $discountval = '- Rs'.number_format($discount, 2);   
                } else if($voucher[0]->amounttype ==1) {
                    $discount = $mainorder->discountprice;
                    $discountval = $voucher[0]->discount.'% <br>- '.$currency.' '.number_format($discount, 2).'</h5>';
                }
                else
                {
                    $discountval = '';
                }
            }
            else
            {
                $vcode = '';
            }

            if($mainorder->shippingmethod  == 'Per Order')
            {
                $shipcost = '<h5>Shipping : '.$currency.' '.$mainorder->shippingcharge.'</h5> ';
            }
            else
            {
                $shipcost = '';
            }

            if($mainorder->taxmethod  == 'Per Order')
            {
                if(!empty($mainorder->discount_code))
                {
                    $tax = $mainorder->tax;
                    $totalprice = ($mainorder->subtotal) - ($mainorder->discountprice) + ($mainorder->shippingcharge);
                    $totaltax = ($totalprice) * ($tax/100);
                }
                else
                {
                    $tax = $mainorder->tax;
                    $totalprice = ($mainorder->subtotal) - ($mainorder->discountprice) + ($mainorder->shippingcharge);
                    $totaltax = ($mainorder->subtotal + $mainorder->shippingcharge) * ($tax/100);
                }
                $taxcost = '<h5>Tax ('.$tax.'%) : '.$currency.' '.number_format($totaltax, 2).'</h5>';
            }
            else
            {
                $taxcost = '';
            }
            $totalprice = '<h5>Total : '.$currency.' '.$mainorder->pay_amount.'</h5>';

            $priceval = '<h5 style="margin:0px;">'.$subtotal.'</h5>
                        <h5 style="margin:0px;">'.$vcode.' '.$discountval.'</h5>
                        <h5 style="margin:0px;">'.$shipcost.'</h5>
                        <h5 style="margin:0px;">'.$taxcost.'</h5>
                        <h5 style="margin:0px;">'.$totalprice.'</h5>';

            $emailtemplate =  Emailtemplates::where('Label','Completed-Order')->where('company_id',$companyid)->get();

            $find =  array('{{link}}','{{Name}}','{{OrderID}}','{{productdetail}}','{{priceval}}','{{address}}','{{logo}}','{{storename}}');
            $replace = array($link,$name,$ordernumber,$productdetail,$priceval,$caddress,$logo,$storename);

            $subject = str_replace($find,$replace,$emailtemplate[0]->subject);
            $message = str_replace($find,$replace,$emailtemplate[0]->content);
            
            $headers = "MIME-Version: 1.0\r\n"; #Define MIME Version
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            mail($mainorder->customer_email,$subject,$message,$headers);
        }
        else if ($status == "cancelled")
        {
            $orders = OrderedProducts::where('orderid',$id)->get();
            $productdetail = '';
            $discountval = '';
            
            $c=1;

            foreach ($orders as $payee) {
                $order = OrderedProducts::findOrFail($payee->id);

                $sts['paid'] = "no";
                $sts['status'] = "cancelled";
                $order->update($sts);

                $product = Product::findOrFail($payee->productid);

                $productdata['stock'] = $product->stock + $payee->quantity;
                $product->update($productdata);

                $product = get_productdetail($payee->productid);

                $price = ($payee->cost)*($payee->quantity);
                $pshippingcost = $payee->shipcost;
                $ptax = $payee->tax;
                $finalptax = $price * ($ptax/100);
                $psubtotal = $price + $pshippingcost + $finalptax;

                $imgurl = $link.'/assets/images/products/'.\App\Product::findOrFail($payee->productid)->feature_image;

                
                if($mainorder->shippingmethod  == 'Per Product') { 
                    $prshipcost = '<span id="shipping_cost">Shipping Cost: '.$currency.' '.$payee->shipcost.'</span>';
                } 
                else
                {
                    $prshipcost = '';
                }
                if($mainorder->taxmethod  == 'Per Product') { 
                    $tax = $payee->tax;
                    $totaltax = ($payee->cost) * ($tax/100);
                    $prtax = '<span id="shipping_cost">Tax ('.$tax.'%): '.$currency.' '.$totaltax.'</span>';
                } 
                else
                {
                    $prtax = '';
                }
                $productdetail .='<tr style="background: #f5f5f5;">
                    <td style="text-align: center;"><span><img src="'.$imgurl.'" width="100px;" height="65px;"></span></td>
                    <td style="text-align: center;">'.$product[0]->title.'<br>'. $prshipcost.'<br>'.$prtax.'</td>
                    <td style="text-align: center;">'.$payee->quantity.'</td>
                    <td style="text-align: center;">'.$psubtotal.'</td>
                </tr>';
            }
            if($mainorder->shippingmethod  == 'Per Product' && $mainorder->taxmethod  == 'Per Product')
            {
                $subtotal = '';
            }
            if($mainorder->shippingmethod  == 'Per Order' || $mainorder->taxmethod  == 'Per Order')
            {
                $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($mainorder->subtotal, 2).'</h5>';
            }
            else if(!empty($mainorder->discount_code))
            {
                $subtotal = '<h5>Sub - Total: &nbsp;'.$currency.' '.number_format($mainorder->subtotal, 2).'</h5>';
            }
            $voucher = Discount::where('code',$mainorder->discount_code)->get();
            
            if(!empty($mainorder->discount_code))
            {
                $vcode = '<h5>Discount - <span>('.$voucher[0]->code.') : ';
                if($voucher[0]->amounttype ==2) {
                    $discount = $mainorder->discountprice;
                    $discountval = '- Rs'.number_format($discount, 2);   
                } else if($voucher[0]->amounttype ==1) {
                    $discount = $mainorder->discountprice;
                    $discountval = $voucher[0]->discount.'% <br>- '.$currency.' '.number_format($discount, 2).'</h5>';
                }
                else
                {
                    $discountval = '';
                }
            }
            else
            {
                $vcode = '';
            }

            if($mainorder->shippingmethod  == 'Per Order')
            {
                $shipcost = '<h5>Shipping : '.$currency.' '.$mainorder->shippingcharge.'</h5> ';
            }
            else
            {
                $shipcost = '';
            }

            if($mainorder->taxmethod  == 'Per Order')
            {
                if(!empty($mainorder->discount_code))
                {
                    $tax = $mainorder->tax;
                    $totalprice = ($mainorder->subtotal) - ($mainorder->discountprice) + ($mainorder->shippingcharge);
                    $totaltax = ($totalprice) * ($tax/100);
                }
                else
                {
                    $tax = $mainorder->tax;
                    $totalprice = ($mainorder->subtotal) - ($mainorder->discountprice) + ($mainorder->shippingcharge);
                    $totaltax = ($mainorder->subtotal + $mainorder->shippingcharge) * ($tax/100);
                }
                $taxcost = '<h5>Tax ('.$tax.'%) : '.$currency.' '.number_format($totaltax, 2).'</h5>';
            }
            else
            {
                $taxcost = '';
            }
            $totalprice = '<h5>Total : '.$currency.' '.$mainorder->pay_amount.'</h5>';

            $priceval = '<h5 style="margin:0px;">'.$subtotal.'</h5>
                        <h5 style="margin:0px;">'.$vcode.' '.$discountval.'</h5>
                        <h5 style="margin:0px;">'.$shipcost.'</h5>
                        <h5 style="margin:0px;">'.$taxcost.'</h5>
                        <h5 style="margin:0px;">'.$totalprice.'</h5>';

            $emailtemplate =  Emailtemplates::where('Label','Order-Cancelled-Mail')->where('company_id',$companyid)->get();

            
            $find =  array('{{link}}','{{Name}}','{{OrderID}}','{{productdetail}}','{{priceval}}','{{address}}','{{logo}}','{{storename}}');
            $replace = array($link,$name,$ordernumber,$productdetail,$priceval,$caddress,$logo,$storename);

            $subject = str_replace($find,$replace,$emailtemplate[0]->subject);
            $message = str_replace($find,$replace,$emailtemplate[0]->content);
            
            $headers = "MIME-Version: 1.0\r\n"; #Define MIME Version
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            mail($mainorder->customer_email,$subject,$message,$headers);
        }
        
        $mainorder->update($stat); 
        return redirect('admin/orders/'.$id)->with('message', trans("app.OrderStatusUpdatedMsg"));
    }

    public function email($subdomain,$id)
    {
        $order = Order::findOrFail($id);
        return view('admin.sendmail', compact('order'));
    }

    public function sendemail(Request $request)
    {
        mail($request->to, $request->subject, $request->message);
        return redirect('admin/orders')->with('message', trans("app.EmailSendSuccessfullyMsg"));
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
        //
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

    public function orderdetailspdf(Request $request,$subdomain,$id)
    {

      
        $themename = get_theme_name();
        $user = UserProfile::find(Auth::user()->id);
        $order = Order::findOrFail($id);
        $orderproduct = OrderedProducts::where('orderid', $id)->get();
        $discount = Discount::where('id', $order->discount_id)->get();

        $pdf=PDF::loadView('admin.orderpdfview', compact('user','order','orderproduct','discount'));
        //return $pdf->stream('pdfview.pdf');
        return $pdf->download('order.pdf');
    }

    public function Exportdata()
    {
        
        $companyid = get_company_id();
        //Order::$withoutAppends = true;

        $orders = Order::where('company_id',$companyid)->orderBy('id','desc')->get();
        // dd($orders);
        // $contact = Contactus::where('company_id',$companyid)->orderBy('id','desc')->get();

        $orderArray = []; 

        $orderArray[] = ['SR.NO','Order ID', 'Customer Name', 'Customer Email','Number', 'Total Product', 'Total Cost','Payment Method','Billing Address','Shipping Address','Status'];

        $i = 1;
        foreach ($orders as $alldata) 
        {
             //           if($alldata->status == 1)
             // {
             //     $status = 'Active';
             // }
             // else if($alldata->status == 0)
             // {
             //     $status = 'Deactive';
             // }

            // $createddate = date('d-m-Y H:ia',strtotime($alldata->created_at));
            $demo=array_sum($alldata->quantities);
            $name=$alldata->customer_firstname." ".$alldata->customer_lastname; 

            $orderArray[] = array($i,$alldata->id,$name,$alldata->customer_email,$alldata->customer_phone,$demo,$alldata->pay_amount,$alldata->method,$alldata->customer_address,$alldata->shipping_address,$alldata->status);
            $i++;
        }

        Excel::create('order', function($excel) use ($orderArray) {

            // Set the spreadsheet title, creator, and description
            $excel->setTitle('Orders List');
            $excel->setCreator('Laravel')->setCompany('Laravel');
            $excel->setDescription('Orders List');

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($orderArray) {
                $sheet->fromArray($orderArray, null, 'A1', false, false);
            });

        })->download('xlsx');
    }




     public function allPosts(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                            // 0 =>'id', 
                            // 1 =>'title',
                            // 2=> 'body',
                            // 3=> 'created_at',
                            // 4=> 'id',

                        0 =>'id',
                        1 =>'customeremail',
                        2 =>'customername',
                        3 =>'totalproducts',
                        4 =>'totalcost',
                        5 =>'paymentmethod',
                        6 =>'status',
                        7 =>'action',
                         );

        $totalData = Order::where('company_id',$companyid)->orderBy('id','desc')->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir,'Heleoeoeoe demo auth',count($totalData));
            
        if(empty($request->input('search.value')))
        {            
            $posts = Order::where('company_id',$companyid)
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd(count($posts),"If Condiction in demo add");
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Order::where('company_id',$companyid)
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('customer_email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Order::where('company_id',$companyid)
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('customer_email', 'LIKE',"%{$search}%")
                             ->count();

                         // dd($totalFiltered);
                         // dd(count($posts),$totalFiltered,"else Condiction in demo add");

        }

   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {


                                if($post->status == "completed")
                                {
                                     $btn_class = 'primary'; 
                                }
                                elseif($post->status == "cancelled")
                                {
                                    $btn_class = 'danger'; 
                                }
                                elseif($post->status == "processing")
                                {
                                    $btn_class = 'info'; 
                                }
                                else
                                {
                                    $btn_class = 'default'; 
                                }
                           
          
                                            
                $nestedData['id'] ="#".$post->id;
                $nestedData['customeremail'] =$post->customer_email;
                $nestedData['customername']=$post->customer_firstname." ".$post->customer_lastname;
                $nestedData['totalproducts']=array_sum($post->quantities);
                $nestedData['totalcost']=$post->subtotal;
                $nestedData['paymentmethod']=$post->method;
                $nestedData['status']="<button class='btn btn-".$btn_class." "."btn-xs'>".ucfirst($post->status)."</button>";

                 $nestedData['action']="<a href='orders/".$post->id."' class='btn btn-primary btn-xs'><i class='fa fa-check'></i>ViewDetails</a>";
                                    


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



       echo json_encode($json_data,JSON_UNESCAPED_UNICODE ); 
        
    }   




      public function allPostspending(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                           
                        0 =>'id',
                        1 =>'customeremail',
                        2 =>'customername',
                        3 =>'totalproducts',
                        4 =>'totalcost',
                        5 =>'paymentmethod',
                        6 =>'status',
                        7 =>'action',
                         );

        $totalData = Order::where('company_id',$companyid)->where('status','pending')->orderBy('id','desc')->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir,'Heleoeoeoe demo auth',count($totalData));
            
        if(empty($request->input('search.value')))
        {            
            $posts = Order::where('company_id',$companyid)
                            ->where('status','pending')    
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd(count($posts),"If Condiction in demo add");
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Order::where('company_id',$companyid)
                             ->where('status','pending')   
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('customer_email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Order::where('company_id',$companyid)
                             ->where('status','pending')   
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('customer_email', 'LIKE',"%{$search}%")
                             ->count();

                         // dd($totalFiltered);
                         // dd(count($posts),$totalFiltered,"else Condiction in demo add");

        }

   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {


                                if($post->status == "completed")
                                {
                                     $btn_class = 'primary'; 
                                }
                                elseif($post->status == "cancelled")
                                {
                                    $btn_class = 'danger'; 
                                }
                                elseif($post->status == "processing")
                                {
                                    $btn_class = 'info'; 
                                }
                                else
                                {
                                    $btn_class = 'default'; 
                                }
                           
          
                                            
                $nestedData['id'] ="#".$post->id;
                $nestedData['customeremail'] =$post->customer_email;
                $nestedData['customername']=$post->customer_firstname." ".$post->customer_lastname;
                $nestedData['totalproducts']=array_sum($post->quantities);
                $nestedData['totalcost']=$post->subtotal;
                $nestedData['paymentmethod']=$post->method;
                $nestedData['status']="<button class='btn btn-".$btn_class." "."btn-xs'>".ucfirst($post->status)."</button>";

                 $nestedData['action']="<a href='orders/".$post->id."' class='btn btn-primary btn-xs'><i class='fa fa-check'></i>ViewDetails</a>";
                                    


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



       echo json_encode($json_data,JSON_UNESCAPED_UNICODE ); 
        
    }   


          public function allPostsprocessing(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                           
                        0 =>'id',
                        1 =>'customeremail',
                        2 =>'customername',
                        3 =>'totalproducts',
                        4 =>'totalcost',
                        5 =>'paymentmethod',
                        6 =>'status',
                        7 =>'action',
                         );

        $totalData = Order::where('company_id',$companyid)->where('status','processing')->orderBy('id','desc')->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir,'Heleoeoeoe demo auth',count($totalData));
            
        if(empty($request->input('search.value')))
        {            
            $posts = Order::where('company_id',$companyid)
                            ->where('status','processing')    
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd(count($posts),"If Condiction in demo add");
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Order::where('company_id',$companyid)
                             ->where('status','processing')   
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('customer_email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Order::where('company_id',$companyid)
                             ->where('status','processing')   
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('customer_email', 'LIKE',"%{$search}%")
                             ->count();

                         // dd($totalFiltered);
                         // dd(count($posts),$totalFiltered,"else Condiction in demo add");

        }

   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {


                                if($post->status == "completed")
                                {
                                     $btn_class = 'primary'; 
                                }
                                elseif($post->status == "cancelled")
                                {
                                    $btn_class = 'danger'; 
                                }
                                elseif($post->status == "processing")
                                {
                                    $btn_class = 'info'; 
                                }
                                else
                                {
                                    $btn_class = 'default'; 
                                }
                           
          
                                            
                $nestedData['id'] ="#".$post->id;
                $nestedData['customeremail'] =$post->customer_email;
                $nestedData['customername']=$post->customer_firstname." ".$post->customer_lastname;
                $nestedData['totalproducts']=array_sum($post->quantities);
                $nestedData['totalcost']=$post->subtotal;
                $nestedData['paymentmethod']=$post->method;
                $nestedData['status']="<button class='btn btn-".$btn_class." "."btn-xs'>".ucfirst($post->status)."</button>";

                 $nestedData['action']="<a href='orders/".$post->id."' class='btn btn-primary btn-xs'><i class='fa fa-check'></i>ViewDetails</a>";
                                    


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



       echo json_encode($json_data,JSON_UNESCAPED_UNICODE ); 
        
    }   



           public function allPostscompleted(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                           
                        0 =>'id',
                        1 =>'customeremail',
                        2 =>'customername',
                        3 =>'totalproducts',
                        4 =>'totalcost',
                        5 =>'paymentmethod',
                        6 =>'status',
                        7 =>'action',
                         );

        $totalData = Order::where('company_id',$companyid)->where('status','completed')->orderBy('id','desc')->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir,'Heleoeoeoe demo auth',count($totalData));
            
        if(empty($request->input('search.value')))
        {            
            $posts = Order::where('company_id',$companyid)
                            ->where('status','completed')    
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd(count($posts),"If Condiction in demo add");
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Order::where('company_id',$companyid)
                             ->where('status','completed')   
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('customer_email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Order::where('company_id',$companyid)
                             ->where('status','completed')   
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('customer_email', 'LIKE',"%{$search}%")
                             ->count();

                         // dd($totalFiltered);
                         // dd(count($posts),$totalFiltered,"else Condiction in demo add");

        }

   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {


                                if($post->status == "completed")
                                {
                                     $btn_class = 'primary'; 
                                }
                                elseif($post->status == "cancelled")
                                {
                                    $btn_class = 'danger'; 
                                }
                                elseif($post->status == "processing")
                                {
                                    $btn_class = 'info'; 
                                }
                                else
                                {
                                    $btn_class = 'default'; 
                                }
                           
          
                                            
                $nestedData['id'] ="#".$post->id;
                $nestedData['customeremail'] =$post->customer_email;
                $nestedData['customername']=$post->customer_firstname." ".$post->customer_lastname;
                $nestedData['totalproducts']=array_sum($post->quantities);
                $nestedData['totalcost']=$post->subtotal;
                $nestedData['paymentmethod']=$post->method;
                $nestedData['status']="<button class='btn btn-".$btn_class." "."btn-xs'>".ucfirst($post->status)."</button>";

                 $nestedData['action']="<a href='orders/".$post->id."' class='btn btn-primary btn-xs'><i class='fa fa-check'></i>ViewDetails</a>";
                                    


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



       echo json_encode($json_data,JSON_UNESCAPED_UNICODE ); 
        
    }   





           public function allPostscancelde(Request $request)
    {   
        $companyid = get_company_id();
        
        $columns = array( 
                           
                        0 =>'id',
                        1 =>'customeremail',
                        2 =>'customername',
                        3 =>'totalproducts',
                        4 =>'totalcost',
                        5 =>'paymentmethod',
                        6 =>'status',
                        7 =>'action',
                         );

        $totalData = Order::where('company_id',$companyid)->where('status','cancelled')->orderBy('id','desc')->count();

        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');



        // dd($limit,$start,$order,$dir,'Heleoeoeoe demo auth',count($totalData));
            
        if(empty($request->input('search.value')))
        {            
            $posts = Order::where('company_id',$companyid)
                            ->where('status','cancelled')    
                        ->offset($start)
                         ->limit($limit)
                         ->orderBy($order,$dir)
                         ->get();

                         // dd(count($posts),"If Condiction in demo add");
        }
        else {

            $search = $request->input('search.value'); 
            // dd($search);

            $posts =  Order::where('company_id',$companyid)
                             ->where('status','cancelled')   
                            ->where('id','LIKE',"%{$search}%")
                            ->orWhere('customer_email', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();


            $totalFiltered = Order::where('company_id',$companyid)
                             ->where('status','cancelled')   
                            ->orwhere('id','LIKE',"%{$search}%")
                             ->orWhere('customer_email', 'LIKE',"%{$search}%")
                             ->count();

                         // dd($totalFiltered);
                         // dd(count($posts),$totalFiltered,"else Condiction in demo add");

        }

   
        $data = array();
        if(!empty($posts))
        { $i=1;
            foreach ($posts as $post)
            {


                                if($post->status == "completed")
                                {
                                     $btn_class = 'primary'; 
                                }
                                elseif($post->status == "cancelled")
                                {
                                    $btn_class = 'danger'; 
                                }
                                elseif($post->status == "processing")
                                {
                                    $btn_class = 'info'; 
                                }
                                else
                                {
                                    $btn_class = 'default'; 
                                }
                           
          
                                            
                $nestedData['id'] ="#".$post->id;
                $nestedData['customeremail'] =$post->customer_email;
                $nestedData['customername']=$post->customer_firstname." ".$post->customer_lastname;
                $nestedData['totalproducts']=array_sum($post->quantities);
                $nestedData['totalcost']=$post->subtotal;
                $nestedData['paymentmethod']=$post->method;
                $nestedData['status']="<button class='btn btn-".$btn_class." "."btn-xs'>".ucfirst($post->status)."</button>";

                 $nestedData['action']="<a href='orders/".$post->id."' class='btn btn-primary btn-xs'><i class='fa fa-check'></i>ViewDetails</a>";
                                    


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



       echo json_encode($json_data,JSON_UNESCAPED_UNICODE ); 
        
    }   








    






      


}
