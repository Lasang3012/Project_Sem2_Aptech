@section('title','Login')
@include('include.header')


<!--main area-->
<main id="main" class="main-site left-sidebar">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="{{URL::to('/')}}" class="link">Trang chủ</a></li>
                <li class="item-link"><span>Đăng nhập</span></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 col-md-offset-3">
                <div class=" main-content-area">
                    <div class="wrap-login-item ">
                        <div class="login-form form-item form-stl">
                            @if(session()->has('message'))
                                <span style="color: green;">{!! session()->get('message') !!} </span>
                            @elseif(session()->has('error'))
                                <span style="color: red;">{!! session()->get('error') !!} </span>
                            @endif
                            <form name="frm-login" action="{{url('/recover-password')}}" method="POST">
                            @csrf
                                <fieldset class="wrap-title">
                                    <h3 class="form-title">Nhập Email đăng ký tài khoản</h3>
                                </fieldset>
                                <fieldset class="wrap-input">
                                    <label for="frm-login-uname">Email:</label>
                                    <input type="text" id="frm-login-uname" name="email_account" placeholder="Type your email address">
                                </fieldset>


                                <fieldset class="wrap-input">

                                    <a class="link-function left-position" href="{{URL::to('/register')}}" title="Forgotten password?">Đăng ký</a>
                                    <a class="link-function left-position" href="{{url('/quen-mat-khau')}}" title="Forgotten password?">Quên mật khẩu</a>

                                </fieldset>
                                <input type="submit" class="btn btn-submit" value="Gửi" name="submit">
                            </form>
                        </div>
                    </div>
                </div><!--end main products area-->
            </div>
        </div><!--end row-->

    </div><!--end container-->

</main>
<!--main area-->
@include('include.footer')

