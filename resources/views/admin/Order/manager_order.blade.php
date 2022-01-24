@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê đơn hàng
            </div>
            <div class="row w3-res-tb">


            </div>
            <div class="table-responsive" style="width: 100%">
                <table class="display nowrap table table-striped b-t b-light" id="myTable" >
                    <thead>
                    <tr>

                        <?php
                        $alert_status = Session::get('message');
                        if ($alert_status){
                            echo '<span style="color: green">'.$alert_status.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                        <th>Stt</th>
                        <th>Mã đơn hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th>Tình trạng đơn hàng</th>
                         <th>Lý do hủy đơn</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @php
                      $i = 0;
                    @endphp
                    @foreach($order as $key => $orderr)
                        @php
                            $i++;
                        @endphp
                        <tr>


                            <td>{{$i}}</td>
                            <td>{{$orderr->order_code}}</td>
                            <td>{{$orderr->created_at}}</td>
                            <td>
                                @if($orderr->order_status == 1)
                                    <span class="text-success">Đơn hàng mới</span>
                                @elseif($orderr->order_status == 2)
                                    <span class="text-warning">Đã xử lý</span>
                                @else
                                    <span class="text-danger">Đơn hàng đã hủy</span>
                                @endif
                            </td>
                            <td>
                                @if($orderr->order_status == 3)
                                    {{$orderr->order_destroy}}
                                @endif

                            </td>
                            <td>
                                <a href="{{URL::to('/view-order/'.$orderr->order_code)}}" class="active btn btn-primary" ui-toggle-class="" >
                                    Xem Order</a>
                                <a onclick="return confirm('Bạn có muốn xóa không ?')" href="{{URL::to('/delete-order/'.$orderr->order_code)}}" class="active btn btn-danger" ui-toggle-class="">
                                  Xóa Order</a>
                            </td>

                        </tr>
                    @endforeach






                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection


