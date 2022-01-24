<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\statistical;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\shipping;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Feeship;
use App\Models\Customer;
use App\Models\Coupon;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

//session_start();

class   OrderController extends Controller
{
    public function manager_order(){
          $order = Order::orderby('created_at','DESC')->get();
          return view('admin.Order.manager_order')->with(compact('order'));
    }

    public function delete_order(Request $request ,$order_code){
        $order = Order::where('order_code',$order_code)->first();

        $order_shipping_id = $order->shipping_id;
        $order->delete();

        $shipping = shipping::where('shipping_id',$order_shipping_id)->first();
        $shipping->delete();


        DB::table('tbl_order_details')->where('order_code',$order_code)->delete();

        Session::put('message','Xóa đơn hàng thành công');
        return redirect()->back();

    }
    public function view_order($order_code){
            $order_Details = OrderDetails::with('product')->where('order_code',$order_code)->get();
        $order = Order::where('order_code',$order_code)->get();
        foreach ($order as $key => $value){
            $customer_id = $value->customer_id;
            $shipping_id = $value->shipping_id;
            $order_status = $value->order_status;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = shipping::where('shipping_id',$shipping_id)->first();
        $order_Details_product = OrderDetails::with('product')->where('order_code',$order_code)->get();

        foreach ($order_Details_product as $key => $order_d){
            $product_coupon = $order_d->product_coupon;

        }

        if ($product_coupon != 'no'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();
            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;
        }else{
            $coupon_condition = 2;
            $coupon_number = 0;
        }

        return view('admin.Order.view_order')
            ->with(compact('order_Details','customer','shipping','coupon_number','coupon_condition','order','order_status'));
    }


    public function print_order($checkout_code){
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->print_order_convert($checkout_code));
        return $pdf->stream();
    }

public function update_order(Request $request){
        $data = $request->all();

        $order = Order::find($data['order_id']);
        $order->order_status = $data['order_status'];
        $order->save();

    //send mail confirm
    $now = Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
    $title_mail = "Đơn hàng đã đặt được xác nhận".' '.$now;
    $customer = Customer::where('customer_id',$order->customer_id)->first();
    $data['email'][] = $customer->customer_email;


    //lay san pham

    foreach($data['order_product_id'] as $key => $product){
        $product_mail = Product::find($product);
        foreach($data['quantity'] as $key2 => $qty){

            if($key==$key2){

                $cart_array[] = array(
                    'product_name' => $product_mail['product_name'],
                    'product_price' => $product_mail['product_price'],
                    'product_qty' => $qty
                );

            }
        }
    }


    //lay shipping
    $details = OrderDetails::where('order_code',$order->order_code)->first();
    $order_confrim = Coupon::where('coupon_code',$details->product_coupon)->first();
     if ($order_confrim){
         $coupon_number = $order_confrim->coupon_number;
         $coupon_condition = $order_confrim->coupon_condition;
     }else{
         $coupon_number = 0 ;
         $coupon_condition = 0;
     }
    $fee_ship = $details->product_feeship;
    $coupon_mail = $details->product_coupon;

    $shipping = shipping::where('shipping_id',$order->shipping_id)->first();

    $shipping_array = array(
        'fee_ship' =>  $fee_ship,
        'customer_name' => $customer->customer_name,
        'shipping_name' => $shipping->shipping_name,
        'shipping_email' => $shipping->shipping_email,
        'shipping_phone' => $shipping->shipping_phone,
        'shipping_address' => $shipping->shipping_address,
        'shipping_notes' => $shipping->shipping_note,
        'shipping_method' => $shipping->shipping_method

    );
    //lay ma giam gia, lay coupon code
    $ordercode_mail = array(
        'coupon_code' => $coupon_mail,
        'order_code' => $details->order_code,
         'coupon_number' => $coupon_number,
            'coupon_condition' => $coupon_condition,
    );

    if ($order->order_status == 2){
        Mail::send('admin.Order.confrim_mail',  ['cart_array'=>$cart_array, 'shipping_array'=>$shipping_array ,'code'=>$ordercode_mail] , function($message) use ($title_mail,$data){
            $message->to($data['email'])->subject($title_mail);//send this mail with subject
            $message->from($data['email'],$title_mail);//send from this mail
        });
    }





        //order_date
        $order_date = $order->order_date;
        $statistic = statistical::where('order_date',$order_date)->get();
        if ($statistic){
            $statistic_count = $statistic->count();
        }else{
            $statistic_count = 0;
        }
    $total_order = 0;
    $sales = 0;
    $profit = 0;
    $quantity = 0;
        if ($order->order_status == 2){


            foreach ($data['order_product_id'] as $key =>  $product_id){
                $product = Product::find($product_id);
                $product_quantity = $product->inventory;
                $product_sldb = $product->product_sldb;

                $product_price = $product->product_price;
                $product_Cost = $product->price_cost;
                $now = Carbon::now('Asia/Ho_Chi_Minh')->toDateString();

                foreach ($data['quantity'] as $key2 => $qty){
                      if ($key == $key2){
                          $pro_remain = $product_quantity - $qty ;
                          $product->inventory = $pro_remain;
                          $product->product_sldb =  $product_sldb + $qty;
                          $product->save();

                          //update doanh thu
                          $quantity += $qty;
                          $profit +=  $product_price * $qty;
                          $sales +=  ($product_price*$qty)-($product_Cost*$qty);

                      }
                }
            }$total_order += 1;
            //update doanh so
            if ($statistic_count > 0){
                 $statistic_update = statistical::where('order_date',$order_date)->first();
                 $statistic_update->sales = $statistic_update->sales + $sales;
                $statistic_update->profit = $statistic_update->profit + $profit;
                $statistic_update->quantity = $statistic_update->quantity + $quantity;
                $statistic_update->total_order = $statistic_update->total_order + $total_order;
                $statistic_update->save();
            }else{
                $statistic_new = new statistical();
                $statistic_new->order_date = $order_date;
                $statistic_new->sales = $sales;
                $statistic_new->profit = $profit;
                $statistic_new->quantity = $quantity;
                $statistic_new->total_order = $total_order;
                $statistic_new->save();


            }


        }elseif($order->order_status == 1){
            foreach ($data['order_product_id'] as $key =>  $product_id){
                $product = Product::find($product_id);
                $product_quantity = $product->inventory;
                $product_sldb = $product->product_sldb;
                $product_price = $product->product_price;
                $product_Cost = $product->price_cost;
                foreach ($data['quantity'] as $key2 => $qty){
                    if ($key == $key2){
                        $pro_remain = $product_quantity + $qty ;
                        $product->inventory = $pro_remain;
                        $product->product_sldb =  $product_sldb - $qty;
                        $product->save();
                        //update doanh thu
                        $quantity += $qty;
                        $profit +=  $product_price * $qty;
                        $sales += ($product_price*$qty)-($product_Cost*$qty);

                    }
                }

            }
            $total_order += 1;
            $statistic_update = statistical::where('order_date',$order_date)->first();
            $statistic_update->sales = $statistic_update->sales -$sales;
            $statistic_update->profit = $statistic_update->profit -$profit;
            $statistic_update->quantity = $statistic_update->quantity -$quantity;
            $statistic_update->total_order = $statistic_update->total_order -$total_order;
            $statistic_update->save();
        }


}


        public function update_quantity_order(Request $request){
                 $data = $request->all();
                 $order_details = OrderDetails::where('product_id',$data['order_product_id'])->where('order_code',$data['order_code'])->first();
                 $order_details->product_sales_quantity = $data['order_qty'];
                 $order_details->save();
        }
















    public function print_order_convert($checkout_code){
        $order_details = OrderDetails::where('order_code',$checkout_code)->get();
        $order = Order::where('order_code',$checkout_code)->get();
        foreach ($order as $key => $value){
            $customer_id = $value->customer_id;
            $shipping_id = $value->shipping_id;
        }
        $customer = Customer::where('customer_id',$customer_id)->first();
        $shipping = shipping::where('shipping_id',$shipping_id)->first();

        $order_details_product = OrderDetails::with('product')->where('order_code',$checkout_code)->get();

        foreach($order_details_product as $key => $order_d){

            $product_coupon = $order_d->product_coupon;
        }
        if($product_coupon != 'no'){
            $coupon = Coupon::where('coupon_code',$product_coupon)->first();

            $coupon_condition = $coupon->coupon_condition;
            $coupon_number = $coupon->coupon_number;

            if($coupon_condition==1){
                $coupon_echo = $coupon_number.'%';
            }elseif($coupon_condition==2){
                $coupon_echo = number_format($coupon_number,0,',','.').'đ';
            }
        }else{
            $coupon_condition = 2;
            $coupon_number = 0;

            $coupon_echo = '0';

        }
        $output = '';

        $output.='<style>body{
			font-family: DejaVu Sans;
		}
		.table-styling{
			border:1px solid #000;
		}
		.table-styling tbody tr td{
			border:1px solid #000;
		}
		</style>
		<h1><center>Công ty TNHH một thành viên Goodboy</center></h1>
		<h4><center>Cộng hòa - Xã hội - Chủ nghĩa - Việt Nam</center></h4>
		<h4><center>Độc lập - Tự do - Hạnh phúc</center></h4>
		<p>Người đặt hàng</p>
		<table class="table-styling" border="1">
				<thead>
					<tr>
						<th>Tên khách đặt</th>
						<th>Số điện thoại</th>
						<th>Email</th>
					</tr>
				</thead>
				<tbody>';

        $output.='
					<tr>
						<td>'.$customer->customer_name.'</td>
						<td>'.$customer->customer_phone.'</td>
						<td>'.$customer->customer_email.'</td>

					</tr>';


        $output.='
				</tbody>

		</table>';
        $output.='

		<p>Địa chỉ giao hàng</p>
		<table class="table-styling " border="1">
				<thead>
					<tr>
						<th>Tên người nhận</th>
						<th>Địa chi3</th>
						<th>Số điện thoại</th>
                      	<th>Email</th>
						<th>Ghi chú</th>
					</tr>
				</thead>
				<tbody>';

        $output.='
					<tr>
						<td>'.$shipping->shipping_name.'</td>
							<td>'.$shipping->shipping_address.'</td>
						<td>'.$shipping->shipping_phone.'</td>
						<td>'.$shipping->shipping_email.'</td>
                        <td>'.$shipping->shipping_note.'</td>
					</tr>';


        $output.='
				</tbody>

		</table>';
        $output.='
				</tbody>

		</table>

		<p>Đơn hàng đặt</p>
			<table class="table-styling">
				<thead>
					<tr>
						<th>Tên sản phẩm</th>
						<th>Mã giảm giá</th>
						<th>Phí ship</th>
						<th>Số lượng</th>
						<th>Giá sản phẩm</th>
						<th>Thành tiền</th>
					</tr>
				</thead>
				<tbody>';

        $total = 0;

        foreach($order_details_product as $key => $product){

            $subtotal = $product->product_price*$product->product_sales_quantity;
            $total+=$subtotal;

            if($product->product_coupon!='no'){
                $product_coupon = $product->product_coupon;
            }else{
                $product_coupon = 'không mã';
            }

            $output.='
					<tr>
						<td>'.$product->product_name.'</td>
						<td>'.$product_coupon.'</td>
						<td>'.number_format($product->product_feeship,0,',','.').'đ'.'</td>
						<td>'.$product->product_sales_quantity.'</td>
						<td>'.number_format($product->product_price,0,',','.').'đ'.'</td>
						<td>'.number_format($subtotal,0,',','.').'đ'.'</td>

					</tr>';
        }

        if($coupon_condition==1){
            $total_after_coupon = ($total*$coupon_number)/100;
            $total_coupon = $total - $total_after_coupon;
        }else{
            $total_coupon = $total - $coupon_number;
        }

        $output.= '<tr>
				<td colspan="2">
					<p>Tổng giảm: '.$coupon_echo.'</p>
					<p>Phí ship: '.number_format($product->product_feeship,0,',','.').'đ'.'</p>
					<p>Thanh toán : '.number_format($total_coupon + $product->product_feeship,0,',','.').'đ'.'</p>
				</td>
		</tr>';
        $output.='
				</tbody>

		</table>

		<p>Ký tên</p>
			<table>
				<thead>
					<tr>
						<th width="200px">Người lập phiếu</th>
						<th width="800px">Người nhận</th>

					</tr>
				</thead>
				<tbody>';

        $output.='
				</tbody>

		</table>

		';
        return $output;
    }

    public function huy_don_hang(Request $request){
         $data = $request->all();
         $order = Order::where('order_code',$data['id'])->first();
         $order->order_destroy = $data['lydo'];
         $order->order_status = 3;
         $order->save();
    }
}
