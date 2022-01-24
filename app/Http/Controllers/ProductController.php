<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Comment;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\File;

class ProductController extends Controller
{

    public function add_product()
    {

        $category = DB::table('tbl_category_product')->orderBy('category_id', 'desc')->get();
        $brand = DB::table('tbl_brand')->orderBy('brand_id', 'desc')->get();
        return view('admin.add_product')->with('category_product', $category)->with('brand_product', $brand);
    }

    public function all_product()
    {
        $all_product = Product::join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')
            ->withoutTrashed()->orderBy('product_id','DESC')->get();
        $manager_product = view('admin.all_product')->with('all_product', $all_product);
        return view('admin_layout')->with('admin.all_product', $manager_product);
    }

    public function save_product(Request $request)
    {
        $messages = [
            'product_name.required' => 'Tiêu sản phẩm bắt buộc nhập',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 30 ký tự',
            'product_name.unique' => 'Tên sản phẩm đã tồn tại',



        ];
        $request->validate([
            'product_name' => 'required|unique:tbl_product,product_name|max:30',
            'product_image'=> 'required|image|mimes:jpg,png,jpeg,gif,svg'

        ],$messages);

        $data = array();
        $num = filter_var($request->product_price,FILTER_SANITIZE_NUMBER_INT);
        $num_cost = filter_var($request->product_price_cost,FILTER_SANITIZE_NUMBER_INT);

        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->product_category;
        $data['brand_id'] = $request->product_brand;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $num;
        $data['inventory'] = $request->product_inventory;
        $data['product_status'] = $request->product_status;
        $data['product_tags'] = $request->product_tags;
        $data['price_cost'] = $num_cost;
        $data['product_sldb'] = 0;


        $get_image = $request->file('product_image');
        $path = 'public/upload/product/';
        $path_gallery = 'public/upload/gallery/';
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_image_name));
            $new_image = $name_image . rand(0, 9999999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move($path, $new_image);
            File::copy($path . $new_image, $path_gallery . $new_image);
            $data['product_image'] = $new_image;


        } else {
            Session::put('message_product', 'Vui lòng thêm hình ảnh');
            return Redirect::to('all-Product');
        }
        $pro_id = DB::table('tbl_product')->insertGetId($data);
        $gallery = new Gallery();
        $gallery->gallery_image = $new_image;
        $gallery->gallery_name = $new_image;
        $gallery->product_id = $pro_id;
        $gallery->save();
        Session::put('message_product', 'Thêm sản phẩm thành công');
        return Redirect::to('all-Product');

    }

    public function active_product($product_id)
    {

        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
        Session::put('message_product', 'Không kích hoạt sản phẩm thành công');
        return Redirect::to('all-Product');
    }

    public function un_active_product($product_id)
    {

        DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
        Session::put('message_product', 'Kích hoạt  sản phẩm thành công');
        return Redirect::to('all-Product');
    }

    public function edit_product($product_id)
    {

        $category = DB::table('tbl_category_product')->orderBy('category_id', 'desc')->get();
        $brand = DB::table('tbl_brand')->orderBy('brand_id', 'desc')->get();
        $edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
        $manager_product = view('admin.edit_product')->with('edit_product', $edit_product)
            ->with('category_product', $category)->with('brand_product', $brand);
        return view('admin_layout')->with('admin.edit_product', $manager_product);
    }

    public function update_product($product_id, Request $request)
    {

        $messages = [
            'product_name.required' => 'Tiêu sản phẩm bắt buộc nhập',
            'product_name.max' => 'Tên sản phẩm không được vượt quá 30 ký tự',
        ];
        $request->validate([
            'product_name' => 'required|max:30',
            'product_image'=> 'image|mimes:jpg,png,jpeg,gif,svg'

        ],$messages);

        $data = array();
        $num = filter_var($request->product_price,FILTER_SANITIZE_NUMBER_INT);
        $num_cost = filter_var($request->product_price_cost,FILTER_SANITIZE_NUMBER_INT);

        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->product_category;
        $data['brand_id'] = $request->product_brand;
        $data['product_desc'] = $request->product_desc;
        $data['product_content'] = $request->product_content;
        $data['product_price'] = $num;
        $data['product_status'] = $request->product_status;
        $data['inventory'] = $request->product_inventory;
        $data['product_tags'] = $request->product_tags;
        $data['price_cost'] = $num_cost;

        $get_image = $request->file('product_image');
        if ($get_image) {
            $get_image_name = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_image_name));
            $new_image = $name_image . rand(0, 999999999) . '.' . $get_image->getClientOriginalExtension();
            $get_image->move('public/upload/product', $new_image);
            $data['product_image'] = $new_image;
            DB::table('tbl_product')->where('product_id', $product_id)->update($data);
            Session::put('message_product', 'Cập nhật sản phẩm thành công');
            return Redirect::to('all-Product');

        }

        DB::table('tbl_product')->where('product_id', $product_id)->update($data);
        Session::put('message_product', 'Cập nhật sản phẩm thành công');
        return Redirect::to('all-Product');
    }


    public function delete_product($product_id)
    {
        $product = Product::find($product_id);


        $product->delete();
        Session::put('message_product', 'Xóa  sản phẩm thành công');
        return redirect()->back();
    }
    // end function page admin

    //start function fontend
    public function detail_product($product_id)
    {
        $details = Product::find($product_id);
        if ($details == null){
            return  redirect('/trang-chu');
        }
        $details_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')
            ->where('tbl_product.product_id', $product_id)->get();

        $category_post = CategoryPost::orderBy('cate_post_id', 'DESC')->get();

        $category = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();



        foreach ($details_product as $key => $value) {
            $category_id = $value->category_id;
            $brand_id = $value->brand_id;


        }
        $product_view = Product::where('product_id',$product_id)->first();
        $product_view->product_view = $product_view->product_view + 1;
        $product_view->save();
        $gallery = Gallery::where('product_id', $product_id)->get();
        $related_product = DB::table('tbl_product')
            ->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')
            ->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')
            ->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$product_id])->get();

        return view('pages.detail')
            ->with('category_product', $category)
            ->with('brand_product', $brand)
            ->with('product_details', $details_product)
            ->with('related', $related_product)
            ->with('gallery', $gallery)
            ->with('category_post', $category_post);
    }


    public function tag(Request $request, $product_tag)
    {
        $category_post = CategoryPost::orderBy('cate_post_id', 'DESC')->get();
        $slider = slider::orderBy('slider_id', 'DESC')->where('slider_status', 1)->take(4)->get();
        $category = DB::table('tbl_category_product')->where('category_status', '1')->orderBy('category_id', 'desc')->get();
        $brand = DB::table('tbl_brand')->where('brand_status', '1')->orderBy('brand_id', 'desc')->get();
        $for_export_product = DB::table('tbl_product')->where('product_status', '1')->orderBy('product_id', 'asc')->limit(4)->get();

        $tag = str_replace("-", " ", $product_tag);
        $pro_tags = Product::where('product_status', 0)->where('product_name', 'LIKE', '%' . $tag . '%')->orWhere('product_tags', 'LIKE', '%' . $tag . '%')->get();


        return view('pages.sanpham.tag')
            ->with('category_product', $category)
            ->with('brand_product', $brand)
            ->with('slider', $slider)
            ->with('export_product', $for_export_product)
            ->with('product_tag', $product_tag)
            ->with('tags', $pro_tags)
            ->with('category_post', $category_post);
    }


    public function load_comment(Request $request)
    {
        $product_id = $request->product_id;
        $comment = Comment::where('comment_product_id', $product_id)->where('comment_parrent','=',0)->where('comment_status',1)->get();
        $product = Product::find($product_id);
        $product_name = $product->product_name;

        $comment_rep = Comment::with('product')->where('comment_parrent','>=',0)->get();
        $output = '';
        foreach ($comment as $key => $com) {
            $output .= '

              <div id="comments">
                     <h2 class="woocommerce-Reviews-title">01 review for <span>'.$product_name.'</span></h2>
                         <ol class="commentlist">
                             <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-20" style="background-color: #f0f0E9;border-radius: 10px;padding: 10px">
                                  <div id="comment-20" class="comment_container">
                                   <img alt="" src="' . url('public/Fontend/images/comment.jpg') . '" height="80" width="80">
                                     <div class="comment-text">

                                  <p class="meta">
                                           <strong class="woocommerce-review__author">' . $com->comment_name . '</strong>
                                                <span class="woocommerce-review__dash">–</span>
                                                     <time class="woocommerce-review__published-date" datetime="2008-02-14 20:00" >' . $com->comment_date . '</time>
                                     </p>
                                    <div class="description">
                                           <p>' . $com->comment . '</p>
                                     </div>
                                       </div>
                                           </div>
                                            </li>

                                        </ol>
                                    </div>';


                   foreach ($comment_rep as $key => $comment_reply){
                     if ($comment_reply->comment_parrent == $com->comment_id){
             $output .=   ' <div id="comments">
                     <h2 class="woocommerce-Reviews-title">01 reply <span>'.$product_name.'</span></h2>
                         <ol class="commentlist">
                             <li class="comment byuser comment-author-admin bypostauthor even thread-even depth-1" id="li-comment-20" style="background-color: #f0f0E9;margin:0 40px;border-radius: 10px;padding: 10px">
                                  <div id="comment-20" class="comment_container">
                                   <img alt="" src="' . url('public/Fontend/images/comment.jpg') . '" height="80" width="80">
                                     <div class="comment-text">

                                  <p class="meta">
                                           <strong class="woocommerce-review__author">' . $comment_reply->comment_name . '</strong>
                                                <span class="woocommerce-review__dash">–</span>
                                                     <time class="woocommerce-review__published-date" datetime="2008-02-14 20:00" >' . $comment_reply->comment_date . '</time>
                                     </p>
                                    <div class="description">
                                           <p>' .$comment_reply->comment . '</p>
                                     </div>
                                       </div>
                                           </div>
                                            </li>

                                        </ol>
                                    </div>';

                }
            }

        }
        echo $output;
    }


    public function send_comment(Request $request)
    {
        $comment_name = $request->comment_name;
        $comment_content = $request->comment_content;
        $comment_email = $request->comment_email;
        $comment_product_id = $request->comment_product_id;
        $comment = new Comment();
        $comment->comment = $comment_content;
        $comment->comment_email = $comment_email;
        $comment->comment_product_id = $comment_product_id;
        $comment->comment_name = $comment_name;
        $comment->comment_status = 0;
        $comment->comment_parrent = 0;
        $comment->save();
    }

    public function list_comment(){
        $comment_rep = Comment::with('product')->where('comment_parrent','>',0)->get();

        $comment = Comment::with('product')->orderBy('comment_status','DESC')->get();
        return view('admin.comment.list_comment')->with(compact('comment','comment_rep'));
    }

    public function allow_comment(Request $request){
           print_r($request->comment_status);

          $comment = Comment::find($request->comment_id);

          $comment->comment_status = $request->comment_status;
          $comment->save();
    }

    public function reply_comment(Request $request){
         $comment = new Comment();
         $comment->comment = $request->comment;

        $comment->comment_product_id = $request->comment_product_id;
        $comment->comment_parrent = $request->comment_id;
        $comment->comment_status = 0;
        $comment->comment_name = 'Admin';
        $comment->comment_email = 'Admin';
        $comment->save();

    }
    public function delete_comment($comment_id){



         $comment = Comment::where('comment_id',$comment_id)->first();
//          $comment_parrent = Comment::where('comment_parrent',$comment_id)->get();
//          $comment_parrent->delete();
          $comment->delete();

          return \redirect()->back()->with('message','Xóa comment thành công');

    }
}
