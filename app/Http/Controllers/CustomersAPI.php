<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\SocialCustomer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class CustomersAPI extends Controller
{
    public function login_customer_google(){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        return Socialite::driver('google') ->redirect();
    }
    public function callback_customer_google(){
        config(['services.google.redirect' => env('GOOGLE_CLIENT_URL')]);
        $user = Socialite::driver('google')->stateless()->user();
           $authUser = $this->findOrCreateCustomer($user,'google');
           if ($authUser){
               $account_name = Customer::where('customer_id',$authUser->user)->first();
               Session::put('customer_id',$account_name->customer_id);
               Session::put('customer_picture',$account_name->customer_picture);
               Session::put('customer_name',$account_name->customer_name);
           }elseif($customer_new){
               $account_name = Customer::where('customer_id',$authUser->user)->first();
               Session::put('customer_id',$account_name->customer_id);
               Session::put('customer_picture',$account_name->customer_picture);
               Session::put('customer_name',$account_name->customer_name);
           }
           return redirect('/trang-chu');
    }
    public function findOrCreateCustomer($user,$provider){
//        dd(  $user);

        $authUser = SocialCustomer::where('provider_user_id', $user->id)->first();
        if($authUser){
            return $authUser;
        }else{
            $customer_new = new SocialCustomer([
                'provider_user_id' => $user->id,
                'provider_user_email' => $user->email,
                'provider' => strtoupper($provider)
            ]);

            $customer = Customer::where('customer_email',$user->email)->first();

            if(!$customer){


                $customer =  Customer::create([
                    'customer_name' => $user->name,
                    'customer_picture' => $user->avatar,
                    'customer_email' => $user->email,
                    'customer_password' => '',
                    'customer_phone' => '',
                    'verify_email' => 1,
                    'verify_at' => Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s')


                ]);

            }

            $customer_new->customer()->associate($customer);

            $customer_new->save();
            return $customer_new;
        }
    }

    public function login_customer_facebook(){
        config(['services.facebook.redirect' => env('FACEBOOK_APP_CALLBACK_URL')]);
        return Socialite::driver('facebook') ->redirect();
    }

    public function callback_facebook(){
        config(['services.facebook.redirect' => env('FACEBOOK_APP_CALLBACK_URL')]);
        $provider = Socialite::driver('facebook')->user();
        dd($provider);
    }
}
