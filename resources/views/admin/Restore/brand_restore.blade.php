@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh mục đã xóa
            </div>
            <?php
            $message = Session::get('message');
            if ($message){
                echo '<span style="color: green">'.$message.'</span>';
                Session::put('message',null);
            }
            ?>
            @if($all_brand_product->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                        <tr>


                            <th>Tên danh mục</th>
                            <th>Trạng thái</th>

                            <th style="width:30px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($all_brand_product as $key => $value)
                            <tr>


                                <td>{{$value->brand_name}}</td>

                                <td>
                                    <a onclick="return confirm('Bạn có muốn xóa không ?')" href="{{URL::to('/delete_brand/restore/'.$value->brand_id)}}" class="active btn btn-danger" ui-toggle-class="">
                                        Delete</a>
                                    <a onclick="return confirm('Bạn có muốn khôi phục  không ?')" href="{{URL::to('/brand/restore/'.$value->brand_id)}}" class="active btn btn-danger" ui-toggle-class="">
                                        Restore</a>
                                </td>

                            </tr>
                        @endforeach

                        @else
                            <p scope="row" class="text-center">Empty </p>


                        @endif
                        </tbody>
                    </table>
                </div>




                <footer class="panel-footer">
                    <div class="row">


                        <div class="col-sm-7 text-right text-center-xs">
                            <ul class="pagination pagination-sm m-t-none m-b-none">
                                {{$all_brand_product->links()}}
                            </ul>
                        </div>
                    </div>
                </footer>
        </div>
    </div>
@endsection


