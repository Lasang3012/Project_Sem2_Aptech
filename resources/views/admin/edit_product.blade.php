@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật sản phẩm
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        @if(session()->has('message'))
                            <span style="color: green;">{!! session()->get('message') !!} </span>

                        @elseif(session()->has('error'))
                            <span style="color: red;">{!! session()->get('error') !!} </span>
                        @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        @foreach($edit_product as $key => $pro)
                        <form role="form" method="POST" action="{{URL::to('/update-Product/'.$pro->product_id)}}" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên sản phẩm</label>
                                <input type="text" value="{{$pro->product_name}}" data-validation="length" data-validation-length="max30"
                                       data-validation-error-msg="Tên sản phẩm không được quá 30 kí tự" name="product_name" class="form-control" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                                <textarea style="resize: none;" rows="5" id="ckeditor4" class="form-control" name="product_desc" id="exampleInputPassword1" >{{$pro->product_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                                <textarea style="resize: none;" id="ckeditor3" rows="5" class="form-control" name="product_content" id="exampleInputPassword1"> {{$pro->product_content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tags sản phẩm</label>
                                <input type="text" name="product_tags" value="{{$pro->product_tags}}" data-role="tagsinput" class="form-control" required   >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Số lượng</label>
                                <input type="number" value="{{$pro->inventory}}" name="product_inventory" class="form-control" id="exampleInputEmail1" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                                <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" >
                                <img src="{{URL::to('public/upload/product/'.$pro->product_image)}}" width="150" height="100"/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Gía gốc</label>
                                <input type="text" name="product_price_cost" value="{{$pro->price_cost}}" class="form-control money" id="exampleInputEmail1" placeholder="Gía sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Gía sản phẩm</label>
                                <input type="text" name="product_price" value="{{$pro->product_price}}"  class="form-control money" id="exampleInputEmail1" placeholder="Gía sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục sản phẩm</label>
                                <select class="form-control input-sm m-bot15" name="product_category">
                                    @foreach($category_product as $key => $value)
                                        @if($value->category_id == $pro->category_id)
                                        <option selected value="{{($value->category_id)}}">{{($value->category_name)}}</option>
                                        @else
                                            <option value="{{($value->category_id)}}">{{($value->category_name)}}</option>
                                        @endif
                                            @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Thương hiệu sản phẩm</label>
                                <select class="form-control input-sm m-bot15" name="product_brand">
                                    @foreach($brand_product as $key => $value)
                                        @if($value->brand_id == $pro->brand_id)
                                        <option selected value="{{$value->brand_id}}">{{$value->brand_name}}</option>
                                        @else
                                        <option value="{{$value->brand_id}}">{{$value->brand_name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select class="form-control input-sm m-bot15" name="product_status">
                                    <option value="1">Hiện thị</option>
                                    <option value="0">Ẩn</option>

                                </select>
                            </div>


                            <button type="submit" name="add_product" class="btn btn-info">Cập nhật sản phẩm</button>
                        </form>
                            @endforeach
                    </div>

                </div>
            </section>

        </div>

    </div>
@endsection


