@section('title','CheckOut')
@include('include.header')




<!--main area-->
<main id="main" class="main-site">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">Trang chủ</a></li>
                <li class="item-link"><span>Thanh toán</span></li>
            </ul>
        </div>
        @if(session()->has('message'))
            <span style="color: green;">{!! session()->get('message') !!} </span>
        @elseif(session()->has('error'))
            <span style="color: red;">{!! session()->get('error') !!} </span>
        @endif

        @if (Session::get('cart') == null)
            <span style="color: red;font-size: 24px;">Đặt hàng thành công ,chúng tôi sẻ liên hệ với bạn kho giảo hàng </span>
        @else
            <div class=" main-content-area">
                @if(Session::get('fee'))
                <form action="#" method="get" name="frm-billing">
                    @csrf
                <div class="wrap-address-billing">
                    <h3 class="box-title">Thông tin người nhận hàng</h3>

                        {{csrf_field()}}
                        <p class="row-in-form">
                            <label for="fname">Họ và tên<span>*</span></label>
                            <input id="fname" class="shipping_name" type="text" name="shipping_name" value="" placeholder="Your name" required>
                        </p>

                        <p class="row-in-form">
                            <label for="email">Thông tin Email:</label>
                            <input id="email" type="email" class="shipping_email" type="email" name="shipping_email" value="" required placeholder="Type your email">
                        </p>
                        <p class="row-in-form">
                            <label for="phone">Số điện thoại:<span>*</span></label>
                            <input id="phone" class="shipping_phone" type="number" name="shipping_phone" value="" placeholder="10 digits format" required>
                        </p>
                        <p class="row-in-form">
                            <label for="add">Địa chỉ:</label>
                            <input id="add" class="shipping_address" type="text" name="shipping_address" value="" placeholder="Street at apartment number" required>
                        </p>

                        <p class="row-in-form">
                            <label for="city">Ghi chú đơn hàng<span>*</span></label>
                            <textarea class="shipping_note" rows="2" cols="77"  placeholder="Ghi chú đơn hàng" name="shipping_note" required></textarea>
                        </p>
                    <p class="row-in-form">
                        <label for="exampleInputPassword1">Chọn hình thức thanh toán</label>
                        <select class="form-control payment_select "  name="payment_select">
                            <option value="0">Thanh toán bằng tiền mặt </option>
                            <option value="1">Thanh toán bằng chuyển khoản </option>

                        </select>


                    <div id="paypal-button"></div>

                    </p>
                    @if(Session::get('fee'))
                        <input type="hidden" name="order_fee" class="order_fee" value="{{Session::get('fee')}}">
                    @else
                    <input type="hidden" name="order_fee" class="order_fee" value="200000">
                    @endif

                    @if(Session::get('coupon'))
                          @foreach(Session::get('coupon') as $key => $cou)
                            <input type="hidden" name="order_coupon" class="order_coupon" value="{{$cou['coupon_code']}}">
                          @endforeach
                    @else
                        <input type="hidden" name="order_coupon" class="order_coupon" value="no">
                     @endif


                        <p class="row-in-form">

                            <input type="button"   value="Xác nhận đơn hàng" name="send_order" class="btn btn-primary btn-sm send_order">
                        </p>


                </div>
                </form><br>
                @endif




                <form>
                    {{csrf_field()}}

                    <div class="form-group">
                        <label for="exampleInputPassword1">Chọn thành phố</label>
                        <select name="city" id="city" class="form-control choose city">

                            <option value="">--Chọn tỉnh thành phố--</option>
                            @foreach($city as $key => $ci)
                                <option value="{{$ci->matp}}">{{$ci->name_city}}</option>
                            @endforeach

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Chọn quận huyện</label>
                        <select name="province" id="province" class="form-control  province choose" required>
                            <option value="">--Chọn quận huyện--</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Chọn xã phường</label>
                        <select name="wards" id="wards" class="form-control  wards" required>
                            <option value="">--Chọn xã phường--</option>
                        </select>
                    </div>


                    <input type="button" value="TÍnh phí vận chuyển" name="calculate_order" class="btn btn-primary btn-sm calculate_delivery">


                </form>
                    </div>
  <?php


?>


                <div style="margin-top: 20px"></div>
                <div class=" main-content-area">
                    <form action="{{url('/update-cart-ajax')}}" method="POST">
                        {{csrf_field()}}
                        <div class="wrap-iten-in-cart">
                            <h3 class="box-title">Products Name</h3>
                            <ul class="products-cart">


                                @php
                                    $total = 0;
                                     $total_coupon = 0;
                                       $total_after_coupon = 0;
                                @endphp
                                @foreach(\Illuminate\Support\Facades\Session::get('cart') as $key => $value)
                                    @php
                                        $subtotal = $value['product_price'] * $value['product_qty'];
                                        $total += $subtotal;
                                    @endphp

                                    <li class="pr-cart-item">
                                        <div class="product-image">
                                            <figure><img src="{{asset('public/upload/product/'.$value['product_image'])}}" alt=""></figure>
                                        </div>
                                        <div class="product-name">
                                            <a class="link-to-product" href="#">{{$value['product_name']}}</a>
                                        </div>
                                        <div class="price-field produtc-price"><p class="price">{{number_format($value['product_price'],0,',','.')}}VND</p></div>
                                        <div class="quantity">

                                            <div class="quantity-input">
                                                <input type="number"  name="cart_quatity[{{$value['session_id']}}]" class="cart_quantity" value="{{$value['product_qty']}}" data-max="120" min="1" pattern="[0-9]*" >

                                            </div>
                                        </div>
                                        <div class="price-field sub-total"><p class="price">  {{number_format($subtotal,0,',','.')}}VND</p></div>
                                        <div class="price-field produtc-price">
                                            <a href="{{url('/delete-ajax/'.$value['session_id'])}}" class="btn btn-delete" title="">

                                                <i class="fa fa-times-circle" style="font-size: 30px"></i>
                                            </a>
                                        </div>
                                    </li>

                                @endforeach
                            </ul>
                        </div>



                        <div class="summary">
                            <div class="order-summary">
                                <h4 class="title-box">Order Summary</h4>
                                <p class="summary-info"><span class="title">Giá sản phẩm</span><b class="index">{{number_format($total,0,',','.')}}VND</b></p>
                                @if(\Illuminate\Support\Facades\Session::get('coupon'))
                                    <p class="summary-info"><span class="title">Số tiền giảm</span>
                                        <b class="index">
                                            @if(\Illuminate\Support\Facades\Session::get('coupon'))
                                                @foreach(\Illuminate\Support\Facades\Session::get('coupon') as $key =>$cou)
                                                    @if($cou['coupon_condition'] == 1)
                                                        {{$cou['coupon_number']}} %
                                                    @elseif($cou['coupon_condition'] == 2)
                                                        {{number_format($cou['coupon_number'],0,',', '.')}} VND
                                                    @endif
                                                @endforeach
                                            @endif
                                        </b>
                                    </p>

                                    <p class="summary-info"><span class="title">Tổng đã giảm</span>
                                        <b class="index">
                                            @if(\Illuminate\Support\Facades\Session::get('coupon'))
                                                @foreach(\Illuminate\Support\Facades\Session::get('coupon') as $key =>$cou)
                                                    @if($cou['coupon_condition'] == 1)
                                                        @php
                                                            $total_coupon = $total - ($total * $cou['coupon_number'])/100;
                                                        $total_after_coupon = $total - $total_coupon;
                                                            echo number_format($total_coupon,0,',','.')." VND";
                                                        @endphp
                                                        @php
                                                            $total_after_coupon = $total_coupon;
                                                        @endphp
                                                    @elseif($cou['coupon_condition'] == 2)
                                                        @php
                                                            $total_coupon = $total - $cou['coupon_number'];
                                                            echo number_format($total_coupon,0,',','.') ." VND";
                                                        @endphp
                                                        @php
                                                            $total_after_coupon = $total_coupon;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            @endif
                                        </b>
                                    </p>
                                @else
                                    @php
                                        echo '';
                                    @endphp
                                @endif

                                @if(Session::get('fee'))
                                <p class="summary-info"><span class="title">Phí vận chuyển</span><b class="index"> {{number_format(Session::get('fee'),0,',','.')}}VND</b></p>

                                @endif
                                <?php
                                $total_after_fee = $total + Session::get('fee');
                                ?>

                                <p class="summary-info"><span class="title">Thuế</span><b class="index">0</b></p>
                                <p class="summary-info total-info "><b class="title">Tổng đơn hàng</b>
                                    <b class="index">
                                        @php
                                            if(Session::get('fee') && !Session::get('coupon')){
                                                $total_after = $total_after_fee;
                                                echo number_format($total_after,0,',','.').'VND';
                                            }elseif(!Session::get('fee') && Session::get('coupon')){
                                                $total_after = $total_after_coupon;
                                                echo number_format($total_after,0,',','.').'VND';
                                            }elseif(Session::get('fee') && Session::get('coupon')){
                                                $total_after = $total_after_coupon;
                                                $total_after = $total_after + Session::get('fee');
                                                echo number_format($total_after,0,',','.').'VND';
                                            }elseif(!Session::get('fee') && !Session::get('coupon')){
                                                $total_after = $total;
                                                echo number_format($total_after,0,',','.').'VND';
                                            }

                                        @endphp

                                        @php
                                             $vnd_to_usd = $total_after/23050;

                                        @endphp
                                        <input type="hidden" id="vnd_to_usd" value="{{round($vnd_to_usd,2)}}">
                                    </b>
                                </p>
                            </div>
                            <div class="checkout-info">



                                <a class="link-to-shop" href="{{url('/')}}">Tiếp tục mua hàng<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                            </div>
                            <div class="update-clear">
                                <a class="btn btn-clear" href="{{url('/del-all-cart')}}">Xóa tất cả</a>
                                @if(\Illuminate\Support\Facades\Session::get('coupon'))
                                    <a class="btn btn-clear" href="{{url('/unset-coupon')}}">Xóa mã khuyến mãi</a>
                                @endif
                                @if(\Illuminate\Support\Facades\Session::get('fee'))
                                    <a class="btn btn-clear" href="{{url('/unset-fee')}}">Xóa phí vận chuyển</a>
                                @endif
                                <input type="submit" class="btn " value="Cập nhật" name="update_quantity">
                            </div>
                        </div>
                    </form>




                    <div class="summary summary-checkout">

                        <div class="summary-item shipping-method">
                            <h4 class="title-box f-title">Shipping method</h4>
                            <p class="summary-info"><span class="title">Flat Rate</span></p>
                            <p class="summary-info"><span class="title">Fixed $50.00</span></p>
                            <h4 class="title-box">Discount Codes</h4>
                            <form method="POST" action="{{url('/check-coupon')}}">
                                @csrf
                                <p class="row-in-form">
                                    <label for="coupon-code">Enter Your Coupon code:</label>

                                    <input id="coupon-code" type="text"  name="coupon_name"   placeholder="Nhập mả giảm giá">
                                </p>
                                <input type="submit" class="btn btn-small" name="check_coupon" value="Apply"/>
                            </form>
                        </div>

                    </div>
                    @endif


                </div><!--end main content area-->
            </div><!--end container-->

</main>
<!--main area-->
<!--main area-->
@include('include.footer')
