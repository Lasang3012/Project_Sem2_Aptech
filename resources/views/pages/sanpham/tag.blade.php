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
        .w-5{
            display: none;
        }
    </style>

    <div class="wrap-shop-control">

        <h1 class="shop-title">Sản phẫm tag : {{$product_tag}}</h1>



    </div><!--end wrap shop control-->

    <div class="row">

        <ul class="product-list grid-products equal-container">
            @foreach($tags as $key => $tag)
                <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                    <div class="product product-style-3 equal-elem ">
                        <form method="POST">
                            @csrf
                            <input type="hidden" value="{{$tag->product_id}}" class="cart_product_id_{{$tag->product_id}}">
                            <input type="hidden" value="{{$tag->product_name}}" class="cart_product_name_{{$tag->product_id}}">
                            <input type="hidden" value="{{$tag->product_image}}" class="cart_product_image_{{$tag->product_id}}">
                            <input type="hidden" value="{{$tag->product_price}}" class="cart_product_price_{{$tag->product_id}}">
                            <input type="hidden" value="{{$tag->inventory}}" name="cart_product_inventory" class="cart_product_inventory_{{$tag->product_id}}">
                            <input type="hidden" value="1" class="cart_product_qty_{{$tag->product_id}}">

                            <div class="product-thumnail">
                                <a href="{{URL::to('/chitietsanpham/'.$tag->product_id)}}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                    <figure><img src="{{URL::to('public/upload/product/'.$tag->product_image)}}" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                </a>
                            </div>
                            <div class="product-info">
                                <a href="#" class="product-name"><span>{{$tag->product_name}}</span></a>
                                <div class="wrap-price"><span class="product-price">{{number_format($tag->product_price,0,',','.').' VND'}}</span></div>
                                <button type="button" name="add_to_cart" data-id_product="{{$tag->product_id}}" class="btn add-to-cart">Thêm vào giỏ hàng</button>

                            </div>
                        </form>



                    </div>
                    <div class="wrap-btn">
                        <a href="#" class="btn btn-compare">Add Compare</a>
                        <a href="#" class="btn btn-wishlist">Add Wishlist</a>
                    </div>

                </li>

            @endforeach

        </ul>

    </div>

    <div class="wrap-pagination-info">
        <ul class="page-numbers" style="font-size: 26px">


{{--            {!! $latest_product->links() !!}--}}


        </ul>
        <p class="result-count">Showing 1-8 of 12 result</p>
    </div>
@endsection

