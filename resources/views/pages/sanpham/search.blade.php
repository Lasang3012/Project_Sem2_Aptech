@extends('layout')
@section('content')
    <div class="wrap-shop-control">

            <h1 class="shop-title" style="font-size: 30px; color: #e74c3c;">Kết quả tìm kiếm</h1>



    </div><!--end wrap shop control-->

    <div class="row">

        <ul class="product-list grid-products equal-container">
            @foreach($search_product as $key => $search)
                <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                    <form method="POST">
                        @php
                            $cart_session = \Illuminate\Support\Facades\Session::get('cart');
                        @endphp
                        @csrf
                    <div class="product product-style-3 equal-elem ">
                        @if($cart_session == null)
                        <input type="hidden"  value="{{$search->product_id}}" class="cart_product_id_{{$search->product_id}}">
                        <input type="hidden" id="wishlist_product_name_{{$search->product_id}}" value="{{$search->product_name}}" class="cart_product_name_{{$search->product_id}}">
                        <input type="hidden"  value="{{$search->product_image}}" class="cart_product_image_{{$search->product_id}}">
                        <input type="hidden" id="wishlist_product_price_{{$search->product_id}}" value="{{$search->product_price}}" class="cart_product_price_{{$search->product_id}}">
                        <input type="hidden" value="{{$search->inventory}}" name="cart_product_inventory" class="cart_product_inventory_{{$search->product_id}}">
                        <input type="hidden" value="1" class="cart_product_qty_{{$search->product_id}}">
                        @else
                            @foreach($cart_session as $key => $value)
                                <input type="hidden"  value="{{$value['product_id']}}" class="cart_id_{{$value['product_id']}}">
                            @endforeach
                            <input type="hidden"  value="{{$search->product_id}}" class="cart_product_id_{{$search->product_id}}">
                            <input type="hidden" id="wishlist_product_name_{{$search->product_id}}" value="{{$search->product_name}}" class="cart_product_name_{{$search->product_id}}">
                            <input type="hidden"  value="{{$search->product_image}}" class="cart_product_image_{{$search->product_id}}">
                            <input type="hidden" id="wishlist_product_price_{{$search->product_id}}" value="{{$search->product_price}}" class="cart_product_price_{{$search->product_id}}">
                            <input type="hidden" value="{{$search->inventory}}" name="cart_product_inventory" class="cart_product_inventory_{{$search->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$search->product_id}}">
                        @endif
                        <div class="product-thumnail">
                            <a href="{{URL::to('/chitietsanpham/'.$search->product_id)}}" id="wishlist_product_url_{{$search->product_id}}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                <figure><img id="wishlist_product_image_{{$search->product_id}}" src="{{URL::to('public/upload/product/'.$search->product_image)}}" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="#" class="product-name"><span>{{$search->product_name}}</span></a>
                            <div class="wrap-price"><span class="product-price">{{number_format($search->product_price,0,',','.').' VND'}}</span></div>
                            <button type="button" name="add_to_cart" data-id_product="{{$search->product_id}}" class="btn add-to-cart">Thêm vào giỏ hàng</button>
                            <button type="button" class="btn btn-wishlist button-wishlist" id="{{$search->product_id}}" onclick="add(this.id);"><i class="fa fa-plus-square"><span>Yêu thích</span></i></button>

                        </div>

                    </div>
                    </form>
                    <div class="wrap-btn">
                        <style>
                            .button-wishlist {
                                display: inline-block;
                                width: 100%;
                                font-size: 14px;
                                line-height: 34px;
                                color: #888888;
                                background: #f5f5f5;
                                border: 1px solid #e6e6e6;
                                text-align: center;
                                font-weight: 600;
                                border-radius: 0;
                                padding: 2px 10px;
                                margin-top: 10px;
                                outline: none;
                            }

                            .button-wishlist span:hover {
                                color: #FE980F;
                            }

                            .button-wishlist:focus {
                                border: none;
                                outline: none;
                            }
                        </style>

                    </div>
                </li>
            @endforeach

        </ul>

    </div>


@endsection


