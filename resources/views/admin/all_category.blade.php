@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê danh mục
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
                    @foreach($all_category as $key => $value)
                    <tr>


                        <td>{{$value->category_name}}</td>

                        <td><span class="text-ellipsis">
                                <?php
                                    if ( $value->category_status == 0){
                                        ?>
                           <a href= "{{URL::to('/un_active-category/'.$value->category_id)}}"><span class="fa-thumb-styling fa fa-thumbs-down" style="font-size: 28px; color: red;"></span></a>
                                    <?php
                                    }else{
                                    ?>

                              <a href="{{URL::to('/active-category/'.$value->category_id)}}" ><span class="fa-thumb-styling fa fa-thumbs-up" style="font-size: 28px; color: green;"></span></a>
                                    <?php
                                    }
                                ?>

                            </span></td>
                        <td>
                            <a href="{{URL::to('/edit-category/'.$value->category_id)}}" class="active btn btn-primary" ui-toggle-class="" style="margin-bottom: 10px">
                                Sửa danh mục</a>
                            <a onclick="return confirm('Bạn có muốn xóa không ?')" href="{{URL::to('/delete-category/'.$value->category_id)}}" class="active btn btn-danger" ui-toggle-class="">
                               Xóa danh mục</a>
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
