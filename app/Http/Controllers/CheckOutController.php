<?php

namespace App\Http\Controllers;


use App\Models\CategoryPost;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\visitor;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use App\Models\City;
use App\Models\Province;
use App\Models\Wards;
use App\Models\shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Feeship;
use Illuminate\Support\Str;

class CheckOutController extends Controller
{

    public function calculate_fee(Request $request){
        $data = $request->all();
        if ($data['matp']){
            $fee_ship = Feeship::where('fee_matp' , $data['matp'])->where('fee_maqh',$data['maqh'])->where('fee_xaid',$data['xaid'])->get();
            if ($fee_ship){
                $cout_fee_ship = $fee_ship->count();
                if ($cout_fee_ship > 0){
                    foreach ($fee_ship as $fee){
                        Session::put('fee',$fee->fee_feeship);
                        Session::save();
                    }
                }else{
                        Session::put('fee',200000);
                        Session::save();
                }
            }

        }


    }

    public function select_delivery_home(Request $request){
        $data = $request->all();
        if($data['action']){
            $output = '';
            if($data['action']=="city"){
                $select_province = Province::where('matp',$data['ma_id'])->orderby('maqh','ASC')->get();
                $output.='<option>---Chọn quận huyện---</option>';
                foreach($select_province as $key => $province){
                    $output.='<option value="'.$province->maqh.'">'.$province->name_quanhuyen.'</option>';
                }

            }else{

                $select_wards = Wards::where('maqh',$data['ma_id'])->orderby('xaid','ASC')->get();
                $output.='<option>---Chọn xã phường---</option>';
                foreach($select_wards as $key => $ward){
                    $output.='<option value="'.$ward->xaid.'">'.$ward->name_xaphuong.'</option>';
                }
            }
            echo $output;
        }
    }
           public function unset_fee(){
                 Session::forget('fee');
                 return redirect()->back();
           }

         public function confrim_order(Request $request){
              $data = $request->all();

              if ($data['order_coupon'] != 'no'){
                  $coupon = Coupon::where('coupon_code',$data['order_coupon'])->first();
                      $coupon->coupon_used = $coupon->coupon_used . ',' . Session::get('customer_id');
                      $coupon->coupon_time = $coupon->coupon_time - 1;
                      $coupon_mail = $coupon->coupon_code;
                      $coupon_number = $coupon->coupon_number;
                      $coupon_condition = $coupon->coupon_condition;
                      $coupon->save();
              }else{
                    $coupon_mail = 'Không có';
                  $coupon_number = 0;
                  $coupon_condition = 0;
              }


              $shipping = new shipping();
              $shipping->shipping_name = $data['shipping_name'];
             $shipping->shipping_address = $data['shipping_address'];
             $shipping->shipping_phone = $data['shipping_phone'];
             $shipping->shipping_email = $data['shipping_email'];
             $shipping->shipping_method = $data['payment_select'];
             $shipping->shipping_note = $data['shipping_note'];
             $shipping->save();
             $shipping_id = $shipping->shipping_id;

             $checkout_code = substr(md5(microtime()),rand(0,26),5);


             $order_today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
             $order_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
             $order = new Order();
             $order->customer_id = Session::get('customer_id');
             $order->shipping_id = $shipping_id;
             $order->order_status = 1;
             $order->order_code = $checkout_code;
//             date_default_timezone_set('Asia/Ho_Chi_Minh');
             $order->created_at = $order_today;

             $order->order_date = $order_date;
             $order->save();

             $customer = Customer::find(Session::get('customer_id'));
             $customer_order = Order::where('customer_id',Session::get('customer_id'))->get();
             $count_customer = $customer_order->count();
             if ($count_customer > 3){
                 $customer->customer_vip = 1;
                 $customer->save();

             }

             if (Session::get('cart')){
                 foreach (Session::get('cart') as $key => $cart){
                 $orderDetails = new OrderDetails();
                 $orderDetails->order_code = $checkout_code;
                 $orderDetails->product_id =  $cart['product_id'];
                 $orderDetails->product_name = $cart['product_name'];
                 $orderDetails->product_price = $cart['product_price'];
                 $orderDetails->product_sales_quantity = $cart['product_qty'];
                 $orderDetails->product_coupon  = $data['order_coupon'];
                 $orderDetails->product_feeship = $data['order_fee'];
                 $orderDetails->save();
                 }

             }

             //send mail confirm
             $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

             $title_mail = "Đơn hàng xác nhận ngày".' '.$now;

             $customer_id = Customer::find(Session::get('customer_id'));

             $data['email'][] = $customer_id->customer_email;
             //lay gio hang
             if(Session::get('cart')==true){

                 foreach(Session::get('cart') as $key => $cart_mail){

                     $cart_array[] = array(
                         'product_name' => $cart_mail['product_name'],
                         'product_price' => $cart_mail['product_price'],
                         'product_qty' => $cart_mail['product_qty']
                     );

                 }

             }
             //lay shipping
             if(Session::get('fee')==true){
                 $fee = Session::get('fee');
             }else{
                 $fee = '25k';
             }

             $shipping_array = array(
                 'fee' =>  $fee,
                 'customer_name' => $customer->customer_name,
                 'shipping_name' => $data['shipping_name'],
                 'shipping_email' => $data['shipping_email'],
                 'shipping_phone' => $data['shipping_phone'],
                 'shipping_address' => $data['shipping_address'],
                 'shipping_notes' => $data['shipping_note'],
                 'shipping_method' => $data['payment_select']

             );
             //lay ma giam gia, lay coupon code
             $ordercode_mail = array(
                 'coupon_code' => $coupon_mail,
                 'coupon_number' => $coupon_number,
                 'coupon_condition' => $coupon_condition,
                 'order_code' => $checkout_code,
             );
             Session::forget('fee');
             Session::forget('cart');
             Session::forget('coupon');

             Mail::send('pages.mail.mail_order',  ['cart_array'=>$cart_array, 'shipping_array'=>$shipping_array ,'code'=>$ordercode_mail] , function($message) use ($title_mail,$data){
                 $message->to($data['email'])->subject($title_mail);//send this mail with subject
                 $message->from($data['email'],$title_mail);//send from this mail

             });



         }




    public function login_checkout(){
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();

        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
         return view('pages.CheckOut.login')->with('category',$category)->with('brand',$brand)->with('category_post',$category_post);
    }
    public function add_customer(Request  $request){
        $tomorrow = Carbon::now('Asia/Ho_Chi_Minh')->addDay()->format('Y-m-d H:i:s');
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $token_random = Str::random();

        $data = array();
          $data['customer_name'] = $request->reg_lname;
          $data['customer_email'] = $request->reg_email;
          $data['customer_password'] = md5($request->pass_confirmation);
          $data['customer_phone'] = $request->reg_phone;
          $confrinpass = $request->pass;

          $data['created_at'] = $now;
          $data['verify_at'] = $tomorrow;
          $data['customer_token'] = $token_random;
          $request->validate([
              'reg_email' => 'required|unique:tbl_customer,customer_email|max:50',

          ]);
          $customer_id = DB::table('tbl_customer')->insertGetId($data);
        $title_email = 'Xác thưc đăng ký tài khoản'.' '.$now;
        $to_email = $data['customer_email'];
        $link_verify = url('/verify_customer/'.$to_email.'/'.$token_random);
        $data = array(
            'title' => $title_email,
            'body' => $link_verify,
            'email' => $data['customer_email']
        );
        Mail::send('pages.Mail.veryfiRegister_customer',['data'=>$data],function ($message) use ($title_email,$data){
            $message->to($data['email'])->subject($title_email);
            $message->from($data['email'],$title_email);
        });

//          Session::put('customer_id',$customer_id);
//          Session::put('customer_name', $request->reg_lname);
          return redirect()->back()->with('message','Đăng kí tài khoản thành công,vui lòng vào email đễ xác thưc tài khoản');

    }

    public function verify_customer($email,$token){
        $start_date = Carbon::now('Asia/Ho_Chi_Minh')->subDays(1)->format('Y-m-d H:i:s');
        $end_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');


        $customer = Customer::where('customer_email',$email)->where('customer_token',$token)->whereBetween('created_at',[$start_date,$end_date])->first();

        if ($customer == null){
            return view('errors.404');
        }else{
            $customer->verify_email = 1;
            $customer->save();
        }
                  Session::put('customer_id',$customer->customer_id);
          Session::put('customer_name', $customer->customer_name);
            return redirect('checkout');
    }

    public function checkout(){
        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();


        $for_export_product = DB::table('tbl_product')->where('product_status', '1')->orderBy('product_id', 'asc')->limit(5)->get();
        $city = City::orderby('matp','ASC')->get();
        if (Session::get('cart')){

            return view('pages.check_out')->with('category',$category)->with('brand',$brand)->with('city',$city)->with('category_post',$category_post);
        }else{
            return view('pages.cart.cart_ajax')->with(compact('for_export_product','category_post'));
        }

    }






    public function logout_checkout(){
        Session::forget('customer_id');
        Session::forget('coupon');
        Session::forget('fee');

        Session::forget('coupon');
        return Redirect::to('/');
}

    public function login_customer(Request $request){

        $user_ip_address = $request->ip();
         $email = $request->login_email;
         $pass = md5($request->login_pass);
         $result = DB::table('tbl_customer')->where('customer_email',$email)->where('customer_password',$pass)->where('verify_email',1)->first();
         $visitor_current = visitor::where('ip_address',$user_ip_address)->get();
         $visitor_count = $visitor_current->count();
         if ($visitor_count < 1){
              $visitor = new visitor();
              $visitor->ip_address = $user_ip_address;
              $visitor->date_visitors = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
              $visitor->save();
         }

         if (Session::get('coupon') == true){
             Session::forget('coupon');
         }
             if ($result){

                 Session::put('customer_id',$result->customer_id);
                 return Redirect::to('/checkout');
             }else{

                 return Redirect::to('/login-checkout')->with('message','Tài khoản hoặc mật khẩu không chính xác vui lòng kiểm trả lại  !!!');

             }





    }


    // function backend
    public function  AuthLogin(){
        $admin_id = Session::get('admin_id');
        if ($admin_id){
            return Redirect::to('dashbord');
        }else{
            return Redirect::to('admin')->send();
        }
    }

}
