<?php

namespace App\Http\Controllers;

use App\Helpers\PaystackHelper;
use App\Models\Listing;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Http;
use Unicodeveloper\Paystack\Facades\Paystack;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Transaction;
use Illuminate\Support\Carbon;

class ListingController extends Controller
{
   

    public function index(Request $request){
        $listings = Listing::where('is_active', true)->with('tags')->latest()->get();
        $tags = Tag::orderBy('name')->get();
        if($request->has('s')){
            $query = strtolower($request->get('s'));
            $listings = $listings->filter(function($listing) use ($query) {
                if(Str::contains(strtolower($listing->title), $query)){
                    return true;
                }
                if(str::contains(strtolower($listing->company), $query)){
                    return true;
                }
                if(Str::contains(strtolower($listing->location), $query)){
                    return true;
                }
                return false;
            });
        }

        if($request->has('tag')){
            $tag = $request->get('tag');
            $listings = $listings->filter(function($listing) use($tag){
                return $listing->tags->contains('slug', $tag);
            });
            
        }
        return view('Listings.index', ['listings'=>$listings, 'tags'=>$tags]);
    }


    public function show(Listing $listing, Request $request){
       return view('Listings.show', ['listing'=>$listing]);

    }

    public function apply(Listing $listing, Request $request){
        //recording button press from the visitor
        $listing->clicks()->create([
                'user_agent' =>  $request->userAgent(),
                'ip_address' => $request->ip(),
        ]);
        return redirect()->to($listing->apply_link);
 
     }

     public function create(User $user){
        return view('Listings.create');
     }

     public function store(Request $request){
      
            $validation = [
                    'title' => 'required',
                    'company' => 'required',
                    'logo' => 'file|max:2048|mimes:png,jpg,jpeg',
                    'location' => 'required',
                    'apply_link' => 'required|url',
                    'content' => 'required',
                   
            ];
           
            $request->validate($validation);

            if(Auth::check()){
                $user = Auth::user();
            }
            // check if user exist, if not create new user

             try {
                $mytrancamount = 4000;
                $amount = 40000 * 10; //4000
                $extrafee = 12000 * 10;
                if($request->filled('is_highlighted')){
                    $amount += $extrafee;
                }
                $orderid = '#ORD'.rand(1111,9999);
              
                if($request->hasFile('logo')){
                    $file = $request->file('logo');
                    $logo = $request->company . rand(11111,99999) .'.'. $file->extension();
                    $folder = 'logos';
                    $file->storeAs($folder, $logo);
                }else{
                    $logo = null;
                }
                // $md = new \ParsedownExtra();
                //create listing
                $listing = $user->listings()->create([
                            'title' => $request->title,
                            'slug' => Str::slug($request->title) . '-' . rand(1111,9999),
                            'company' => $request->company,
                            'logo' => $logo,
                            'location' => $request->location,
                            'apply_link' => $request->apply_link,
                            'content' => $request->content, 
                            'is_highlighted' => $request->filled('is_highlighted'),
                            'is_active' => false,
                            'created_at' => Carbon::now()         
                ]);
                $reference = hash('sha256', Str::random(16));
                  // add to transaction table
                  $user->transactions()->create([
                    'amount' => $mytrancamount,
                    'reference' => $reference,
                    'orderID' => $orderid,
                    'created_at' => Carbon::now(),
                    'listing_id' => $listing->id,
                    'status' => 'pending'
                ]);

                foreach(explode(',',$request->tags) as $requestTag){
                    $tag = Tag::firstOrCreate([
                            'slug' => Str::slug(trim($requestTag))
                    ],[
                        'name' => ucwords(trim($requestTag))
                    ]);

                    $tag->listings()->attach($listing->id);
                }
                // Dynamic callback URL
                $callbackUrl = route('return.pay');
                $data = array(
                        "amount" => $amount,
                        'email' => $user->email,
                        'reference' =>$reference,
                        'orderID' => $orderid,
                        'listing_id' => $listing->id,
                        'callback_url' => $callbackUrl,
                );
                return Paystack::getAuthorizationUrl($data)->redirectNow();

              
             } catch (\Exception $e) {
                return Redirect::back()->withErrors($e->getMessage())->withInput();  
             }
           

     }  
     
    public function returnPay(){

        $response =  paystack()->getPaymentData();
        if($response['data']['status'] == true){
            $trans = Transaction::where('reference', $response['data']['reference'])->first();
            if($trans){
                $trans->update(['status'=>'paid']);
                Listing::where('id', $trans->listing_id)->update(['is_active'=>true]);
                return redirect()->intended(route('dashboard'))->with('success', 'You have succeffully made payment and completed your acount for listing of jobs, you can now list more jobs!');
            }else{
                return redirect()->route('listing.payment.error')->with('warning', 'An error occured while making payment, please do not reintiated the payment, contact support team for help!');
            }
            
            
        }else{
            //logout
            return redirect()->route('listing.payment.error')->with('warning', 'An error occured while making payment, please do not reintiated the payment, contact support team for help!');
        }
        
        
    }


    public function paymentError(){
        return view('Listings.payment-error');
    }

}   
