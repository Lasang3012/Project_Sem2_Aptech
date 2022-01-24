<?php

namespace App\Http\Controllers;

use App\Models\CategoryPost;
use App\Models\Coupon;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
//session_start();
class CartController extends Controller
{
    public function show_cart_menu(){
        $count_session = count(Session::get('cart'));
        $output = '';
        if ($count_session > 0){
            $output .=  '
                            <a href="'.url('/show-cart-ajax').'" class="link-direction">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                <div class="left-info">
                                    <span class="index" id="show-cart-menu">'.$count_session.' Item</span>
                                    <span class="title">CART</span>
                                </div>
                            </a>

        ';
        }elseif($count_session == null){
            $output .=  '
                            <a href="'.url('/show-cart-ajax').'" class="link-direction">
                                <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                <div class="left-info">
                                    <span class="index" id="show-cart-menu"> 0 Item</span>
                                    <span class="title">CART</span>
                                </div>
                            </a>

        ';
        }

        echo $output;
    }

    public function add_cart_ajax(Request $request)
    {
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        if ($cart == true) {
            $is_count = 0;
            foreach ($cart as $key => $val) {
                if ($val['product_id'] == $data['cart_product_id']) {
                    $is_count++;
                }
            }
            if ($is_count == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_product_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_qty' => $data['cart_product_qty'],
                    'product_price' => $data['cart_product_price'],
                    'product_inventory' => $data['quantity_inventory'],
                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_product_id'],
                'product_image' => $data['cart_product_image'],
                'product_qty' => $data['cart_product_qty'],
                'product_price' => $data['cart_product_price'],
                'product_inventory' => $data['quantity_inventory'],
            );
            Session::put('cart', $cart);
        }

        Session::save();


    }


    public function show_cart_ajax()
    {
        $category_post = CategoryPost::orderBy('cate_post_id', 'DESC')->get();

        $for_export_product = DB::table('tbl_product')->where('product_status', '1')->orderBy('product_id', 'asc')->limit(5)->get();
        return view('pages.cart.cart_ajax')->with(compact('for_export_product', 'category_post'));
    }


    public function save_cart(Request $request)
    {
        $data = $request->all();
        $session_id = substr(md5(microtime()), rand(0, 26), 5);
        $cart = Session::get('cart');
        if ($cart == true) {
            $is_count = 0;
            foreach ($cart as $key => $val) {
                if ($val['product_id'] == $data['cart_id']) {
                    $is_count++;
                }
            }
            if ($is_count == 0) {
                $cart[] = array(
                    'session_id' => $session_id,
                    'product_name' => $data['cart_product_name'],
                    'product_id' => $data['cart_id'],
                    'product_image' => $data['cart_product_image'],
                    'product_inventory' => $data['quantity_inventory'],
                    'product_qty' => $data['product_quatity'],
                    'product_price' => $data['cart_product_price'],

                );
                Session::put('cart', $cart);
            }
        } else {
            $cart[] = array(
                'session_id' => $session_id,
                'product_name' => $data['cart_product_name'],
                'product_id' => $data['cart_id'],
                'product_image' => $data['cart_product_image'],
                'product_inventory' => $data['quantity_inventory'],
                'product_qty' => $data['product_quatity'],
                'product_price' => $data['cart_product_price'],

            );

            Session::put('cart', $cart);

        }

        Session::save();

        return Redirect::to('/show-cart-ajax');


    }

    public function delete_cart_ajax($session_id)
    {
        $cart = Session::get('cart');
        if ($cart == true) {
            foreach ($cart as $key => $val) {
                if ($val['session_id'] == $session_id) {
                    unset($cart[$key]);
                }
            }

            Session::put('cart', $cart);
            return redirect()->back()->with('message', 'Xóa sản phẩm thành công');
        } else {
            return redirect()->back()->with('message', 'Xóa sản phẩm không thành công');
        }

    }

    public function update_cart_ajax(Request $request)
    {
        $data = $request->all();
        $cart = Session::get('cart');
        $message = '';
        if ($cart == true) {
            foreach ($data['cart_quatity'] as $key => $qty) {
                foreach ($cart as $session => $val) {
                    if ($val['session_id'] == $key && $qty < $cart[$session]['product_inventory']) {
                        $cart[$session]['product_qty'] = $qty;
                        $message = '<p style="color: green">Cập nhật số lượng : ' . $cart[$session]['product_name'] . 'thành công</p>';


                    } elseif ($val['session_id'] == $key && $qty > $cart[$session]['product_inventory']) {
                        $message = '<p style="color: red">Cập nhật số lượng : ' . $cart[$session]['product_name'] . ' thất bại</p>';
                    }
                }
            }
            Session::put('cart', $cart);
            return redirect()->back()->with('message', $message);
        } else {
            return redirect()->back()->with('message', 'Cập nhật số lượng thất bại');
        }
    }

    public function delete_all_ajax()
    {
        $cart = Session::get('cart');

        if ($cart == true) {
            Session::forget('cart');
            Session::forget('coupon');
            Session::forget('fee');
            return redirect()->back()->with('message', 'Xóa giỏ hàng thành công');
        }
    }

    public function check_coupon(Request $request)
    {
        $data = $request->all();
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('d/m/Y');

        if (Session::get('customer_id')) {
            $coupon = Coupon::where('coupon_code', $data['coupon_name'])->where('coupon_status', 1)
                ->where('coupon_date_end', '>=', $today)->where('coupon_time', '>', 0)->where('coupon_used','LIKE','%'.Session::get('customer_id').'%')->first();
             if ($coupon){
                 return redirect()->back()->with('error', ' Mã giảm giá đã sử dụng vui lòng nhập mã khác ');
             }else{
                 $coupon_login = Coupon::where('coupon_code', $data['coupon_name'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->where('coupon_time', '>', 0)->first();
                 if ($coupon_login) {
                     $count_coupon = $coupon_login->count();
                     if ($count_coupon > 0) {
                         $session_coupon = Session::get('coupon');
                         if ($session_coupon == true) {
                             $is_avaiable = 0;
                             if ($is_avaiable == 0) {
                                 $cou[] = array(
                                     'coupon_code' => $coupon_login->coupon_code,
                                     'coupon_condition' => $coupon_login->coupon_condition,
                                     'coupon_number' => $coupon_login->coupon_number,

                                 );
                                 Session::put('coupon', $cou);
                             }
                         } else {
                             $cou[] = array(
                                 'coupon_code' => $coupon_login->coupon_code,
                                 'coupon_condition' => $coupon_login->coupon_condition,
                                 'coupon_number' => $coupon_login->coupon_number,

                             );
                             Session::put('coupon', $cou);
                         }
                         Session::save();
                         return redirect()->back()->with('message', 'Them ma giam gia hàng thành công');
                     }
                 } else {
                     return redirect()->back()->with('error', ' Mã giảm giá không chính xác hay đã hết hạn  ');
                 }

             }
        } else {
            $coupon = Coupon::where('coupon_code', $data['coupon_name'])->where('coupon_status', 1)->where('coupon_date_end', '>=', $today)->where('coupon_time', '>', 0)->first();
            if ($coupon) {
                $count_coupon = $coupon->count();
                if ($count_coupon > 0) {
                    $session_coupon = Session::get('coupon');
                    if ($session_coupon == true) {
                        $is_avaiable = 0;
                        if ($is_avaiable == 0) {
                            $cou[] = array(
                                'coupon_code' => $coupon->coupon_code,
                                'coupon_condition' => $coupon->coupon_condition,
                                'coupon_number' => $coupon->coupon_number,

                            );
                            Session::put('coupon', $cou);
                        }
                    } else {
                        $cou[] = array(
                            'coupon_code' => $coupon->coupon_code,
                            'coupon_condition' => $coupon->coupon_condition,
                            'coupon_number' => $coupon->coupon_number,

                        );
                        Session::put('coupon', $cou);
                    }
                    Session::save();
                    return redirect()->back()->with('message', 'Them ma giam gia hàng thành công');
                }
            } else {
                return redirect()->back()->with('error', ' Mã giảm giá không chính xác hay đã hết hạn  ');
            }
        }


    }




}
