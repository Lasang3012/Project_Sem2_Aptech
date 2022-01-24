<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('public/Fontend/images/favicon.ico')}}">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic,900,900italic&amp;subset=latin,latin-ext" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open%20Sans:300,400,400italic,600,600italic,700,700italic&amp;subset=latin,latin-ext" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('public/Fontend/css/animate.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/Fontend/css/font-awesome.min.css')}}">
{{--    <link rel="stylesheet" type="text/css" href="{{asset('public/Fontend/css/bootstrap.min.css')}}">--}}
    <link rel="stylesheet" type="text/css" href="{{asset('public/Fontend/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/Fontend/css/chosen.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/Fontend/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/Fontend/css/color-01.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('public/Fontend/css/sweetalert.css')}}">
    <link rel="stylesheet"type="text/css" href="{{asset('public/Fontend/css/lightslider.css')}}" />
    <link rel="stylesheet"type="text/css" href="{{asset('public/Fontend/css/prettify.css')}}" />
    <link rel="stylesheet"type="text/css" href="{{asset('public/Fontend/css/lightgallery.min.css')}}" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
{{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style>
    .dropbtn {
        background-color: #444444;
        color: white;
        padding: 10px;
        font-size: 16px;
        font-weight: 600;
        border: none;
    }

    .dropdown {
        position: relative;
        display: inline-block;
        top: 0;
        z-index: 999;

    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 180px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px ;
        text-decoration: none;
        display: block;
    }

    /*.dropdown-content a:hover {background-color: #f1f1f1;}*/

    .dropdown:hover .dropdown-content {display: block;}

    .dropdown:hover .dropbtn {background-color: rgba(0,0,0,0);}
</style>
<body class="home-page home-01 " >

<!-- mobile menu -->
<div class="mercado-clone-wrap">
    <div class="mercado-panels-actions-wrap">
        <a class="mercado-close-btn mercado-close-panels" href="#">x</a>
    </div>
    <div class="mercado-panels"></div>
</div>

<!--header-->
<header id="header" class="header header-style-1">

    <div class="container-fluid">
        <div class="row">
            <div class="topbar-menu-area">
                <div class="container">
                    <div class="topbar-menu left-menu">
                        <ul>
                            <li class="menu-item" >
                                <a title="Hotline: (+123) 456 789" href="#" ><span class="icon label-before fa fa-mobile"></span>Hotline: (+123) 456 789</a>
                            </li>
                        </ul>
                    </div>
                    <div class="topbar-menu right-menu">
                        <ul>

                            <?php
                               $customer_id = \Illuminate\Support\Facades\Session::get('customer_id');
                               if ($customer_id != null){

                            ?>

                                <li class="menu-item" >
                                    <img width="10%" src="{{\Illuminate\Support\Facades\Session::get('customer_picture')}}">{{\Illuminate\Support\Facades\Session::get('customer_name')}}
                                </li>
                                <li class="menu-item" ><a title="Register or Login" href="{{URL::to('/logout')}}">Đăng xuất</a></li>
                            <?php
                         }else { ?>
                             <li class="menu-item" ><a title="Register or Login" href="{{URL::to('/login-checkout')}}">Đăng nhập</a></li>
                            <li class="menu-item" ><a title="Register or Login" href="{{URL::to('/register')}}">Đăng kí</a></li>
                               <?php  }?>

                        </ul>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="mid-section main-info-area">

                    <div class="wrap-logo-top left-section">
                        <a href="index.html" class="link-to-home"><img src="{{asset('public/Fontend/images/logo-top-1.png')}}" alt="mercado"></a>
                    </div>

                    <div class="wrap-search center-section">
                        <div class="wrap-search-form">
                            <form action="{{URL::to('/tim-kiem')}}" id="form-search-top" name="form-search-top" method="get" autocomplete="off">
                                {{csrf_field()}}
                                <input type="text" name="search" id="keywords_search"  placeholder="Search here...">
                                <button form="form-search-top" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>

                            </form>

                        </div>
                        <div id="search_result" style="margin-left: 50px"></div>
                    </div>
                    <div class="wrap-icon right-section">
                        <div class="wrap-icon-section wishlist">
                            <a href="#" class="link-direction">
                                <i class="fa fa-heart" aria-hidden="true"></i>
                                <div class="left-info">
                                    <span class="index" id="count_wishlist"></span>
                                    <span class="title">Wishlist</span>
                                </div>
                            </a>
                        </div>

                        <div class="wrap-icon-section minicart" id="show-cart-menu">



                        </div>

                        <div class="wrap-icon-section show-up-after-1024">
                            <a href="#" class="mobile-navigation">
                                <span></span>
                                <span></span>
                                <span></span>
                            </a>
                        </div>
                    </div>



                </div>
            </div>

            <div class="nav-section header-sticky">


                <div class=" primary-nav-section">
                    <div class="container">
                        <ul class="nav primary clone-main-menu" id="mercado_main" data-menuname="Main menu" >
                            <li class="menu-item home-icon">
                                <a href="{{URL::to('/trang-chu')}}" class="link-term mercado-item-title"><i class="fa fa-home" aria-hidden="true"></i></a>
                            </li>
                            <li class="menu-item">
                                <a href="{{URL::to('/about-us')}}" class="link-term mercado-item-title">Chúng tôi</a>
                            </li>
                            <li class="menu-item">
                                <div class="dropdown">
                                    <button class="dropbtn " style="font-size: 13px">TIN TỨC</button>
                                    <div class="dropdown-content">
                                        @foreach($category_post as $key => $value)
                                        <a href="{{url('/danhmucbaiviet/'.$value->cate_post_slug)}}">{{$value->cate_post_name}}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                            <li class="menu-item">
                                <a href="{{URL::to('/shop')}}" class="link-term mercado-item-title">Trang chủ</a>
                            </li>
                            <li class="menu-item">
                                <a href="{{URL::to('/show-cart-ajax')}}" class="link-term mercado-item-title">Giỏ hàng</a>
                            </li>
                            @if(\Illuminate\Support\Facades\Session::get('customer_id'))
                                <li class="menu-item">
                                    <a href="{{URL::to('/checkout')}}" class="link-term mercado-item-title">Thanh toan</a>
                                </li>
                            @else
                                <li></li>
                                @endif
                            @if(\Illuminate\Support\Facades\Session::get('customer_id'))
                                <li class="menu-item">
                                    <a href="{{URL::to('/history')}}" class="link-term mercado-item-title">Lịch sử mua hàng</a>
                                </li>
                            @else
                                <li></li>
                            @endif


                            <li class="menu-item">
                                <a href="{{URL::to('/contact-us')}}" class="link-term mercado-item-title">Liên hệ</a>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>
