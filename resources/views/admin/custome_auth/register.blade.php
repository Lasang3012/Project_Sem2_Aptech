
<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{('public/Backend/css/bootstrap.min.css')}}" >
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{asset('public/Backend/css/style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('public/Backend/css/style-responsive.css')}}" rel="stylesheet"/>
    <!-- font CSS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{asset('public/Backend/css/font.css')}}" type="text/css"/>
    <link href="{{asset('public/Backend/css/font-awesome.css')}}" rel="stylesheet">
    <!-- //font-awesome icons -->
    <script src="{{asset('public/Backend/js/jquery2.0.3.min.js')}}"></script>
</head>
<body>
<div class="log-w3">
    <div class="w3layouts-main">
        <h2>Đăng ký</h2>
        <?php
        $message = Session::get('message');
        if (isset($message)){
            echo '<span style="red; font-size: 17px; text-align: center;width: 100%">'.$message.'</span>';
            Session::put('message',null);
        }
        ?>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{URL::to('/register-admin')}}" method="post">
            {{csrf_field()}}  {{-- // sản sinh 1 cái input token ngẩu nhiên giúp bảo mật hơn cho việc gửi form--}}
            <input type="email" class="ggg" name="admin_email" value="{{old('admin_email')}}" placeholder="Điền email" >
            <input type="text" class="ggg" name="admin_phone" value="{{old('admin_phone')}}" placeholder="Điền phone" >
            <input type="text" class="ggg" name="admin_name" value="{{old('admin_name')}}" placeholder="Điền name" >
            <input type="password" class="ggg" name="admin_password" placeholder="Điền password" >


            <div class="clearfix"></div>
            <input type="submit" value="Đăng ký" name="login">
        </form>
        <a href="{{url('/login-auth')}}">Đăng nhập </a>
        <h6><a href="#">Quên mật khẩu?</a></h6>
    </div>
</div>
<script src="{{asset('public/Backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/Backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/Backend/js/scripts.js')}}"></script>
<script src="{{asset('public/Backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/Backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="js/flot-chart/excanvas.min.js"></script><![endif]-->
<script src="{{asset('public/Backend/js/jquery.scrollTo.js')}}"></script>
</body>
</html>

