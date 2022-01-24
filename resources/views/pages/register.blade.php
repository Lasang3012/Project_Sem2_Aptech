@section('title','Register')
@include('include.header')

<!--main area-->
<main id="main" class="main-site left-sidebar">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="{{URL::to('/')}}" class="link">Trang chủ</a></li>
                <li class="item-link"><span>Đăng kí</span></li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12 col-md-offset-3">
                <div class=" main-content-area">
                    <div class="wrap-login-item ">
                        <div class="register-form form-item ">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <?php
                                $message = \Illuminate\Support\Facades\Session::get('message');
                                if ($message){
                                    echo '<span style="color: green">'.$message.'</span>';
                                    Session::put('message',null);
                                }
                            ?>
                            <form class="form-stl" action="{{URL::to('/add-customer')}}" id="frmSample" name="frm-login" method="POST" >
                                {{csrf_field()}}
                                <fieldset class="wrap-title">
                                    <h3 class="form-title">Tạo tài khoản</h3>
                                    <h4 class="form-subtitle">Thông tin cá nhân</h4>
                                </fieldset>
                                <fieldset class="wrap-input">
                                    <label for="frm-reg-lname">Họ và tên*</label>
                                    <input type="text" id="frm-reg-lname" name="reg_lname" placeholder="Last name*">
                                </fieldset>
                                <fieldset class="wrap-input">
                                    <label for="frm-reg-lname">Số điên thoại*</label>
                                    <input type="text" id="frm-reg-lname" name="reg_phone" placeholder="0123456789*" pattern="(09|01[2|6|8|9])+([0-9]{8})\b">
                                </fieldset>
                                <fieldset class="wrap-input">
                                    <label for="frm-reg-email">Email*</label>
                                    <input type="email" id="frm-reg-email" name="reg_email" placeholder="Email address" >
                                </fieldset>


                                <fieldset class="wrap-input item-width-in-half left-item ">
                                    <label for="frm-reg-pass">Mật khẩu *</label>
                                    <input type="text" id="frm-reg-pass" data-validation="length" data-validation-length="min8" name="pass_confirmation" placeholder="Password">
                                </fieldset>
                                <fieldset class="wrap-input item-width-in-half ">
                                    <label for="frm-reg-cfpass">Xác nhận mật khẩu *</label>
                                    <input type="text" id="frm-reg-cfpass" data-validation="confirmation" name="pass" placeholder="Confirm Password">
                                </fieldset>
                                <input type="submit" class="btn btn-sign" value="Register" name="register">
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
