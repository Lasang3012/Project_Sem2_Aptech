<?php

namespace App\Http\Controllers;

use App\Rules\Captcha;
use Carbon\Carbon;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\DocBlock\Tags\InvalidTag;

class AuthController extends Controller
{





    public function register_auth(){
               return view('admin.custome_auth.register');
     }
     public function  login_auth(){
         if (Session::get('adminsession')){
             return \redirect('/dashbord');
         }else{
             $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
             $admin = Admin::whereDate('verify_at','<',$today)->where('verify_email','=',null)->delete();
             return view('admin.custome_auth.login_auth');
         }


     }

     public function verify($email , $token){
         $start_date = Carbon::now('Asia/Ho_Chi_Minh')->subDays(1)->format('Y-m-d H:i:s');
         $end_date = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');


         $admin = Admin::where('admin_email',$email)->where('admin_token',$token)->whereBetween('created_at',[$start_date,$end_date])->first();
         $admin->verify_email = 1;
         $admin->save();

         return view('admin.custome_auth.login_auth');
     }

     public function register_admin(Request $request){
          $this->validation($request);
          $data = $request->all();
         $token_random = Str::random();
         $tomorrow = Carbon::now('Asia/Ho_Chi_Minh')->addDay()->format('Y-m-d H:i:s');
          $admin = new Admin();
          $admin->admin_name = $data['admin_name'];
         $admin->admin_email = $data['admin_email'];
         $admin->admin_phone = $data['admin_phone'];
         $admin->admin_password = md5($data['admin_password']);
         date_default_timezone_set('Asia/Ho_Chi_Minh');
         $admin->admin_token = $token_random;
         $admin->created_at = now();
         $admin->verify_at = $tomorrow;
         $admin->save();

         $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');

         $title_email = 'Xác thưc đăng ký tài khoản'.' '.$now;
         $to_email = $data['admin_email'];

         $link_reset_pass = url('/verify/'.$to_email.'/'.$token_random);
//         $admin->roles()->attach(Roles::where('name','user')->first());
         $data = array(
             'title' => $title_email,
             'body' => $link_reset_pass,
             'email' => $data['admin_email']

         );
         Mail::send('admin.custome_auth.veryfiRegister',['data'=>$data],function ($message) use ($title_email,$data){
             $message->to($data['email'])->subject($title_email);
             $message->from($data['email'],$title_email);
         });
         return redirect()->back()->with('message','Gửi email thành công ,vui lòng vào email để kick hoat tài khoản');
//         return redirect('/register-auth')->with('message','Đăng ký thành công');
     }

     public function validation($request){
        return $this->validate($request,[
             'admin_name' => 'required|max:50',
            'admin_phone' => 'required|max:11',
            'admin_email' => 'required|unique:tbl_admin,admin_email|email|max:100',
            'admin_password' => 'required|max:30',
        ]);
     }

     public function login_admin(Request $request){
             $this->validate($request,[
                 'admin_email' => 'required|email|max:100',
                 'admin_password' => 'required|max:30',
                 'g-recaptcha-response' => new Captcha(),
             ]);
         $verifi_e = '';
//dd(Auth::guard('admin')->attempt(['admin_email' => $request->admin_email , 'admin_password' => $request->admin_password])&& Auth::guard('admin')->user()->hasRole('SuperAdmin'));
         $admin = Admin::where('admin_email',$request->admin_email)->where('verify_email',1)->first();
         $session = $admin->admin_email;
         $verifi_e = $admin->verify_email;

         if (!empty($admin)){
             Session::put('adminsession',$session);
         }




          if (Auth::guard('admin')->attempt(['admin_email' => $request->admin_email , 'admin_password' => $request->admin_password]) && Auth::guard('admin')->user()->hasRole('SuperAdmin') && $verifi_e != null){
               return redirect('/dashbord');
          }
          elseif(Auth::guard('admin')->attempt(['admin_email' => $request->admin_email , 'admin_password' => $request->admin_password]) && Auth::guard('admin')->user()->hasRole('admin')&& $verifi_e   ){
              return redirect('/dashbord');
          }

          elseif(Auth::guard('admin')->attempt(['admin_email' => $request->admin_email , 'admin_password' => $request->admin_password]) && Auth::guard('admin')->user()->hasRole('user') && $verifi_e){
              return redirect('/dashbord');
          }
          else{
              return redirect('/login-auth')->with('message','Sai thông tin đăng nhập hoặc bạn không có quyền truy cập,hoac bạn chưa active tài khoản');
          }

     }

     public function log_out(){
         Auth::guard('admin')->logout();
         Session::flush();


         return redirect('/login-auth')->with('message','Đăng xuất thành công');
     }

     public function forget_password(){
          return view('admin.custome_auth.forgot');
     }


}
