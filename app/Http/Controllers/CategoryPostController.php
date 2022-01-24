<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryPost;
use Illuminate\Support\Facades\Session;

class CategoryPostController extends Controller
{
    public function add_category_post(){
        return view('admin.category_post.add_post');
    }
    public function save_category_post(Request $request){

         $message = [
             'cate_post_name.unique'=> 'Danh mục tin tức đã tồn tại !!!'
         ];
         $request->validate([
             'cate_post_name'=> 'unique:tbl_category_post,cate_post_name'

         ],$message);
         $data = $request->all();

        $category_post = new CategoryPost();
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_slug = $data['cate_post_slug'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_status = $data['cate_post_status'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $category_post->created_at = now();
        $category_post->save();

        Session::put('message','Thêm danh mục bài viết thành công');
        return redirect()->back();
    }


    public function list_category_post(){

        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->paginate(5);
        return view('admin.category_post.list_post')->with(compact('category_post'));
    }


    public function edit_category_post_id($cate_post_id){
        $category_post = CategoryPost::find($cate_post_id);
        return view('admin.category_post.edit_post')->with(compact('category_post'));

    }

    public function update_category_post(Request $request , $cate_post_id){
        $data = $request->all();

        $category_post = CategoryPost::find($cate_post_id);
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_slug = $data['cate_post_slug'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_status = $data['cate_post_status'];
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $category_post->created_at = now();
        $category_post->save();
        Session::put('message','Cập nhật danh mục bài viết thành công');
        return redirect('/list-category-post');
    }

    public function delete_category_post_id($cate_post_id){
        $count = count(CategoryPost::find($cate_post_id)->post);
        if ($count == 0){
            $category_post = CategoryPost::find($cate_post_id);
            $category_post->delete();
            Session::put('message','Xóa danh mục bài viết thành công');
            return redirect()->back();
        }else{
            Session::put('message','Danh mục bài viết có tồn tại trên bài viết !!!');
            return redirect()->back();
        }


    }
}
