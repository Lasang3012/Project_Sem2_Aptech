<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\CategoryPost;
use App\Models\Coupon;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MailController extends Controller
{
    public function send_coupon_vip($coupon_time ,$coupon_condition, $coupon_number ,$coupon_code){
            $customer_vip = Customer::where('customer_vip',1)->get();
            $coupon = Coupon::where('coupon_code',$coupon_code)->first();
            $start_coupon = $coupon->coupon_date_start;
            $end_coupon = $coupon->coupon_date_end;
            $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

            $title_mail = "Mã khuyến mãi ngày".' '.$now;

            $data = [];
            foreach ($customer_vip as $vip){
                $data['email'][] = $vip->customer_email;
            }
//            dd($data);
        $coupon = array(

            'start_coupon' =>$start_coupon,
            'end_coupon' =>$end_coupon,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code
        );
        Mail::send('pages.sendMail_coupon_vip',['coupon' => $coupon],function ($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });
            return redirect()->back()->with('message','Gửi mã khuyến mãi thành công');
    }


    public function send_coupon($coupon_time ,$coupon_condition , $coupon_number ,$coupon_code){
        $customer_vip = Customer::where('customer_vip','=',NULL)->get();
        $coupon = Coupon::where('coupon_code',$coupon_code)->first();
        $start_coupon = $coupon->coupon_date_start;
        $end_coupon = $coupon->coupon_date_end;
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

        $title_mail = "Mã khuyến mãi ngày".' '.$now;

        $data = [];
        foreach ($customer_vip as $normal){
            $data['email'][] = $normal->customer_email;
        }
//            dd($data);
        $coupon = array(

            'start_coupon' =>$start_coupon,
            'end_coupon' =>$end_coupon,
            'coupon_time' => $coupon_time,
            'coupon_condition' => $coupon_condition,
            'coupon_number' => $coupon_number,
            'coupon_code' => $coupon_code
        );
        Mail::send('pages.sendMail_coupon',['coupon' => $coupon],function ($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);
            $message->from($data['email'],$title_mail);
        });
        return redirect()->back()->with('message','Gửi mã khuyến mãi thành công');
    }

    public function mail_example(){
        return view('pages.sendMail_coupon');
    }
    public function quen_mat_khau(){
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();

        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
          return view('pages.CheckOut.forget_pass')->with('category',$category)->with('brand',$brand)->with('category_post',$category_post);
    }

    public function recover_password(Request $request){
          $data = $request->all();

          $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

          $title_email = 'Lấy lại mật khẩu'.' '.$now;
          $customer = Customer::where('customer_email',$data['email_account'])->get();
          foreach ($customer as $value){
              $customer_id = $value->customer_id;
          }
          if ($customer){
              $count_customer = $customer->count();
              if ($count_customer == 0){
                   return redirect()->back()->with('error','Email chưa được đăng kí để khôi phục');
              }else{
                  $token_random = Str::random();
                  $customer =Customer::find($customer_id);
                  $customer->customer_token = $token_random;
                  $customer->save();
                  $to_email = $data['email_account'];
                  $link_reset_pass = url('/update-new-pass?email='.$to_email.'&token='.$token_random);

                  $data = array(
                      "name"=> $title_email,
                      "body"=>$link_reset_pass,
                      "email"=> $data['email_account']
                  );

                  Mail::send('pages.CheckOut.forget_pass_notify',['data'=>$data],function ($message) use ($title_email,$data){
                      $message->to($data['email'])->subject($title_email);
                      $message->from($data['email'],$title_email);
                  });
                  return redirect()->back()->with('message','Gửi email thành công ,vui lòng vào email để reset password');
              }
          }
    }

    public function update_new_pass(Request $request){

        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();

        $category = DB::table('tbl_category_product')->where('category_status','1')->orderBy('category_id','desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status','1')->orderBy('brand_id','desc')->get();
        return view('pages.CheckOut.new_pass')->with('category',$category)->with('brand',$brand)->with('category_post',$category_post);
    }

    public function reset_new_password(Request $request){
          $data = $request->all();
          $token_random = Str::random();
          $customer = Customer::where('customer_email',$data['email'])->where('customer_token',$data['token'])->get();
          $count = $customer->count();
          if ($count > 0){
                foreach ($customer as $key => $cus){
                    $customer_id = $cus->customer_id;
                }
                $reset = Customer::find($customer_id);
                $reset->customer_password = md5($data['password_account']);
                $reset->customer_token = $token_random;
                $reset->save();
                return redirect('/login-checkout')->with('message','Mật khẩu cập nhập thành công');
          }else{
              return redirect('/quen-mat-khau')->with('error','Vui lòng nhập lại email !!');

          }
    }
    public function forget_password(){

        return view('admin.custome_auth.forgot');
    }

    public function recover_password_admin(Request $request){
        $data = $request->all();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

        $title_email = 'Lấy lại mật khẩu'.' '.$now;
        $admin = Admin::where('admin_email',$data['email_forget'])->get();
        foreach ($admin as $value){
            $admin_id = $value->admin_id;
        }
        if ($admin){
            $count_admin = $admin->count();
            if ($count_admin == 0){
                return redirect()->back()->with('message','Email chưa được đăng kí để khôi phục');
            }else{
                $token_random = Str::random();
                $admin = Admin::find($admin_id);
                $admin->admin_token = $token_random;
                $admin->save();
                $to_email = $data['email_forget'];
                $link_reset_pass = url('/update-new-pass-admin?email='.$to_email.'&token='.$token_random);

                $data = array(
                    "name"=> $title_email,
                    "body"=>$link_reset_pass,
                    "email"=> $data['email_forget']
                );

                Mail::send('pages.CheckOut.forget_pass_notify',['data'=>$data],function ($message) use ($title_email,$data){
                    $message->to($data['email'])->subject($title_email);
                    $message->from($data['email'],$title_email);
                });
                return redirect()->back()->with('message','Gửi email thành công ,vui lòng vào email để reset password');
            }
        }
    }

    public function update_new_pass_admin(Request $request){

        return view('admin.custome_auth.new_pass');
    }

    public function reset_new_password_admin(Request $request){
        $data = $request->all();
        $token_random = Str::random();
        $admin = Admin::where('admin_email',$data['email'])->where('admin_token',$data['token'])->first();
        $admin_id = $admin->admin_id;

        $count = $admin->count();
        if ($count > 0){

            $reset = Admin::find($admin_id);

            $reset->admin_password = md5($data['password_account']);
            $reset->admin_token = $token_random;
            $reset->save();
            return redirect('/login-auth')->with('message','Mật khẩu cập nhập thành công');
        }else{
            return redirect('/forget-password')->with('error','Vui lòng nhập lại email !!');

        }
    }
}
