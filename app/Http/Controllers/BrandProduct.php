<?php

namespace App\Http\Controllers;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryPost;
use App\Models\slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect; // giống return trả về 1 kết quả về 1 trang gì đó
use Illuminate\Support\Facades\Session; // thư viện session

use Illuminate\Http\Request;


class BrandProduct extends Controller
{
//    public function  AuthLogin(){
//        $admin_id = Session::get('admin_id');
//        if ($admin_id){
//            return Redirect::to('dashbord');
//        }else{
//            return Redirect::to('admin')->send();
//        }
//    }
    public function add_brand_product(){

        return view('admin.add_brand');
    }
    public function all_brand_product(){

//        $all_brand_product = DB::table('tbl_brand')->get(); sử dụng controller

        $all_brand_product = Brand::withoutTrashed()->orderBy('brand_id','DESC')->paginate(4);
        $manager_brand = view('admin.all_brand')->with('all_brand',$all_brand_product);
        return view('admin_layout')->with('admin.all_brand',$manager_brand);
    }

    public function save_brand_product(Request $request){
        $messages = [
            'brand_name_product.required' => 'Tiêu thương hiệu bắt buộc nhập',
            'brand_name_product.max' => 'Tên thương hiệu không được vượt quá 30 ký tự',
            'brand_name_product.unique' => 'Tên thương hiệu đã tồn tại'
        ];
        $request->validate([
            'brand_name_product' => 'required|unique:tbl_brand,brand_name|max:30',
        ],$messages);


        $data = $request->all();
        $brand = new Brand();
        $brand->brand_name = $data['brand_name_product'];
        $brand->brand_desc = $data['brand_desc_product'];
        $brand->brand_status = $data['brand_status_product'] ;
        $brand->brand_slug = $data['brand_slug_product'] ;
        $brand->save();
//        $data = array();
//        $data['brand_name'] = $request->brand_name_product;
//        $data['brand_desc'] = $request->brand_desc_product;
//        $data['brand_status'] = $request->brand_status_product;
//        DB::table('tbl_brand')->insert($data);
        Session::put('message','Thêm thương hiệu  thành công');
        return Redirect::to('add-brandProduct');

    }

    public function active_brand_product($brand_product_id){

        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status' => 0]);
        Session::put('message','Không kích hoạt thương hiệu  sản phẩm thành công');
        return Redirect::to('all-brandProduct');
    }
    public function un_active_brand_product($brand_product_id){

        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update(['brand_status' => 1]);
        Session::put('message','Kích hoạt thương hiệu  sản phẩm thành công');
        return Redirect::to('all-categoryProduct');
    }

    public function edit_brand($brand_product_id){

//        $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $edit_brand_product = Brand::where('brand_id',$brand_product_id)->get();
        $manager_brand = view('admin.edit_brand')->with('edit_brand',$edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand',$manager_brand);
    }

    public function update_brand($brand_product_id, Request $request){

        $data = $request->all();

        $messages = [
            'brand_name_product.required' => 'Tiêu thương hiệu bắt buộc nhập',
            'brand_name_product.max' => 'Tên thương hiệu không được vượt quá 30 ký tự',
            'brand_name_product.unique' => 'Tên thương hiệu đã tồn tại'
        ];
        $request->validate([
            'brand_name_product' => 'required|unique:tbl_brand,brand_name|max:30',
        ],$messages);


        $brand = Brand::find($brand_product_id);
        $brand->brand_name = $data['brand_name_product'];
        $brand->brand_desc = $data['brand_desc_product'];
        $brand->brand_slug = $data['brand_slug_product'] ;
        $brand->save();
//        $data = array();
//        $data['brand_name'] = $request->brand_name_product;
//        $data['brand_desc'] = $request->brand_desc_product;
//        DB::table('tbl_brand')->where('brand_id',$brand_product_id)->update($data);
        Session::put('message','Cập nhật thương hiệu sản phẩm thành công');
        return Redirect::to('all-brandProduct');
    }
    public function delete_brand($brand_product_id){

        $count = count(Brand::find($brand_product_id)->products);
        if ($count == 0){
            Brand::destroy($brand_product_id);
            Session::put('message','Xóa thương hiệu  sản phẩm thành công');
            return Redirect::to('all-brandProduct');
        }else{
            Session::put('message','Sản phẩm có tồn tại thương hiệu không thể xóa');
            return Redirect::to('all-brandProduct');
        }
    }

    // end function admin page

    //start function fontend pages
    public function show_brand_home($brand_slug){

        $brand_slug = Brand::where('brand_slug',$brand_slug)->first();
        if ($brand_slug == null ){
            return \redirect('trang-chu');
        }
        $brand_by_slug = $brand_slug->brand_id;


        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();
        $slider = slider::orderBy('slider_id','DESC')->where('slider_status',1)->take(4)->get();
        $category = Category::withoutTrashed()->where('category_status','1')->where('deleted_at','=',null)->orderBy('category_id','desc')->get();
        $brand = Brand::withoutTrashed()->where('brand_status','1')->where('deleted_at','=',null)->orderBy('brand_id','desc')->get();
        $brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_product.brand_id',$brand_by_slug)->where('tbl_product.product_status','1')->get();
        $brand_name = DB::table('tbl_brand')->where('tbl_brand.brand_id',$brand_by_slug)->limit(1)->get();
        $for_export_product = DB::table('tbl_product')->where('product_status','1')->orderBy('product_id','asc')->limit(4)->get();
        return view('pages.brand.show_brand')
            ->with('category_product',$category)
            ->with('brand_product',$brand)
            ->with('brand_by_id',$brand_by_id)
            ->with('get_name_brand',$brand_name)
            ->with('export_product',$for_export_product)
            ->with('slider',$slider)
            ->with('category_post',$category_post);
    }
}
