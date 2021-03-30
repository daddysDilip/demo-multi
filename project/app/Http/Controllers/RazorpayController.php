<?php
# Copy the code from below to that controller file located at app/Http/Controllers/RazorpayController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Razorpay\Api as Api;

use App\CompanyTransection;

class RazorpayController extends Controller {

    public function pay() {
		return view('pay');
    }

    public function dopayment(Request $request) {
        //Input items of form
        $input = $request->all();
       
	     $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
        //Fetch payment information by razorpay_payment_id
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
         $success = false;
            $error = '';
        if(count($input)  && !empty($input['razorpay_payment_id'])) {
			
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount'=>$payment['amount'])); 
				
				  if ($response === false) {
                    $success = false;
                    $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$response;
                } else {
					
                   // $response_array = json_decode($response, true);
				   
                   /*echo "<pre>"; print_r($response); echo "</pre>";
                   echo "<pre>"; print_r($response['notes']); echo "</pre>";
				   
				   echo $response['notes']['soolegal_order_id'];
				   
				   exit;*/
				   
                        //Check success response
                        if (isset($response['error']) === false) {
                            $success = true;
                        } else {
                            $success = false;
                            if (!empty($response['error']['code'])) {
                                $error = $response['error']['code'].':'.$response['error']['description'];
                            } else {
                                $error = 'RAZORPAY_ERROR:Invalid Response <br/>'.$response;
                            }
                        }
                }
				
				

            } catch (\Exception $e) {
                return  $e->getMessage();
                \Session::put('error',$e->getMessage());
                return redirect()->back();
            }

            // Do something here for store payment details in database...
        }
		  $CompanyTransection = new CompanyTransection();

			if ($success === true) {
			$transection_data = json_encode($response);

			$transe_data = array(
			 'CompanyId'=> $response['notes']['soolegal_order_id'],
			 'transection_id'=> $response['id'],
			 'transection_data'=> $transection_data,
			 'ErrorCode'=> $response['error_code'],
			 'description'=> $response['error_description'],
			 'Status'=>1,
			 'created_at'=> date('Y-m-d H:i:s'),
			 );
			 
			$CompanyTransection->fill( $transe_data );
		    $CompanyTransection->save();
			$lastid = $CompanyTransection->id;
			
			$result= array(
			 'transection_id' => $lastid,
			 'status' =>  'ok'
			);

			
			}else{
				
				$transection_data = json_encode($response);

				$transe_data = array(
				 'CompanyId'=> $response['notes']['soolegal_order_id'],
				 'transection_id'=> '',
				 'transection_data'=> $transection_data,
				 'ErrorCode'=> $response['error']['code'],
				 'description'=> $response['error']['description'],
				 'Status'=> 0,
				 'created_at'=> date('Y-m-d H:i:s'),
				 );
				 
		    $CompanyTransection->fill( $transe_data );
		    $CompanyTransection->save();
			$lastid = $CompanyTransection->id;
				$result= array(
			 'transection_id' => $lastid,
			 'status' =>  'failed'
			); 
			}
			return Response()->json(compact('result'));
      //  print_r($result);
        //exit;
    }

}