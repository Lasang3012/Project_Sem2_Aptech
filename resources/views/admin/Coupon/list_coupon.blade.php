@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê mã giảm giá
            </div>

            <div class="table-responsive">
                <table class="display nowrap table table-striped b-t b-light" id="myTable">
                    <thead>
                    <tr>

                        <?php
                        $message = Session::get('message');
                        if ($message) {
                            echo '<span style="color: green">' . $message . '</span>';
                            Session::put('message', null);
                        }
                        ?>
                        <th>Tên mã giảm giá</th>
                        <th>Bắt đầu</th>
                        <th>Kết thúc</th>
                        <th>Mã giảm giá</th>
                        <th>Tổng số mã giảm</th>
                        <th>Giảm theo</th>
                        <th>Chi tiết giảm</th>
                        <th>Tình trạng</th>
                        <th>Thời hạn</th>
                        <th>Gửi mã</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($coupon as $key => $value)
                        <tr>


                            <td>{{$value->coupon_name}}</td>
                            <td>{{$value->coupon_date_start}}</td>
                            <td>{{$value->coupon_date_end}}</td>
                            <td>{{$value->coupon_code}}</td>
                            <td>{{$value->coupon_time}}</td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if ( $value->coupon_condition == 1){
                                    ?>
                                     Giảm theo phần trăm
                                    <?php
                                    }else{
                                    ?>
                                     Giảm theo giá

                                    <?php
                                    }
                                    ?>

                            </span></td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if ( $value->coupon_condition == 1){
                                    ?>
                                     Giảm {{$value->coupon_number}} %
                                    <?php
                                    }else{
                                    ?>
                                     Giảm {{$value->coupon_number}} vnd

                                    <?php
                                    }
                                    ?>

                            </span></td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if ( $value->coupon_status == 1){
                                    ?>
                                      <span style="color: green">Đang kích hoạt</span>
                                    <?php
                                    }else{
                                    ?>
                                      <span style="color: red">Đã khóa</span>

                                    <?php
                                    }
                                    ?>

                            </span></td>

                            <td>
                                @if($value->coupon_date_end >= $today)
                                    <span style="color: green">Còn hạn</span>
                                @else
                                    <span style="color: red">Đã hết hạn</span>
                                @endif
                            </td>

                            <td>

                                <p><a href="{{url('/send-coupon-vip', [
                                      'coupon_time'=> $value->coupon_time,
                                      'coupon_condition'=> $value->coupon_condition,
                                       'coupon_number'=> $value->coupon_number,
                                      'coupon_code'=> $value->coupon_code


                                    ])}}" class="btn btn-primary" style="margin:5px 0;">Gửi giảm giá khách vip</a></p>
                                <p><a href="{{url('/send-coupon',[
                                         'coupon_time'=> $value->coupon_time,
                                         'coupon_condition'=> $value->coupon_condition,
                                          'coupon_number'=> $value->coupon_number,
                                          'coupon_code'=> $value->coupon_code
                                     ])}}" class="btn btn-default">Gửi giảm giá khách thường</a></p>


                            </td>
                            <td>

                                <a onclick="return confirm('Bạn có muốn xóa không ?')"
                                   href="{{URL::to('/delete-coupon/'.$value->coupon_id)}}" class="active btn btn-danger"
                                   ui-toggle-class="">
                                    Xóa mã giảm giá</a>
                            </td>


                        </tr>
                    @endforeach


                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection


