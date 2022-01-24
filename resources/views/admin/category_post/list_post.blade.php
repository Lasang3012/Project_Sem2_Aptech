@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê danh mục bài viết
            </div>
            <style>
                .table > thead > tr > th{
                    color: #0D0A0A;
                }
            </style>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light" id="myTable">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        <?php
                        $alert_status = Session::get('message');
                        if ($alert_status){
                            echo '<span style="color: green">'.$alert_status.'</span>';
                            Session::put('message',null);
                        }
                        ?>
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th>Mô tả danh mục</th>
                        <th>Trạng thái</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category_post as $key => $value)
                        <tr>

                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$value->cate_post_name}}</td>
                            <td>{{$value->cate_post_slug}}</td>
                            <td>{{$value->cate_post_desc}}</td>
                            <td><span class="text-ellipsis">

                                    @if ( $value->cate_post_status == 0){
                                      Ẩn
                                    @else
                                       Hiện thị
                                     @endif

                            </span></td>
                            <td>
                                <a href="{{URL::to('/edit-category-post/'.$value->cate_post_id)}}" style="margin-bottom: 10px" class="active btn btn-primary" ui-toggle-class="">
                                   Cập nhật danh mục bài viết
                                  </a>
                                <a onclick="return confirm('Bạn có muốn xóa không ?')" style="width: 100%" href="{{URL::to('/delete-category-post/'.$value->cate_post_id)}}" class="active btn btn-danger" ui-toggle-class="">
                                    Xóa danh mục bài viết</a>
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
                            {!! $category_post->links() !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection


