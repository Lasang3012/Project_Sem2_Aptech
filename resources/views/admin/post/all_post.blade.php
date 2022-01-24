@extends('admin_layout')
@section('admin_content')
    <style>
        .table > thead > tr > th{
            color: #0D0A0A;
        }
    </style>
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê  bài viết
            </div>

            <div class="table-responsive">
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                    <tr>

                        <?php
                        $alert_status = Session::get('message');
                        if ($alert_status){
                            echo '<span style="color: green">'.$alert_status.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                        <th style="width: 350px">Tên bài viết</th>
                        <th style="width: 100px">Hình ảnh</th>

                        <th style="width: 150px;">Danh mục bài viết</th>
                        <th>Trạng thái</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_post as $key => $value)
                        <tr>


                            <td>{!!  $value->post_title !!}</td>
                            <td><img src="{{asset('public/upload/post/'.$value->post_image)}}" height="100" width="100"></td>

                            <td>{{$value->cate_post->cate_post_name}}</td>


                            <td>

                                    @if ( $value->post_status == 0){
                                    Ẩn
                                    @else
                                        Hiện thị
                                    @endif

                            </td>
                            <td>
                                <a href="{{URL::to('/edit-post/'.$value->post_id)}}" style="margin-bottom: 10px" class="active btn btn-primary" ui-toggle-class="">
                                    Cập nhật bài viết</a>
                                <a onclick="return confirm('Bạn có muốn xóa không ?')" style="width: 100%" href="{{URL::to('/delete-post/'.$value->post_id)}}" class="active btn btn-danger" ui-toggle-class="">
                                    Xóa bài viết</a>
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
                            {!! $all_post->links() !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection



