

<!-- mobile menu -->


<!--header-->
    @include('include.header')
<!--header-->

<!--main area-->
<main id="main" class="main-site left-sidebar">

    <div class="container">


        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">home</a></li>
                <li class="item-link"><span>Digital & Electronics</span></li>
            </ul>
        </div>



        <div class="row">

            <div class="col-lg-9 col-md-8 col-sm-8 col-xs-12 main-content-area">
                <div class="wrap-main-slide">
                    <div class="slide-carousel owl-carousel style-nav-1" data-items="1" data-loop="1" data-nav="true" data-dots="false">
                      @foreach($slider as $value)
                        <div class="item-slide">
                            <img src="{{asset('public/upload/slider/'.$value->slider_image)}}" alt="{{$value->slider_name}}" class="img-slide">
                        </div>
                        @endforeach
                    </div>
                </div>

                @yield('content')

            </div><!--end main products area-->

            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12 sitebar">
                <div class="widget mercado-widget categories-widget">
                    <h2 class="widget-title">All Categories</h2>
                    <div class="widget-content">
                        <ul class="list-category">
                            @foreach($category_product as $key => $cate)
                            <li class="category-item has-child-cate">
                                <a href="{{URL::to('/danhmucsanpham/'.$cate->category_slug)}}" class="cate-link">{{$cate->category_name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- Categories widget-->

                <div class="widget mercado-widget filter-widget brand-widget">
                    <h2 class="widget-title">Brand</h2>
                    <div class="widget-content">
                        <ul class="list-category">
                            @foreach($brand_product as $key => $brand)
                                <li class="category-item has-child-cate">
                                    <a href="{{URL::to('/thuonghieusanpham/'.$brand->brand_slug)}}" class="cate-link">{{$brand->brand_name}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div><!-- brand widget-->





                <div class="widget mercado-widget filter-widget">

                    <div class="widget-content">

                        <div class="widget-banner">
                            <figure><img src="{{URL::to('public/fontend/images/size-banner-widget.jpg')}}" width="270" height="331" alt=""></figure>
                        </div>
                    </div>
                </div><!-- Size -->

                <div class="widget mercado-widget widget-product">
                    <h2 class="widget-title">Sản phẩm đã xem</h2>
                    <div class="widget-content" id="viewed-row">

                    </div>
                </div><!-- brand widget-->

            </div><!--end sitebar-->

        </div><!--end row-->

    </div><!--end container-->

</main>
<!--main area-->


<!--footer area-->
    @include('include.footer')
<!--footer area-->




