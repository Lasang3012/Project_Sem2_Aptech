@section('title','Cart')
@include('include.header')




<!--main area-->
{{-- @php--}}
{{--   dd(Session::get('cart'))--}}
{{-- @endphp--}}
<main id="main" class="main-site">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">home</a></li>
                <li class="item-link"><span>login</span></li>
            </ul>
        </div>
          @if(session()->has('message'))
            <span style="color: green;">{!! session()->get('message') !!} </span>
          @elseif(session()->has('error'))
            <span style="color: red;">{!! session()->get('error') !!} </span>
          @endif
        <br>
        @if (Session::get('cart') == null)
            <span style="color: red;font-size: 24px;">Bạn chưa có giao dịch nào</span>
        @else

            <div class=" main-content-area">
                <form action="{{url('/update-cart-ajax')}}" method="POST">
                    {{csrf_field()}}
                    <div class="wrap-iten-in-cart">
                        <h3 class="box-title">Products Name</h3>
                        <ul class="products-cart">


                                @php
                                    $total = 0;
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
                                            <a class="link-to-product" href="{{url('/chitietsanpham/'.$value['product_id'])}}">{{$value['product_name']}}</a>
                                        </div>
{{--                                        <div class="price-field produtc-price"><p class="price">{{$value['product_inventory']}}</p></div>--}}
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
                    @php
                        $total_coupon = 0;
                    @endphp
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
                                                  echo number_format($total_coupon,0,',','.')." VND";
                                                @endphp
                                            @elseif($cou['coupon_condition'] == 2)
                                                @php
                                                    $total_coupon = $total - $cou['coupon_number'];
                                                    echo number_format($total_coupon,0,',','.') ." VND";
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

                            <p class="summary-info total-info "><b class="title">Tổng đơn hàng</b>
                                <b class="index">
                                    @if(\Illuminate\Support\Facades\Session::get('coupon'))
                                    {{number_format($total_coupon,0,',','.')}}VND
                                    @else
                                     {{number_format($total,0,',','.')}}VND
                                    @endif
                                </b>
                            </p>
                        </div>
                        <div class="checkout-info">


                            <a class="btn btn-checkout" href="{{url('/checkout')}}">Thanh toán</a>
                            <a class="link-to-shop" href="{{url('/')}}">Tiếp tục mua hàng<i class="fa fa-arrow-circle-right" aria-hidden="true"></i></a>
                        </div>
                        <div class="update-clear">
                            <a class="btn btn-clear" href="{{url('/del-all-cart')}}">Xóa tất cả</a>
                            @if(\Illuminate\Support\Facades\Session::get('coupon'))
                                <a class="btn btn-clear" href="{{url('/unset-coupon')}}">Xóa mã khuyến mãi</a>
                            @endif
                            <input type="submit" class="btn " value="Cập nhật" name="update_quantity">
                        </div>
                    </div>
                </form>
                <div class="summary-item shipping-method">

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
                <div class="wrap-show-advance-info-box style-1 box-in-site">
                    <h3 class="title-box">Sản phẩm mới nhất</h3>
                    <div class="wrap-products">
                        <div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}' >

                            @foreach($for_export_product as $key => $value)
                            <div class="product product-style-2 equal-elem ">
                                <div class="product-thumnail">
                                    <a href="{{URL::to('/chitietsanpham/'.$value->product_id)}}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                        <figure><img src="{{asset('public/upload/product/'.$value->product_image)}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                    </a>
                                    <div class="group-flash">
                                        <span class="flash-item new-label">new</span>
                                    </div>
                                    <div class="wrap-btn">
                                        <a href="#" class="function-link">quick view</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <a href="#" class="product-name"><span>{{$value->product_name}}</span></a>
                                    <div class="wrap-price"><span class="product-price">{{number_format($value->product_price,0,',','.')}} VND</span></div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div><!--End wrap-products-->
                </div>

            </div><!--end main content area-->
        </div><!--end container-->

</main>
<!--main area-->
<!--main area-->
@include('include.footer')
