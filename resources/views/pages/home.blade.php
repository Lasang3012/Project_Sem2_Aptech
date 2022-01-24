@extends('layout')
@section('title','Home')
@section('content')

    <style>
        button.btn.add-to-cart {
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
        }

        .w-5 {
            display: none;
        }
    </style>

    <div class="wrap-shop-control">

        <h1 class="shop-title">Latest product</h1>


    </div><!--end wrap shop control-->






    <!--end wrap shop control-->

    <div class="row">


        <ul class="product-list grid-products equal-container">
            @foreach($latest_product as $key => $latest)
                <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                    <div class="product product-style-3 equal-elem ">
                        <form method="POST">
                            @csrf
                            @php
                                $cart_session = \Illuminate\Support\Facades\Session::get('cart');
                            @endphp
                            @if($cart_session == null)
                                <input type="hidden" value="{{$latest->product_id}}"
                                       class="cart_product_id_{{$latest->product_id}}">
                                <input type="hidden" id="wishlist_product_name_{{$latest->product_id}}"
                                       value="{{$latest->product_name}}"
                                       class="cart_product_name_{{$latest->product_id}}">
                                <input type="hidden" value="{{$latest->product_image}}"
                                       class="cart_product_image_{{$latest->product_id}}">
                                <input type="hidden" id="wishlist_product_price_{{$latest->product_id}}"
                                       value="{{$latest->product_price}}"
                                       class="cart_product_price_{{$latest->product_id}}">
                                <input type="hidden" value="{{$latest->inventory}}" name="cart_product_inventory"
                                       class="cart_product_inventory_{{$latest->product_id}}">
                                <input type="hidden" value="1" class="cart_product_qty_{{$latest->product_id}}">

                            @else
                              @foreach($cart_session as $key => $value)
                               <input type="hidden"  value="{{$value['product_id']}}" class="cart_id_{{$value['product_id']}}">
                                <input type="hidden" value="{{$latest->product_id}}"
                                       class="cart_product_id_{{$latest->product_id}}">
                                <input type="hidden" id="wishlist_product_name_{{$latest->product_id}}"
                                       value="{{$latest->product_name}}"
                                       class="cart_product_name_{{$latest->product_id}}">
                                <input type="hidden" value="{{$latest->product_image}}"
                                       class="cart_product_image_{{$latest->product_id}}">
                                <input type="hidden" id="wishlist_product_price_{{$latest->product_id}}"
                                       value="{{$latest->product_price}}"
                                       class="cart_product_price_{{$latest->product_id}}">
                                <input type="hidden" value="{{$latest->inventory}}" name="cart_product_inventory"
                                       class="cart_product_inventory_{{$latest->product_id}}">
                                <input type="hidden" value="1" class="cart_product_qty_{{$latest->product_id}}">
                                @endforeach
                            @endif


                            <div class="product-thumnail">
                                <a href="{{URL::to('/chitietsanpham/'.$latest->product_id)}}"
                                   id="wishlist_product_url_{{$latest->product_id}}"
                                   title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img id="wishlist_product_image_{{$latest->product_id}}"
                                                 src="{{URL::to('public/upload/product/'.$latest->product_image)}}"
                                                 alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>{{$latest->product_name}}</span></a>
                                <div class="wrap-price"><span
                                        class="product-price">{{number_format($latest->product_price,0,',','.').' VND'}}</span>
                                </div>
                                <button type="button" name="add_to_cart" data-id_product="{{$latest->product_id}}"
                                        class="btn add-to-cart">Thêm vào giỏ hàng
                                </button>

                            </div>


                            <button type="button" class="btn btn-wishlist button-wishlist" id="{{$latest->product_id}}"
                                    onclick="add(this.id);"><i class="fa fa-plus-square"><span>Yêu thích</span></i>
                            </button>
                        </form>
                    </div>
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
