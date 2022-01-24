<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\slider;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{


    public function detail(){
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();

        return view('pages.detail')->with('category_post',$category_post);
    }
    public function erorr(){
        return view('error.404');
    }
    public function  index(){

        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();

        $slider = slider::orderBy('slider_id','DESC')->where('slider_status',1)->take(4)->get();
        $category = Category::withoutTrashed()->where('category_status','1')->where('deleted_at','=',null)->orderBy('category_id','desc')->get();
        $brand = Brand::withoutTrashed()->where('brand_status','1')->where('deleted_at','=',null)->orderBy('brand_id','desc')->get();
//        $Latest_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','desc')->limit(9)->get();
        $Latest_product = Product::all()->where('product_status',1)->random(9);

        $for_export_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','DESC')->limit(4)->get();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $customer = Customer::whereDate('verify_at','<',$today)->where('verify_email','=',null)->delete();

        return view('pages.home')->with('category_product',$category)->with('brand_product',$brand)->with('latest_product',$Latest_product)->with('export_product',$for_export_product)->with('slider',$slider) ->with('category_post',$category_post);
    }

    public function  about_us(){
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();
        return view('pages.about')->with('category_post',$category_post);
    }

    public function sendMail(Request $request){
        $to_name = $request->name_mail;
        $to_phone = $request->phone_mail;
        $to_comment = $request->comment_mail;
        $to_email = $request->email_mail  ;//send to this email
        $email = "nghiaptts2006022@fpt.edu.vn";//send to this email

        $data = array("name"=> $to_name,"body"=> $to_comment , "phone"=> $to_phone,'email'=> $to_email); //body of mail.blade.php

                Mail::send('pages.send_maill',$data,function($message) use ($to_name,$email){
                    $message->from($email)->subject('Feedback');//send this mail with subject
                    $message->to($email,$to_name);//send from this mail
                });
        return redirect()->back()->with('message','Phản hồi đã được gửi đi');
    }

    public function  contact_us(){
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();

        return view('pages.contact')->with('category_post',$category_post);
    }
    public function  cart(){
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();
        return view('pages.cart.cart_ajax')->with('category_post',$category_post);
    }



    public function register(){
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();

        return view('pages.register')->with('category_post',$category_post);
    }

    public function search_product(Request $request){
        $keywords = $request->search;
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();
        $slider = slider::orderBy('slider_id','DESC')->where('slider_status',1)->take(4)->get();
        $category = Category::withoutTrashed()->where('category_status','1')->where('deleted_at','=',null)->orderBy('category_id','desc')->get();
        $brand = Brand::withoutTrashed()->where('brand_status','1')->where('deleted_at','=',null)->orderBy('brand_id','desc')->get();
        $for_export_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','asc')->limit(4)->get();
        $search_product = DB::table('tbl_product')->where('product_name','like','%'.$keywords.'%')->get();
//        print_r($search_product);
        return view('pages.sanpham.search')
            ->with('category_product',$category)
            ->with('brand_product',$brand)
            ->with('search_product',$search_product)
            ->with('export_product',$for_export_product)
            ->with('slider',$slider)
            ->with('category_post',$category_post);
    }


    public function autocomplete_ajax(Request $request){
          $data = $request->all();
          if ($data['query']){
              $product = Product::where('product_status','1')->where('product_name','LIKE','%'.$data['query'].'%')->limit(5)->get();
              $output = '<ul  style="position: absolute;display: block;z-index: 9999; background: white;list-style: none;width: 472px;margin-left:20px;text-align: left;border-radius: 7px;" >';
              foreach ($product as $key => $value){
                  $output .= '<li class="li_search_ajax" style="cursor: pointer">'.$value->product_name.'</li>';
              }
              $output .= '</ul>';
              echo $output;

          }
    }
}
