<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\visitor;
use Illuminate\Support\Carbon;
use App\Models\statistical;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

// giống return trả về 1 kết quả về 1 trang gì đó
use Illuminate\Support\Facades\Session;

// thư viện session
//session_start();

class AdminController extends Controller
{

    public function profile($id){
        $admin = Admin::find($id);

        return view('admin.Edit_user')->with(compact('admin'));
    }

    public function update_profile(Request $request){
         $data = $request->all();
         $admin = Admin::find($data['admin_id']);
         $admin->admin_email = $data['admin_email'];
         $admin->admin_address = $data['admin_address'];
         $admin->admin_name = $data['admin_name'];
         $admin->admin_phone = $data['admin_phone'];
         $admin->admin_password = md5($data['pass']);



        $get_image = $request->file('admin_image');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_image_name));
            $new_image = $name_image . rand(0, 999999999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/upload/admin', $new_image);
            $data['admin_image'] = $new_image;
            $admin->admin_image = $data['admin_image'];
            $admin->save();
            return \redirect()->back()->with('message','Thay đổi thông tin thành công');

        }

    }

    public function erorr()
    {
        return view('error.404');
    }

    public function show_dashbord(Request $request)
    {
         $user_ip_address = $request->ip();
        $early_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString(); // đầu tháng trước

        $end_of_last_month = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString(); // cuối tháng trước

        $early_this_month = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();// đầu tháng này

        $ones_year = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString(); // 1 năm

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString(); // hiện tại

        //total last month : Tống số tháng trước
        $visitor_last_month = visitor::whereBetween('date_visitors',[$early_last_month,$end_of_last_month])->get();
        $visitor_last_month_count = $visitor_last_month->count();

        //total this month : Tổng số tháng này
        $visitor_this_month = visitor::whereBetween('date_visitors',[$early_this_month,$now])->get();
        $visitor_this_month_count = $visitor_this_month->count();

        //total  in one year : Tổng 1 năm
        $visitor_in_one_year = visitor::whereBetween('date_visitors',[$ones_year,$now])->get();
        $visitor_in_one_year_count = $visitor_in_one_year->count();

        // vistor all
        $vistors = visitor::all();
        $vistor_all = $vistors->count();

        // visitor online
        $visitor_current = visitor::where('ip_address',$user_ip_address)->get();
        $visitor_count = $visitor_current->count();

        $product_donut = Product::all()->count();
        $post_donut = Post::all()->count();
        $order_donut = Order::all()->count();
        $customer_donut = Customer::all()->count();

        $product_view = Product::orderBy('product_view','DESC')->take(20)->get();
        $post_view = Post::orderBy('post_view','DESC')->take(20)->get();
        return view('admin.dashbord')
            ->with(compact('visitor_last_month_count','visitor_this_month_count','visitor_in_one_year_count','vistor_all','visitor_count'
            ,'product_donut','post_donut','order_donut','customer_donut','post_view','product_view'));
    }


    public function filter_by_date(Request $request)
    {
        $data = $request->all();
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $get = statistical::whereBetween('order_date', [$from_date, $to_date])->orderBy('order_date', 'ASC')->get();

        foreach ($get as $key => $val) {
            $chart[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart);
    }

    public function dashbord_filter(Request $request)
    {
        $data = $request->all();
//                echo  $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
//                echo  $tomorrow = Carbon::now('Asia/Ho_Chi_Minh')->addDay()->format('d-m-Y H:i:s');
//                echo  $lastWeek = Carbon::now('Asia/Ho_Chi_Minh')->subWeek()->format('d-m-Y H:i:s');
//                echo  $sub15days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(15)->format('d-m-Y H:i:s');
//                echo  $sub30days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(30)->format('d-m-Y H:i:s');
        $dauthangnay = Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dau_thang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoi_thang_truoc = Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();

        $sub7days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(7)->toDateString();
        $sub365days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(365)->toDateString();
        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        if ($data['dashboard_value'] == '7ngay') {
            $get = statistical::whereBetween('order_date', [$sub7days, $now])->orderBy('order_date', 'DESC')->get();
        } elseif ($data['dashboard_value'] == 'thangtruoc') {
            $get = statistical::whereBetween('order_date', [$dau_thang_truoc, $cuoi_thang_truoc])->orderBy('order_date', 'DESC')->get();
        } elseif ($data['dashboard_value'] == 'thangnay') {
            $get = statistical::whereBetween('order_date', [$dauthangnay, $now])->orderBy('order_date', 'DESC')->get();
        } else {
            $get = statistical::whereBetween('order_date', [$sub365days, $now])->orderBy('order_date', 'DESC')->get();
        }

        foreach ($get as $key => $val) {
            $chart[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart);
    }

    public function days_order(){
        $sub60days = Carbon::now('Asia/Ho_Chi_Minh')->subDays(60)->toDateString();

        $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

        $get = statistical::whereBetween('order_date', [$sub60days, $now])->orderBy('order_date', 'ASC')->get();

//        $chart[] = array();
        foreach ($get as $key => $val) {
            $chart[] = array(
                'period' => $val->order_date,
                'order' => $val->total_order,
                'sales' => $val->sales,
                'profit' => $val->profit,
                'quantity' => $val->quantity
            );
        }
        echo $data = json_encode($chart);
    }
}
