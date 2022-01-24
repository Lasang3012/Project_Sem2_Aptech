@extends('layout')

@foreach($category_name as $key => $name)
    @section('title',$name->category_name)
@endforeach
@section('content')
    <div class="wrap-shop-control">
       @foreach($category_name as $key => $name)
        <h3 class="shop-title" style="font-size: 20px; color: #e74c3c;">{{$name->category_name}}</h3>

        @endforeach
           <div class="wrap-right">

               <div class="sort-item orderby ">
                   <form>
                       @csrf
                       <select name="sort" id="sort" class="use-chosen" >
                           <option value="{{Request::url()}}?sort_by=none" selected="selected">Lọc</option>
                           <option value="{{Request::url()}}?sort_by=tang-dan">--Giá tăng dần--</option>
                           <option value="{{Request::url()}}?sort_by=giam-dan">--Giá giảm dần--</option>
                           <option value="{{Request::url()}}?sort_by=kytuA-Z">Lọc theo tên A-Z</option>
                           <option value="{{Request::url()}}?sort_by=kytuZ-A">lọc theo tên Z-A</option>
                       </select>
                   </form>

               </div>

               <div class="sort-item product-per-page">
                   <div class="widget-content">
                       <form>
                       <div id="slider-range"></div>
                       <p>

                           <label for="amount">Price:</label>

                           <input type="text" id="amount_start" readonly style="max-width: 200px">
                           <input type="text" id="amount_end" readonly style="max-width: 200px">
                           <input type="hidden" name="start_price" id="start_price">
                           <input type="hidden" name="end_price" id="end_price">
                           <button type="submit" name="filter_price" class=" filter_price">Filter</button>
                       </p>
                       </form>

                   </div>
               </div>



           </div>

    </div><!--end wrap shop control-->

    <div class="row">

        <ul class="product-list grid-products equal-container">
            @foreach($category_by_id as $key => $cate)
                <li class="col-lg-4 col-md-6 col-sm-6 col-xs-6 ">
                    <div class="product product-style-3 equal-elem ">
                        <form method="POST">
                            @csrf
                            @php
                                $cart_session = \Illuminate\Support\Facades\Session::get('cart');
                            @endphp
                            @if($cart_session == null)
                                <input type="hidden" value="{{$cate->product_id}}" class="cart_product_id_{{$cate->product_id}}">
                                <input type="hidden" id="wishlist_product_name_{{$cate->product_id}}" value="{{$cate->product_name}}" class="cart_product_name_{{$cate->product_id}}">
                                <input type="hidden" value="{{$cate->product_image}}" class="cart_product_image_{{$cate->product_id}}">
                                <input type="hidden" id="wishlist_product_price_{{$cate->product_id}}" value="{{$cate->product_price}}" class="cart_product_price_{{$cate->product_id}}">
                                <input type="hidden" value="{{$cate->inventory}}" name="cart_product_inventory" class="cart_product_inventory_{{$cate->product_id}}">
                                <input type="hidden" value="1" class="cart_product_qty_{{$cate->product_id}}">
                            @else
                                @foreach($cart_session as $key => $value)
                                    <input type="hidden"  value="{{$value['product_id']}}" class="cart_id_{{$value['product_id']}}">
                                @endforeach
                                <input type="hidden" value="{{$cate->product_id}}" class="cart_product_id_{{$cate->product_id}}">
                                <input type="hidden" id="wishlist_product_name_{{$cate->product_id}}" value="{{$cate->product_name}}" class="cart_product_name_{{$cate->product_id}}">
                                <input type="hidden" value="{{$cate->product_image}}" class="cart_product_image_{{$cate->product_id}}">
                                <input type="hidden" id="wishlist_product_price_{{$cate->product_id}}" value="{{$cate->product_price}}" class="cart_product_price_{{$cate->product_id}}">
                                <input type="hidden" value="{{$cate->inventory}}" name="cart_product_inventory" class="cart_product_inventory_{{$cate->product_id}}">
                                <input type="hidden" value="1" class="cart_product_qty_{{$cate->product_id}}">
                            @endif


                        <div class="product-thumnail">
                            <a href="{{URL::to('/chitietsanpham/'.$cate->product_id)}}" id="wishlist_product_url_{{$cate->product_id}}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                <figure><img id="wishlist_product_image_{{$cate->product_id}}" src="{{URL::to('public/upload/product/'.$cate->product_image)}}" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                            </a>
                        </div>
                        <div class="product-info">
                            <a href="#" class="product-name"><span>{{$cate->product_name}}</span></a>
                            <div class="wrap-price"><span class="product-price">{{number_format($cate->product_price,0,',','.').'VND'}}</span></div>
                            <button type="button" name="add_to_cart" data-id_product="{{$cate->product_id}}" class="btn add-to-cart">Thêm vào giỏ hàng</button>
                            <button type="button" class="btn btn-wishlist button-wishlist" id="{{$cate->product_id}}" onclick="add(this.id);"><i class="fa fa-plus-square"><span>Yêu thích</span></i></button>

                        </div>
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

                        </form>
                    </div>

                </li>
            @endforeach

        </ul>

    </div>
    <div class="wrap-pagination-info">
        <ul class="page-numbers" style="font-size: 26px">


            {!! $category_by_id->links() !!}


        </ul>
        <p class="result-count">Showing 1-8 of 12 result</p>
    </div>

@endsection

