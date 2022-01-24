@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin khách hàng
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>

                        <?php
                        $alert_status = Session::get('alert_status');
                        if ($alert_status){
                            echo '<span style="color: green">'.$alert_status.'</span>';
                            Session::put('alert_status',null);
                        }
                        ?>
                        <th>Tên khách hàng</th>

                        <th>Email</th>
                        <th>Số điện thoại</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                        <tr>


                            <td>{{$customer->customer_name}}</td>
                            <td>{{$customer->customer_email}}</td>
                            <td>{{$customer->customer_phone}}</td>





                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
<br><br>

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin vận chuyển
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>

                    <?php
                    $alert_status = Session::get('alert_status');
                    if ($alert_status){
                        echo '<span style="color: green">'.$alert_status.'</span>';
                        Session::put('alert_status',null);
                    }
                    ?>
                    <th>Tên người vận chuyển</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Hình thức thanh toán</th>
                    <th>Ghi chú</th>

                    <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>


                        <td>{{$shipping->shipping_name}}</td>
                        <td>{{$shipping->shipping_address}}</td>
                        <td>{{$shipping->shipping_phone}}</td>
                        <td>{{$shipping->shipping_email}}</td>
                        <td>
                            @if($shipping->shipping_method == 0)
                                 Tiền mặt
                            @else
                                Chuyến khoản
                            @endif
                        </td>
                        <td>{{$shipping->shipping_note}}</td>



                    </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <br><br>

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê chi tiết đơn hàng
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <?php
                        $alert_status = Session::get('alert_status');
                        if ($alert_status){
                            echo '<span style="color: green">'.$alert_status.'</span>';
                            Session::put('alert_status',null);
                        }
                        ?>
                        <th>Tên sản phẩm</th>
                        <th>Số lượng kho</th>
                        <th>Số lượng</th>
                        <th>Mã giảm giá</th>
                        <th>Phí vận chuyển</th>
                        <th>Gía</th>
                        <th>Tổng tiền</th>
                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                    $i = 0;
                    $total = 0;
                    @endphp
                    @foreach($order_Details as $key => $value)
                        @php
                        $i++;
                        $subtotal = $value->product_price * $value->product_sales_quantity;
                        $total += $subtotal;
                        @endphp
                    <tr class="color_quantity_{{$value->product_id}}">

                        <td><i>{{$i}}</i></td>
                        <td>{{$value->product_name}}</td>
                        <td>{{$value->product->inventory}}</td>
                        <td>



                            <input type="number" min="1"  {{$order_status == 2 ? 'disabled': ''}} class="order_quantity_{{$value->product_id}}" value="{{$value->product_sales_quantity}}" name="product_sales_quantity">

                            <input type="hidden" class="order_product_id" name="order_product_id" value="{{$value->product_id}}">

                            <input type="hidden" class="order_code" name="order_code" value="{{$value->order_code}}">

                            <input type="hidden" class="order_qty_storage_{{$value->product_id}}" name="order_qty_storage" value="{{$value->product->inventory}}">
                            @if($order_status !=2)

                            <button class="btn btn-default update_quantity_order" data-product_id="{{$value->product_id}}" name="update_quantity">Cập nhật</button>

                            @endif
                        </td>

                        <td>
                            @if($value->product_coupon != 'no')
                                {{$value->product_coupon}}
                            @else
                                Không mã
                            @endif
                        </td>
                        <td>{{number_format($value->product_feeship,0,',','.').' VND'}}</td>
                        <td>{{number_format($value->product_price,0,',','.').' VND'}}</td>
                        <td>{{number_format($subtotal,0,',','.').' VND'}}</td>





                    </tr>

                    @endforeach
                    <tr>

                        <td colspan="2">
                            @php
                               $total_coupon = 0;
                            @endphp
                            @if($coupon_condition == 1)
                                @php
                                $total_after_coupon = ($total * $coupon_number)/100;
                                 echo 'Tong giam:' .number_format($total_after_coupon,0,',','.'). 'VND';
                                $total_coupon = $total - $total_after_coupon + $value->product_feeship;
                                @endphp
                            @else
                                @php
                                echo 'Tong giam:' .number_format($coupon_number,0,',','.'). 'VND';
                                    $total_coupon = $total - $coupon_number+ $value->product_feeship;

                                @endphp
                            @endif

                        </td>

                    </tr>
                    <tr >
                        <td colspan="2">  Phí vận chuyển:  {{number_format($value->product_feeship,0,',','.').' VND'}}</td><br>

                    </tr>
                    <tr >

                        <td colspan="2">  Tổng đơn hàng:  {{number_format($total_coupon,0,',','.').'VND'}}</td>
                    </tr>
                    <tr>
                       <td colspan="6">
                           @foreach($order as $key =>$or)
                               @if($or->order_status == 1)
                           <form>
                               @csrf
                               <label for="order">Trạng thái đơn hàng</label>
                               <select class="form-control order_success " id="order">
                                   <option value="">-- Chọn trạng thái đơn hàng</option>
                                   <option id="{{$or->order_id}}" value="2">Đã xủ lý đơn hàng</option>
{{--                                   <option id="{{$or->order_id}}" selected value="1">Chưa xử lý</option>--}}
{{--                                   <option id="{{$or->order_id}}" value="3">Hủy đơn hàng</option>--}}
                               </select>
                           </form>
                               @elseif($or->order_status == 2)
                                   <form>
                                       @csrf
                                       <label for="order">Trạng thái đơn hàng</label>
                                       <select class="form-control order_success">
                                           <option value="">-- Chọn trạng thái đơn hàng</option>
                                           <option id="{{$or->order_id}}" value="1">Chưa xử lý</option>

                                       </select>
                                   </form>

                               @endif
                           @endforeach
                       </td>
                    </tr>
                    </tbody>
                </table>
                <a href="{{url('/print-order/'.$value->order_code)}}" class="btn btn-primary" target="_blank" role="button">In đơn hàng</a>
            </div>

        </div>
    </div>
@endsection


