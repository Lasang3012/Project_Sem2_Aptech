@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm mã giảm giá
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="POST" action="{{URL::to('/insert-coupon-code')}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên mã giảm giá</label>
                                <input type="text" name="coupon_name" data-validation="length" data-validation-length="max30"
                                       data-validation-error-msg="Tên mã giảm không được quá 30 kí tự" class="form-control" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày bắt đầu</label>
                                <input type="text" name="coupon_date_start"  class="form-control" id="start_coupon" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Ngày kết thúć</label>
                                <input type="text" name="coupon_date_end"  class="form-control" id="end_coupon" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mã giảm giá</label>
                                <textarea style="resize: none;" rows="5" class="form-control" name="coupon_code" id="exampleInputPassword1" ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Số lượng mã</label>
                                <textarea style="resize: none;" rows="5" class="form-control" name="coupon_times" id="exampleInputPassword1" ></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tính năng mã</label>
                                <select class="form-control input-sm m-bot15" name="coupon_condition">
                                    <option value="0">----Chon-----</option>
                                    <option value="1">Giảm theo %</option>
                                    <option value="2">Giảm theo giá sản phẩm</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nhập số % hoặc tiền giảm </label>
                                <textarea style="resize: none;" rows="5" class="form-control" name="coupon_number" id="exampleInputPassword1" ></textarea>
                            </div>


                            <button type="submit" name="add_coupon" class="btn btn-info">Thêm mã giảm giá</button>
                        </form>
                        <?php
                        $message = Session::get('message');
                        if ($message){
                            echo '<span style="color: green">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection
