<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\CategoryPost;
use App\Models\slider;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect; // giống return trả về 1 kết quả về 1 trang gì đó
use Illuminate\Support\Facades\Session; // thư viện session
session_start();
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryProduct extends Controller
{
//    public function  AuthLogin(){
//        $admin_id = Session::get('admin_id');
//        if ($admin_id){
//            return Redirect::to('dashbord');
//        }else{
//            return Redirect::to('admin')->send();
//        }
//    }
    public function add_category_product(){

        return view('admin.add_category');
    }
    public function all_category_product(){

//        $all_category_product = DB::table('tbl_category_product')->get();
        $all_category_product = Category::withoutTrashed()->paginate(5);
        $manager_category = view('admin.all_category')->with('all_category',$all_category_product);
        return view('admin_layout')->with('admin.all_category',$manager_category);
    }

    public function save_category_product(Request $request){
        $messages = [
            'category_name_product.required' => 'Tiêu danh mục bắt buộc nhập',
            'category_name_product.max' => 'Tên danh mục không được vượt quá 30 ký tự',
            'category_name_product.unique' => 'Tên danh mục đã tồn tại'
        ];
        $request->validate([
            'category_name_product' => 'required|unique:tbl_category_product,category_name|max:30',
            'category_slug_product' => 'required',
        ],$messages);
        $now = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
          $data = array();
          $data['category_name'] = $request->category_name_product;
          $data['category_desc'] = $request->category_desc_product;
          $data['category_status'] = $request->category_status_product;
          $data['category_slug'] = $request->category_slug_product;
          $data['created_at'] = $now;
          DB::table('tbl_category_product')->insert($data);
          Session::put('message','Thêm danh mục thành công');
          return Redirect::to('add-categoryProduct');

    }



    public function active_category_product($category_product_id){

        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status' => 0]);
        Session::put('message','Không kích hoạt danh mục sản phẩm thành công');
         return Redirect::to('all-categoryProduct');
     }
     public function un_active_category_product($category_product_id){

         DB::table('tbl_category_product')->where('category_id',$category_product_id)->update(['category_status' => 1]);
         Session::put('message','Kích hoạt danh mục sản phẩm thành công');
         return Redirect::to('all-categoryProduct');
     }

     public function edit_category($category_product_id){

         $edit_category_product = DB::table('tbl_category_product')->where('category_id',$category_product_id)->get();
         $manager_category = view('admin.edit_category')->with('edit_category',$edit_category_product);
         return view('admin_layout')->with('admin.edit_category',$manager_category);
     }

    public function update_category($category_product_id, Request $request){
        $messages = [
            'category_name_product.required' => 'Tiêu danh mục bắt buộc nhập',
            'category_name_product.max' => 'Tên danh mục không được vượt quá 30 ký tự',
            'category_name_product.unique' => 'Tên danh mục đã tồn tại'
        ];
        $request->validate([
            'category_name_product' => 'required|unique:tbl_category_product,category_name|max:30',
            'category_slug_product' => 'required',
        ],$messages);

        $data = array();
        $data['category_name'] = $request->category_name_product;
        $data['category_desc'] = $request->category_desc_product;
        $data['category_slug'] = $request->category_slug_product;
        DB::table('tbl_category_product')->where('category_id',$category_product_id)->update($data);
        Session::put('message','Cập nhật danh mục sản phẩm thành công');
        return Redirect::to('all-categoryProduct');
    }
     public function delete_category($category_product_id){
        $count = count(Category::find($category_product_id)->products);
         if ($count == 0){
             Category::destroy($category_product_id);
             Session::put('message','Xóa danh mục sản phẩm thành công');
             return Redirect::to('all-categoryProduct');
         }else{
             Session::put('message','Sản phẩm có tồn tại danh mục không thể xóa');
         return Redirect::to('all-categoryProduct');
         }


     }
     // end function admin page

    //start function fontend pages



    public function show_category_home($category_slug){

        $category_slug = Category::where('category_slug',$category_slug)->first();
        if ($category_slug == null){
            return \redirect('trang-chu');
        }
        $category_by_slug = $category_slug->category_id;

        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();
        $slider = slider::orderBy('slider_id','DESC')->where('slider_status',1)->take(4)->get();
        $category = Category::withoutTrashed()->where('category_status','1')->where('deleted_at','=',null)->orderBy('category_id','desc')->get();
        $brand = Brand::withoutTrashed()->where('brand_status','1')->where('deleted_at','=',null)->orderBy('brand_id','desc')->get();

        $price_max = Product::max('product_price');
        $price_min = Product::min('product_price');
        $max_price_range = $price_max + 100000;
        $min_price_range = $price_min + 100000;
        if (isset($_GET['sort_by'])){
            $sort_by = $_GET['sort_by'];
            if ($sort_by == 'giam-dan'){
                $category_by_id = Product::with('category')->where('category_id',$category_by_slug)->orderBy('product_price','DESC')
                    ->paginate(9)->appends(\request()->query());
            }elseif ($sort_by == 'tang-dan'){
                $category_by_id = Product::with('category')->where('category_id',$category_by_slug)->orderBy('product_price','ASC')
                    ->paginate(9)->appends(\request()->query());
            }elseif ($sort_by == 'kytuA-Z'){
                $category_by_id = Product::with('category')->where('category_id',$category_by_slug)->orderBy('product_name','ASC')
                    ->paginate(9)->appends(\request()->query());
            }elseif ($sort_by == 'kytuZ-A'){
                $category_by_id = Product::with('category')->where('category_id',$category_by_slug)->orderBy('product_name','DESC')
                    ->paginate(9)->appends(\request()->query());
            }
        }elseif(isset($_GET['start_price']) && $_GET['end_price']){
              $min_price = $_GET['start_price'];
              $max_price = $_GET['end_price'];
              $category_by_id =  Product::with('category')->whereBetween('product_price',[$min_price,$max_price])->orderBy('product_price','ASC')
                  ->paginate(6)->appends(\request()->query());
        }
        else{
            $category_by_id = Product::with('category')->where('category_id',$category_by_slug)->orderBy('product_id','DESC')
                ->paginate(9);
        }
//        $category_by_id = DB::table('tbl_product')->join('tbl_category_product','tbl_product.category_id','=','tbl_category_product.category_id')->where('tbl_product.category_id',$category_id)->where('tbl_product.product_status','1')->paginate(9);
        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id',$category_by_slug)->limit(1)->get();
        $for_export_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','asc')->limit(4)->get();
         return view('pages.category.show_category')
             ->with('category_product',$category)
             ->with('brand_product',$brand)
             ->with('category_by_id',$category_by_id)
             ->with('category_name',$category_name)
             ->with('export_product',$for_export_product)
             ->with('slider',$slider)
             ->with('price_max',$price_max)
             ->with('price_min',$price_min)
             ->with('max_price_range',$max_price_range)
             ->with('min_price_range',$min_price_range)
             ->with('category_post',$category_post);

    }
}
