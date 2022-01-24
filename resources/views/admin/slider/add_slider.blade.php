@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm Banner
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="POST" action="{{URL::to('/insert-slider')}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên Banner</label>
                                <input type="text" name="slider_name" data-validation="length" data-validation-length="max30"
                                       data-validation-error-msg="Tên thương hiệu không được quá 30 kí tự" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ãnh</label>
                                <input type="file" name="slider_image" class="form-control" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả Banner</label>
                                <textarea style="resize: none;" rows="5" class="form-control" name="slider_desc" id="exampleInputPassword1"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select class="form-control input-sm m-bot15" name="slider_status">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện thị</option>
                                </select>
                            </div>

                            <button type="submit"  class="btn btn-info">Thêm thuong hiệu</button>
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


