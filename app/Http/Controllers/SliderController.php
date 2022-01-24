<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\slider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SliderController extends Controller
{
    public function manage_slider(){
        $all_slider = slider::orderBy('slider_id','DESC')->get();
        return view('admin.slider.list_slider')->with(compact('all_slider'));
    }
    public function  add_slider(){
        return view('admin.slider.add_slider');
    }

   public function insert_slider(Request $request){
         $data = $request->all();


       $get_image = $request->file('slider_image');
       if($get_image){
           $get_image_name = $get_image->getClientOriginalName();
           $name_image = current(explode('.',$get_image_name));
           $new_image = $name_image.rand(0,99).'.'.$get_image->getClientOriginalExtension();
           $get_image->move('public/upload/slider',$new_image);

           $slider = new slider();

           $slider->slider_name = $data['slider_name'];
           $slider->slider_image = $new_image;
           $slider->slider_desc = $data['slider_desc'];
           $slider->slider_status = $data['slider_status'];
           $slider->save();
           Session::put('message','Thêm Slider thành công');
           return Redirect::to('add-slider');
       }else{
           Session::put('message','Thêm Slider không thành công');
           return Redirect::to('all-slider');
       }


   }
   public function  active_slider($slider_id){
       DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status' => 1]);
       Session::put('alert_status','Không kích hoạt danh mục sản phẩm thành công');
       return Redirect::to('manage-slider');
   }

   public function un_active_slider($slider_id){
       DB::table('tbl_slider')->where('slider_id',$slider_id)->update(['slider_status' => 0]);
       Session::put('alert_status','Kích hoạt danh mục sản phẩm thành công');
       return Redirect::to('manage-slider');
   }

   public function delete_slider($slider_id){
          $slider = slider::where('slider_id',$slider_id)->first();
          $slider->delete();
          return redirect()->back();
   }
}
