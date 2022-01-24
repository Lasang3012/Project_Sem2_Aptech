@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê thương hiệu
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                    <tr>

                        <?php
                        $alert_status = Session::get('message_product');
                        if ($alert_status){
                            echo '<span style="color: green">'.$alert_status.'</span>';
                            Session::put('message_product',null);
                        }
                        ?>
                        <th  style="width:101px;color: #0D0A0A">Tên sản phẩm</th>
                        <th style="width:80px;color: #0D0A0A">Danh mục</th>
                        <th  style="width:90px;color: #0D0A0A">Thương hiệu</th>
                        <th  style="width:90px;color: #0D0A0A">Số lượng</th>
                        <th  style="width:108px;color: #0D0A0A">Thư viện ảnh</th>
                        <th style="color: #0D0A0A">Hình sản phẩm</th>
                        <th style="width:90px;color: #0D0A0A">Gía bán</th>
                        <th style="width:90px;color: #0D0A0A">Gía gốc</th>
                        <th style="width:80px;color: #0D0A0A">Trạng thái</th>


                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_product as $key => $value)
                        <tr>


                            <td>{{$value->product_name}}</td>
                            <td>{{$value->category_name}}</td>
                            <td>{{$value->brand_name}}</td>
                            <td>{{$value->inventory}}</td>
                            <td><a href="{{url('/add-gallery/'.$value->product_id)}}">Thêm thư viện ảnh</a></td>
                            <td><img src="public/upload/product/{{$value->product_image}}" height="100" width="100"></td>
                            <td class="money">{{ $value->product_price}}</td>
                            <td class="money">{{$value->price_cost}}</td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if ( $value->product_status == 0){
                                    ?>
                           <a href= "{{URL::to('/un_active-product/'.$value->product_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down" style="font-size: 28px; color: red;"></span></a>
                                    <?php
                                    }else{
                                    ?>

                              <a href="{{URL::to('/active-product/'.$value->product_id)}}" ><span class="fa-thumb-styling fa fa-thumbs-up" style="font-size: 28px; color: green;"></span></a>
                                    <?php
                                    }
                                    ?>

                            </span></td>
                            <td>
                                <a href="{{URL::to('/edit-product/'.$value->product_id)}}" style="margin-bottom: 10px" class="active btn btn-primary" ui-toggle-class="">
                                    Cập nhật sản phẩm</a>
                                <a onclick="return confirm('Bạn có muốn xóa không ?')" style="width: 100%" href="{{URL::to('/delete-Product/'.$value->product_id)}}" class="active btn btn-danger" ui-toggle-class="">
                                    Xóa sản phẩm</a>
                            </td>

                        </tr>
                    @endforeach






                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection


