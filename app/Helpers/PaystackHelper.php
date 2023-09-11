<?php 
namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Request;
use Unicodeveloper\Paystack\Facades\Paystack;
use Illuminate\Support\Facades\Redirect;
class PaystackHelper {
   
    public static function payApi($fields){
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('PAYSTACK_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.paystack.co/transaction/initialize', $fields);

        $data = $response->json();

        // Redirect to Paystack payment gateway
        return redirect($data['data']['authorization_url']);
    
    }


    /**
     * Redirect the User to Paystack Payment Page
     * @return Url
     */
    public static function redirectToGateway()
    {
        try{
            return Paystack::getAuthorizationUrl()->redirectNow();
        }catch(\Exception $e) {
            return Redirect::back()->withMessage(['msg'=>'The paystack token has expired. Please refresh the page and try again.', 'type'=>'error']);
        }        
    }

    /**
     * Obtain Paystack payment information
     * @return void
     */
    public static function  handleGatewayCallback()
    {
        $paymentDetails = Paystack::getPaymentData();

        return $paymentDetails;
        // Now you have the payment details,
        // you can store the authorization_code in your db to allow for recurrent subscriptions
        // you can then redirect or do whatever you want
    }

}