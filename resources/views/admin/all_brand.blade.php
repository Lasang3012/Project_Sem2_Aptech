@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê thương hiệu
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>

                        <?php
                        $message = Session::get('message');
                        if ($message){
                            echo '<span style="color: green">'.$message.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                        <th>Tên danh mục</th>
                        <th>Trạng thái</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_brand as $key => $value)
                        <tr>


                            <td>{{$value->brand_name}}</td>

                            <td><span class="text-ellipsis">
                                <?php
                                    if ( $value->brand_status == 0){
                                    ?>
                           <a href= "{{URL::to('/un_active-brand/'.$value->brand_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down" style="font-size: 28px; color: red;"></span></a>
                                    <?php
                                    }else{
                                    ?>

                              <a href="{{URL::to('/active-brand/'.$value->brand_id)}}" ><span class="fa-thumb-styling fa fa-thumbs-up" style="font-size: 28px; color: green;"></span></a>
                                    <?php
                                    }
                                    ?>

                            </span></td>
                            <td>
                                <a href="{{URL::to('/edit-brand/'.$value->brand_id)}}" class="active btn btn-primary" style="margin-bottom: 10px" ui-toggle-class="">Sửa thương hiệu</a>
                                <a onclick="return confirm('Bạn có muốn xóa không ?')" href="{{URL::to('/delete-brand/'.$value->brand_id)}}" class="active btn btn-danger" ui-toggle-class="">
                                    Xóa thương hiệu</a>
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
                           {!!  $all_brand->links()!!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection

