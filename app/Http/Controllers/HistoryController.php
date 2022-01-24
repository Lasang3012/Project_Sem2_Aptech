<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Coupon;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\shipping;
use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class HistoryController extends Controller
{
    public function history(){
        if (!Session::get('customer_id')){
           return  redirect('/login-checkout');
        }else{
            $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();
            $slider = slider::orderBy('slider_id','DESC')->where('slider_status',1)->take(4)->get();
            $category = Category::withoutTrashed()->where('category_status','1')->where('deleted_at','=',null)->orderBy('category_id','desc')->get();
            $brand = Brand::withoutTrashed()->where('brand_status','1')->where('deleted_at','=',null)->orderBy('brand_id','desc')->get();
            $for_export_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','asc')->limit(4)->get();

            $getOrder = Order::where('customer_id',Session::get('customer_id'))->orderBy('order_id','DESC')->paginate(5);
            return view('pages.History.history')
                ->with('category_product',$category)
                ->with('brand_product',$brand)
                ->with('getorder',$getOrder)

                ->with('export_product',$for_export_product)
                ->with('slider',$slider)

                ->with('category_post',$category_post);
        }

    }

    public function view_history_order(Request $request ,$order_code){
        if (!Session::get('customer_id')){
            return  redirect('/login-checkout');
        }else{
            $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();
            $slider = slider::orderBy('slider_id','DESC')->where('slider_status',1)->take(4)->get();
            $category = Category::withoutTrashed()->where('category_status','1')->where('deleted_at','=',null)->orderBy('category_id','desc')->get();
            $brand = Brand::withoutTrashed()->where('brand_status','1')->where('deleted_at','=',null)->orderBy('brand_id','desc')->get();
            $for_export_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','asc')->limit(4)->get();


            $order_Details = OrderDetails::with('product')->where('order_code',$order_code)->get();
            $order = Order::where('order_code',$order_code)->get();
            foreach ($order as $key => $value){
                $customer_id = $value->customer_id;
                $shipping_id = $value->shipping_id;
                $order_status = $value->order_status;
            }
            $customer = Customer::where('customer_id',$customer_id)->first();
            $shipping = shipping::where('shipping_id',$shipping_id)->first();
            $order_Details_product = OrderDetails::with('product')->where('order_code',$order_code)->get();

            foreach ($order_Details_product as $key => $order_d){
                $product_coupon = $order_d->product_coupon;

            }

            if ($product_coupon != 'no'){
                $coupon = Coupon::where('coupon_code',$product_coupon)->first();
                $coupon_condition = $coupon->coupon_condition;
                $coupon_number = $coupon->coupon_number;
            }else{
                $coupon_condition = 2;
                $coupon_number = 0;
            }



            return view('pages.History.view_history_order')
                ->with('category_product',$category)
                ->with('brand_product',$brand)


                ->with('export_product',$for_export_product)
                ->with('slider',$slider)
                ->with(compact('order_Details','customer','shipping','coupon_number','coupon_condition','order','order_status'))
                ->with('category_post',$category_post);

        }
    }
}
