<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RestoreController extends Controller
{

    public function index_category(){
        $all_category_product = Category::withTrashed()->where('deleted_at','!=', null)->paginate(5);
        return view('admin.Restore.category_restore')->with(compact('all_category_product'));
    }
    public function restore_category(Request $request,$id){
        Category::onlyTrashed()->find($id)->restore();
        Session::put('message','Phục hồi danh mục thành công');
        return redirect()->back();
    }
    public function delete_restore_category(Request $request,$id){
     Category::onlyTrashed()->find($id)->forceDelete();
        Session::put('message','Xóa danh mục thành công');
        return redirect()->back();
    }

    public function index_brand(){
        $all_brand_product = Brand::withTrashed()->where('deleted_at','!=', null)->paginate(5);
        return view('admin.Restore.brand_restore')->with(compact('all_brand_product'));
    }
    public function restore_brand(Request $request,$id){
        Brand::onlyTrashed()->find($id)->restore();
        Session::put('message','Phục hồi danh mục thành công');
        return redirect()->back();
    }
    public function delete_restore_brand(Request $request,$id){
        Brand::onlyTrashed()->find($id)->forceDelete();
        Session::put('message','Xóa danh mục thành công');
        return redirect()->back();
    }

    public function index_product(){
        $all_product = Product::withTrashed()->where('deleted_at','!=', null)->paginate(5);
        return view('admin.Restore.product_restore')->with(compact('all_product'));
    }
    public function restore_product(Request $request,$id){
        Product::onlyTrashed()->find($id)->restore();
        Session::put('message','Phục hồi sản phẩm thành công');
        return redirect()->back();
    }
    public function delete_restore_product(Request $request,$id){

        $product = Product::onlyTrashed()->find($id);


        $product_image = $product->product_image;
        $product->forceDelete();
        if ($product_image) {
            unlink('public/upload/product/' . $product_image);
        }

        $gallery= Gallery::where('product_id',$id)->get();
        foreach ($gallery as $value){
            unlink('public/upload/gallery/'.$value->gallery_image);
            $value->delete();
        }
        $comment = Comment::where('comment_product_id',$id)->get();
        foreach ($comment as $value){
            $value->delete();
        }

        Session::put('message','Xóa sản phẩm thành công');
        return redirect()->back();
    }
}
