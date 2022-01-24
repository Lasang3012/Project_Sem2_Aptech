<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function add_post(){

        $cate_post = CategoryPost::orderBy('cate_post_id','DESC')->get();
        return view('admin.post.add_post')->with(compact('cate_post'));
    }

    public function save_post(Request $request){

        $data = $request->all();
        $post = new Post();
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_keyword = $data['post_meta_keyword'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->cate_post_id = $data['cate_post_id'];
        $post->post_status = $data['post_status'];




        $get_image = $request->file('post_image');
        if($get_image){
            $get_image_name = $get_image->getClientOriginalName();

            $name_image = current(explode('.',$get_image_name));

            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();

            $get_image->move('public/upload/post',$new_image);

            $post->post_image = $new_image;
            $post->save();
            Session::put('message','Thêm bài viết thành công');
            return redirect()->back();

        }else{
            Session::put('message','Vui long thêm hình ảnh');
            return redirect()->back();
        }



    }
    public function list_post(){

         $all_post = Post::with('cate_post')->orderBy('post_id')->paginate();
         return view('admin.post.all_post')->with(compact('all_post'));
    }

   public function delete_post($post_id){
         $post = Post::find($post_id);
         $post_image = $post->post_image;
         if ($post_image){
             unlink('public/upload/post/'.$post_image);
         }
         $post->delete();
         Session::put('message','Xóa bài viết thành công');
         return redirect()->back();
   }

    public function edit_post($post_id){
        $cate_post = CategoryPost::orderBy('cate_post_id','DESC')->get();
        $post  = Post::find($post_id);
        return view('admin.post.edit_post')->with(compact('post','cate_post'));
    }

    public function  update_post(Request $request,$post_id){
        $data = $request->all();
        $post = Post::find($post_id);
        $post->post_title = $data['post_title'];
        $post->post_slug = $data['post_slug'];
        $post->post_desc = $data['post_desc'];
        $post->post_content = $data['post_content'];
        $post->post_meta_keyword = $data['post_meta_keyword'];
        $post->post_meta_desc = $data['post_meta_desc'];
        $post->cate_post_id = $data['cate_post_id'];
        $post->post_status = $data['post_status'];




        $get_image = $request->file('post_image');
        if($get_image){
            //xóa ảnh cũ
            $post_image = $post->post_image;
            unlink('public/upload/post/'.$post_image);
            //cập nhật ảnh mới
            $get_image_name = $get_image->getClientOriginalName();

            $name_image = current(explode('.',$get_image_name));

            $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();

            $get_image->move('public/upload/post',$new_image);

            $post->post_image = $new_image;



        }
        $post->save();
        Session::put('message','Update bài viết thành công');
        return redirect()->back();
    }

    public function danhmucbaiviet($post_slug){
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();

        $cate_post = CategoryPost::where('cate_post_slug',$post_slug)->take(1)->get();
        foreach ($cate_post as $cate){
            $cate_id = $cate->cate_post_id;
            $meta_title = $cate->cate_post_name;
        }
        $post = Post::with('cate_post')->where('post_status',1)->where('cate_post_id',$cate_id)->paginate(5);

        return view('pages.post.post')
            ->with('category_post',$category_post)
            ->with('cate_post',$cate_post)
            ->with('meta_title',$meta_title)
            ->with('post',$post);
    }

    public function baiviet($post_slug){
        $category_post = CategoryPost::orderBy('cate_post_id','DESC')->get();

        $cate_post = CategoryPost::where('cate_post_slug',$post_slug)->take(1)->get();

        $post = Post::with('cate_post')->where('post_status',1)->where('post_slug',$post_slug)->take(1)->get();
        foreach ($post as $p){
            $cate_id = $p->cate_post_id;
            $meta_title = $p->post_title;
            $post_id = $p->post_id;
        }
        $post_view = Post::where('post_id',$post_id)->first();
        $post_view->post_view = $post_view->post_view + 1;
        $post_view->save();
        return view('pages.post.baiviet')
            ->with('category_post',$category_post)
            ->with('cate_post',$cate_post)
            ->with('meta_title',$meta_title)
            ->with('post',$post)
            ->with('post_view',$post_view);
    }
}
