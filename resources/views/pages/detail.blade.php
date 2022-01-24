@section('title','Details')
@include('include.header')
<!--main area-->
<main id="main" class="main-site">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">Trang chủ</a></li>
                <li class="item-link"><span>Chi tiết sản phẩm</span></li>
            </ul>
        </div>
        <div class="row">

            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                <div class="wrap-product-detail">
                    <div class="detail-media">

                            <ul id="imageGallery">
                                @foreach($gallery as $key => $gal)
                                <li  data-thumb="{{asset('public/upload/gallery/'.$gal->gallery_image)}}" data-src="{{asset('public/upload/gallery/'.$gal->gallery_image)}}">
                                    <img width="100%" src="{{asset('public/upload/gallery/'.$gal->gallery_image)}}" />
                                </li>
                                @endforeach
                            </ul>
{{--                        </div>--}}
                    </div>

                    @foreach($product_details as $key => $value)
                    <div class="detail-info">
                        <div class="product-rating">
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <i class="fa fa-star" aria-hidden="true"></i>
                            <a href="#" class="count-review">(05 review)</a>
                        </div>
                        <h2 class="product-name">{{$value->product_name}}</h2>
                        <div class="short-desc">
                            <ul>
                                <li>{!!$value->product_content!!}</li>

                            </ul>
                        </div>
                        <div class="wrap-social">
                            <a class="link-socail" href="#"><img src="{{asset('public/Fontend/images/social-list.png')}}" alt=""></a>
                        </div>
                        <div class="wrap-price"><span class="product-price" style="color: #d63031">{{number_format($value->product_price).' VND'}}</span></div>
                        <div class="stock-info in-stock">
                            <p class="availability">Availability:
                                @if($value->inventory == 0)
                                <b>Sản phẩm đã hết hàng</b>
                            @else
                                <b>{{$value->inventory}}</b>
                                @endif
                            </p>

                        </div>
                        <form action="{{URL::to('/save-cart')}}" method="POST">
                            @csrf

                            <input type="hidden" id="product_view_id" value="{{$value->product_id}}">
                            <input type="hidden" id="product_view_name{{$value->product_id}}" value="{{$value->product_name}}">
                            <input type="hidden" id="product_view_url{{$value->product_id}}" value="{{url('/chitietsanpham/'.$value->product_id)}}">
                            <input type="hidden" id="product_view_image{{$value->product_id}}" value="{{asset('public/upload/product/'.$value->product_image)}}">
                            <input type="hidden" id="product_view_price{{$value->product_id}}" value="{{$value->product_price}}">
                            @php
                                $cart_session = \Illuminate\Support\Facades\Session::get('cart');
                            @endphp
                            @if($cart_session == null)
                            <input type="hidden" value="{{$value->product_id}}" name="cart_id" class="cart_product_id_{{$value->product_id}}">
                            <input type="hidden" value="{{$value->product_name}}" name="cart_product_name" class="cart_product_name_{{$value->product_id}}">
                            <input type="hidden" value="{{$value->product_image}}" name="cart_product_image" class="cart_product_image_{{$value->product_id}}">
                            <input type="hidden" value="{{$value->inventory}}" name="cart_product_inventory" class="cart_product_inventory_{{$value->product_id}}">
                            <input type="hidden" value="{{$value->product_price}}" name="cart_product_price" class="cart_product_price_{{$value->product_id}}">
                            @else
                                @foreach($cart_session as $key => $cart)
                                    <input type="hidden"  value="{{$cart['product_id']}}" class="cart_id_{{$cart['product_id']}}">
                                @endforeach
                                <input type="hidden" value="{{$value->product_id}}" name="cart_id" class="cart_product_id_{{$value->product_id}}">
                                <input type="hidden" value="{{$value->product_name}}" name="cart_product_name" class="cart_product_name_{{$value->product_id}}">
                                <input type="hidden" value="{{$value->product_image}}" name="cart_product_image" class="cart_product_image_{{$value->product_id}}">
                                <input type="hidden" value="{{$value->inventory}}" name="cart_product_inventory" class="cart_product_inventory_{{$value->product_id}}">
                                <input type="hidden" value="{{$value->product_price}}" name="cart_product_price" class="cart_product_price_{{$value->product_id}}">
                            @endif


                            <div class="quantity">
                                <span>Quantity:</span>
                                <div class="quantity-input" style="width: 66px;">
                                    <input type="number" name="cart_product_qty"  value="1" min="1" class="cart_product_qty_{{$value->product_id}}">




                                </div>
                            </div>
                            <div class="wrap-butons">
                                <button type="button" class="btn add-to-cart" data-id_product="{{$value->product_id}}">
                                    <i class="fa fa-shopping-cart"></i>Thêm vào giỏ hàng</button>
{{--                                <div class="wrap-btn" style="display: flex; ">--}}
{{--                                    <a href="#" class="btn btn-compare" style="font-size: 18px" >So sánh</a>--}}
{{--                                    <a href="#" class="btn btn-wishlist" style="margin-left: 50px;font-size: 18px">Yêu thích</a>--}}
{{--                                </div>--}}
                            </div>

                        </form>

                        <fieldset>
                            <legend>Tags:</legend>
                            <p><i class="fa fa-tag"></i>
                                @php
                                   $tags = $value->product_tags;
                                   $tags = explode(',',$tags);
                                @endphp
                                @foreach($tags as $tag)
                                     <a href="{{url('/tags/'.$tag)}}">{{$tag}}</a>
                                @endforeach
                            </p>
                        </fieldset>
                    </div>

                    @endforeach


                    <div class="advance-info">
                        <div class="tab-control normal">
                            <a href="#description" class="tab-control-item active">description</a>

                            <a href="#review" class="tab-control-item">Reviews</a>
                        </div>
                        <div class="tab-contents">
                            @foreach($product_details as $key => $value)
                            <div class="tab-content-item active" id="description">
                                 <p>{!! $value->product_desc!!}</p>
                            </div>
                            @endforeach

                            <div class="tab-content-item " id="review">

                                <div class="wrap-review-form">
                                <form>
                                    @csrf
                                    @foreach($product_details as $key => $value)
                                        <input type="hidden" name="comment_product_id" class="comment_product_id" value="{{$value->product_id}}" >
                                    @endforeach
                                    <div id="load_comment"></div>

                                </form>

                                    <div id="review_form_wrapper">
                                        <div id="review_form">
                                            <div id="respond" class="comment-respond">

                                                <form action="#" method="post" id="commentform" class="comment-form" novalidate="">
                                                    @csrf
                                                    <p class="comment-notes">
                                                        <span id="email-notes">Your email address will not be published.</span> Required fields are marked <span class="required">*</span>
                                                    </p>
                                                    <div class="comment-form-rating">
                                                        <span>Your rating</span>
                                                        <p class="stars">

                                                            <label for="rated-1"></label>
                                                            <input type="radio" id="rated-1" name="rating" value="1">
                                                            <label for="rated-2"></label>
                                                            <input type="radio" id="rated-2" name="rating" value="2">
                                                            <label for="rated-3"></label>
                                                            <input type="radio" id="rated-3" name="rating" value="3">
                                                            <label for="rated-4"></label>
                                                            <input type="radio" id="rated-4" name="rating" value="4">
                                                            <label for="rated-5"></label>
                                                            <input type="radio" id="rated-5" name="rating" value="5" checked="checked">
                                                        </p>
                                                    </div>
                                                    <p class="comment-form-author">
                                                        <label for="author">Name <span class="required">*</span></label>
                                                        <input id="author" class="comment_name" name="comment_name" type="text" value=""placeholder="Ghi tên bình luận">
                                                    </p>
                                                    <p class="comment-form-email">
                                                        <label for="email">Email <span class="required">*</span></label>
                                                        <input id="email"  class="comment_email" name="comment_email" type="email" value="" placeholder="Nhập địa chỉ email của bạn" >
                                                    </p>
                                                    <p class="comment-form-comment">
                                                        <label for="comment">Your review <span class="required">*</span>
                                                        </label>
                                                        <textarea id="comment" class="comment_content" name="comment_content" cols="110" rows="8" placeholder="Nhập nội dung bình luận"></textarea>
                                                    </p>
                                                    <p class="form-submit">
                                                        <button name="submit" type="button" id="submit" class="btn btn-primary btn-lg send_comment" >Gửi bình luận</button>
                                                    </p>
                                                    <div id="notify_comment"></div>
                                                </form>

                                            </div><!-- .comment-respond-->
                                        </div><!-- #review_form -->
                                    </div><!-- #review_form_wrapper -->

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!--end main products area-->

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                <div class="widget widget-our-services ">
                    <div class="widget-content">
                        <ul class="our-services">

                            <li class="service">
                                <a class="link-to-service" href="#">
                                    <i class="fa fa-truck" aria-hidden="true"></i>
                                    <div class="right-content">
                                        <b class="title">Free Shipping</b>
                                        <span class="subtitle">On Oder Over $99</span>
                                        <p class="desc">Lorem Ipsum is simply dummy text of the printing...</p>
                                    </div>
                                </a>
                            </li>

                            <li class="service">
                                <a class="link-to-service" href="#">
                                    <i class="fa fa-gift" aria-hidden="true"></i>
                                    <div class="right-content">
                                        <b class="title">Special Offer</b>
                                        <span class="subtitle">Get a gift!</span>
                                        <p class="desc">Lorem Ipsum is simply dummy text of the printing...</p>
                                    </div>
                                </a>
                            </li>

                            <li class="service">
                                <a class="link-to-service" href="#">
                                    <i class="fa fa-reply" aria-hidden="true"></i>
                                    <div class="right-content">
                                        <b class="title">Order Return</b>
                                        <span class="subtitle">Return within 7 days</span>
                                        <p class="desc">Lorem Ipsum is simply dummy text of the printing...</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div><!-- Categories widget-->

                <div class="widget mercado-widget widget-product">
                    <h2 class="widget-title">Sản phẩm yêu thích</h2>
                    <div class="widget-content" id="wistlist-row">

                    </div>

                </div>

            </div><!--end sitebar-->

            <div class="single-advance-box col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="wrap-show-advance-info-box style-1 box-in-site">
                    <h3 class="title-box">Sản phẩm liên quan</h3>
                    <div class="wrap-products">
                        <div class="products slide-carousel owl-carousel style-nav-1 equal-container" data-items="5" data-loop="false" data-nav="true" data-dots="false" data-responsive='{"0":{"items":"1"},"480":{"items":"2"},"768":{"items":"3"},"992":{"items":"3"},"1200":{"items":"5"}}' >

                            @foreach($related as $value)
                            <div class="product product-style-2 equal-elem ">
                                <div class="product-thumnail">
                                    <a href="{{URL::to('/chitietsanpham/'.$value->product_id)}}" title="T-Shirt Raw Hem Organic Boro Constrast Denim">
                                        <figure><img src="{{URL::to('public/upload/product/'.$value->product_image)}}" width="214" height="214" alt="T-Shirt Raw Hem Organic Boro Constrast Denim"></figure>
                                    </a>

                                    <div class="wrap-btn">
                                        <a href="#" class="function-link">quick view</a>
                                    </div>
                                </div>
                                <div class="product-info">
                                    <a href="#" class="product-name"><span>{{$value->product_name}}</span></a>
                                    <div class="wrap-price"><ins><p class="product-price">{{number_format($value->product_price).'VND'}}</p></ins> <del></del></div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div><!--End wrap-products-->
                </div>
            </div>

        </div><!--end row-->

    </div><!--end container-->

</main>
<!--main area-->
@include('include.footer')
