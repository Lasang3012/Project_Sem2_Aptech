<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class GalleryController extends Controller
{
     public function add_gallery($product_id){
         $pro_id = $product_id;
         return view('admin.gallery.add_gallery')->with(compact('pro_id'));
     }

     public function select_gallery(Request $request){
          $product_id = $request->pro_id;
          $gallery = Gallery::where('product_id',$product_id)->get();
          $gallery_count = $gallery->count();
          $dataa = array();
          foreach ($gallery as   $val){
              $dataa[] = array(
                  'name' => $val->gallery_name,
                  'image' => url('public/upload/gallery/'.$val->gallery_image),
                  'id' => $val->gallery_id
              );
          }
          echo $data = json_encode($dataa);
//          $output = '<form>
//                     '.csrf_field().'
//                         <table class="table table-hover">
//                            <thead>
//                            <tr>
//                                <th>Thứ tự</th>
//                                <th>Tên hình ảnh</th>
//                                <th>Hình ảnh</th>
//                                <th>Quản lý</th>
//                            </tr>
//                            </thead>
//                            <tbody>' ;
//
//          if ($gallery_count > 0){
//              $i = 0;
//              foreach ($gallery as  $key => $value){
//                  $i++;
//                  $output .= '
//
//                                <tr>
//                                <td>'.$i.'</td>
//                                <td contenteditable="true" class="edit_gallery_name" data-gallery_id="'.$value->gallery_id.'">'.$value->gallery_name.'</td>
//
//                                <td><img src="'.url('public/upload/gallery/'.$value->gallery_image).'" class="img-thumbnail" width="120px">
//                                <input type="file" class="file_image" style="width: 40%" data-gallery_id="'.$value->gallery_id.'" id="file-'.$value->gallery_id.'" name="file" accept="image/*">
//
//                                </td>
//                                <td><button type="button" class="btn btn-danger delete-gal" data-gallery_id="'.$value->gallery_id.'">Xóa</button></td>
//                            </tr>
//                            ';
//              }
//          }else{
//              $output .= '<tr>
//                                <td colspan="4">Sản phẩm này chưa có ảnh</td>
//
//                            </tr>';
//          }
//              $output .= '
//                          </tbody>
//                          </table>
//                          </form>';
//          echo $output;
          }


          public function insert_gallery($product_id,Request $request){
               $get_image = $request->file('file');
               if ($get_image){
                   foreach ($get_image as $key => $images){
                       $get_image_name = $images->getClientOriginalName();
                       $name_image = current(explode('.',$get_image_name));
                       $new_image = $name_image.rand(0,99999999999999).'.'.$images->getClientOriginalExtension();
                       $images->move('public/upload/gallery',$new_image);

                       $gallery = new Gallery();
                       $gallery->gallery_name = $new_image;
                       $gallery->gallery_image = $new_image;
                       $gallery->product_id = $product_id;
                       $gallery->save();
                   }
               }
              Session::put('message','Thêm thư viện ảnh thành công');
              return redirect()->back();
          }

          public function update_gallery_name(Request $request){
                $gallery_id = $request->gal_id;
                $gallery_text = $request->gal_text;
                $gallery = Gallery::find($gallery_id);
                $gallery->gallery_name = $gallery_text;
                $gallery->save();
          }

          public function delete_gallery(Request $request){
               $gal_id = $request->gal_id;
               $gallery = Gallery::find($gal_id);
               unlink('public/upload/gallery/'.$gallery->gallery_image);
               $gallery->delete();

          }

          public function update_gallery_image(Request  $request){
              $get_image = $request->file('file');
              $gal_id = $request->gallery_id;
              if ($get_image){

                      $get_image_name = $get_image->getClientOriginalName();
                      $name_image = current(explode('.',$get_image_name));
                      $new_image = $name_image.rand(0,99999).'.'.$get_image->getClientOriginalExtension();
                      $get_image->move('public/upload/gallery',$new_image);

                      $gallery = Gallery::find($gal_id);
                      unlink('public/upload/gallery/'.$gallery->gallery_image);
                      $gallery->gallery_image = $new_image;
                      $gallery->save();
                  }

              Session::put('message','Thêm thư viện ảnh thành công');
              return redirect()->back();
          }
}
