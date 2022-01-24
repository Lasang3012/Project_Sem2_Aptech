@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm sản phẩm
                </header>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="POST" action="{{URL::to('/save-Product')}}" enctype="multipart/form-data" id="myform">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text" name="product_name" value="{{old('product_name')}}" data-validation="length" data-validation-length="max30"
                                  data-validation-error-msg="Tên sản phẩm không được quá 30 kí tự" required    class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                <textarea style="resize: none;" id="ckeditor1"  rows="5" class="form-control" name="product_desc" required placeholder="Mô tả sản phẩm">{{old('product_desc')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                <textarea style="resize: none;" id="ckeditor2" rows="5" class="form-control" name="product_content"  required  placeholder="Mô tả sản phẩm">{{old('product_content')}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tags sản phẩm</label>
                                <input type="text" name="product_tags" data-role="tagsinput" class="form-control" required   >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng</label>
                                <input type="number" min="1"  data-validation="number" data-validation-error-msg="Yêu cầu nhập đúng số lượng" name="product_inventory" class="form-control" required  id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                <input type="file" name="product_image" class="form-control" required  id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Gía gốc</label>
                                <input type="text"   name="product_price_cost" class="form-control money" data-validation="length" data-validation-length="max30"
                                       data-validation-error-msg="Tên sản phẩm không được quá 30 kí tự" required  id="exampleInputEmail1" placeholder="Gía sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Gía sản phẩm</label>
                                <input type="text" name="product_price" class="form-control money" data-validation="length" data-validation-length="max30"
                                       data-validation-error-msg="Tên sản phẩm không được quá 30 kí tự" required  id="exampleInputEmail1" placeholder="Gía sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                <select class="form-control input-sm m-bot15" name="product_category">
                                    @foreach($category_product as $key => $value)
                                    <option value="{{($value->category_id)}}">{{($value->category_name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                <select class="form-control input-sm m-bot15" name="product_brand">
                                    @foreach($brand_product as $key => $value)
                                    <option value="{{($value->brand_id)}}">{{($value->brand_name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select class="form-control input-sm m-bot15" name="product_status">
                                    <option value="0">Ẩn</option>
                                    <option value="1">Hiện thị</option>
                                </select>
                            </div>


                            <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm</button>
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


