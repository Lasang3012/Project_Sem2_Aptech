@extends('layout')
@foreach($get_name_brand as $key => $brand_name)
    @section('title',$brand_name->brand_name)
@endforeach
@section('content')
    <div class="wrap-shop-control">
        @foreach($get_name_brand as $key => $brand_name)
        <h1 class="shop-title" style="font-size: 30px; color: #e74c3c;">{{$brand_name->brand_name}}</h1>
        @endforeach


    </div><!--end wrap shop control-->

    <div class="row">
        @php
            $cart_session = \Illuminate\Support\Facades\Session::get('cart');
        @endphp
        <ul class="product-list grid-products equal-container">
            @foreach($brand_by_id as $key => $brand)
                <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                    <form method="POST">
                        @csrf

                        @if($cart_session == null)
                            <input type="hidden" value="{{$brand->product_id}}" class="cart_product_id_{{$brand->product_id}}">
                            <input type="hidden" id="wishlist_product_name_{{$brand->product_id}}" value="{{$brand->product_name}}" class="cart_product_name_{{$brand->product_id}}">
                            <input type="hidden" value="{{$brand->product_image}}" class="cart_product_image_{{$brand->product_id}}">
                            <input type="hidden" id="wishlist_product_price_{{$brand->product_id}}" value="{{($brand->product_price)}}" class="cart_product_price_{{$brand->product_id}}">
                            <input type="hidden" value="{{$brand->inventory}}" name="cart_product_inventory" class="cart_product_inventory_{{$brand->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$brand->product_id}}">
                        @else
                            @foreach($cart_session as $key => $value)
                                <input type="hidden"  value="{{$value['product_id']}}" class="cart_id_{{$value['product_id']}}">
                            @endforeach
                            <input type="hidden" value="{{$brand->product_id}}" class="cart_product_id_{{$brand->product_id}}">
                            <input type="hidden" id="wishlist_product_name_{{$brand->product_id}}" value="{{$brand->product_name}}" class="cart_product_name_{{$brand->product_id}}">
                            <input type="hidden" value="{{$brand->product_image}}" class="cart_product_image_{{$brand->product_id}}">
                            <input type="hidden" id="wishlist_product_price_{{$brand->product_id}}" value="{{($brand->product_price)}}" class="cart_product_price_{{$brand->product_id}}">
                            <input type="hidden" value="{{$brand->inventory}}" name="cart_product_inventory" class="cart_product_inventory_{{$brand->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$brand->product_id}}">


                        @endif


                    <div class="product product-style-3 equal-elem ">
                        <div class="product-thumnail">
                            <a href="{{URL::to('/chitietsanpham/'.$brand->product_id)}}" id="wishlist_product_url_{{$brand->product_id}}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                <figure><img id="wishlist_product_image_{{$brand->product_id}}" src="{{URL::to('public/upload/product/'.$brand->product_image)}}" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="#" class="product-name"><span>{{$brand->product_name}}</span></a>
                            <div class="wrap-price"><span class="product-price">{{number_format($brand->product_price,0,',','.').'VND'}}</span></div>
                            <button type="button" name="add_to_cart" data-id_product="{{$brand->product_id}}" class="btn add-to-cart">Thêm vào giỏ hàng</button>
                            <button type="button" class="btn btn-wishlist button-wishlist" id="{{$brand->product_id}}" onclick="add(this.id);"><i class="fa fa-plus-square"><span>Yêu thích</span></i></button>

                        </div>
                    </div>
                    </form>

                    <div class="wrap-btn">
                        <style>
                            .button-wishlist{
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
                            }
                            .button-wishlist span:hover{
                                color:#FE980F;
                            }
                            .button-wishlist:focus{
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


