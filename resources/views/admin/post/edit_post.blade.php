@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm bài viết
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="POST" action="{{URL::to('/update-post/'.$post->post_id)}}" enctype="multipart/form-data" id="myform">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên bài viết</label>
                                <input type="text" value="{{$post->post_title}}" name="post_title" data-validation="length" data-validation-length="max400"
                                       data-validation-error-msg="Tên sản phẩm không được quá 30 kí tự" required    class="form-control" id="exampleInputEmail1" placeholder="Tên sản phẩm">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tên Slug</label>
                                <textarea style="resize: none;"  rows="5" class="form-control" name="post_slug" required placeholder="Mô tả sản phẩm">{{$post->post_slug}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Tóm tắt bài viết</label>
                                <textarea style="resize: none;" value="{{old('post_desc')}}" id="post1" rows="5" class="form-control" name="post_desc"  required  placeholder="Mô tả sản phẩm">{{$post->post_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung bài viết</label>
                                <textarea style="resize: none;" value="{{old('post_content')}}" id="post2" rows="5" class="form-control" name="post_content"  required  placeholder="Mô tả sản phẩm">{{$post->post_content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta từ khóa</label>
                                <textarea style="resize: none;" value="{{old('post_meta_keyword')}}" rows="5" class="form-control" name="post_meta_keyword"  required  placeholder="Mô tả sản phẩm">{{$post->post_meta_keyword}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Meta nội dung</label>
                                <textarea style="resize: none;" value="{{old('post_meta_desc')}}" rows="5" class="form-control" name="post_meta_desc"  required  placeholder="Mô tả sản phẩm">{{$post->post_meta_desc}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh bài viết</label>
                                <input type="file" name="post_image" class="form-control"  id="exampleInputEmail1" >
                                <img src="{{asset('public/upload/post/'.$post->post_image)}}">
                            </div>


                            <div class="form-group">
                                <label for="exampleInputPassword1">Danh mục bài viết</label>
                                <select class="form-control input-sm m-bot15"  name="cate_post_id">
                                    @foreach($cate_post as $key => $value)
                                        <option {{$post->post_id == $value->cate_post_id ? 'selected' :''}} value="{{($value->cate_post_id)}}">{{($value->cate_post_name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select class="form-control input-sm m-bot15" value="{{old('post_status')}}" name="post_status">
                                    @if($post->post_status == 0)
                                        <option value="0" selected>Ẩn</option>
                                        <option value="1">Hiện thị</option>
                                    @else
                                        <option value="0" >Ẩn</option>
                                        <option value="1" selected>Hiện thị</option>
                                     @endif

                                </select>
                            </div>


                            <button type="submit" name="add_post" class="btn btn-info">Cập nhật bài viết</button>
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



