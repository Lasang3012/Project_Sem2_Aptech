@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật danh mục tin tức
                </header>

                <div class="panel-body">
                    <div class="position-center">
                        <form role="form" method="POST" action="{{URL::to('/update-category-post/'.$category_post->cate_post_id)}}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục bài viết</label>
                                <input type="text" value="{{$category_post->cate_post_name}}" name="cate_post_name" data-validation="length" data-validation-length="max30"
                                       data-validation-error-msg="Tên danh mục không được quá 30 kí tự" class="form-control" onkeyup="ChangeToSlug();" id="slug" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Slug</label>
                                <input type="text"  value="{{$category_post->cate_post_slug}}" readonly name="cate_post_slug" class="form-control" id="convert_slug"placeholder="Tên danh mục">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Nội dung bài viết</label>
                                <textarea style="resize: none;"   rows="5" class="form-control" name="cate_post_desc" id="exampleInputPassword1" placeholder="Mô tả danh mục">{{$category_post->cate_post_desc}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hiển thị</label>
                                <select  class="form-control input-sm m-bot15" name="cate_post_status">
                                    @if($category_post->cate_post_status == 0)
                                        <option selected value="0">Ẩn</option>
                                        <option value="1">Hiện thị</option>
                                    @else
                                    @endif
                                    <option value="0">Ẩn</option>
                                    <option selected value="1">Hiện thị</option>
                                </select>
                            </div>

                            <button type="submit" name="update_post_cate" class="btn btn-info">cập nhật danh muc bài viết</button>
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


        <script type="text/javascript">

            function ChangeToSlug()
            {
                var slug;

                //Lấy text từ thẻ input title
                slug = document.getElementById("slug").value;
                slug = slug.toLowerCase();
                //Đổi ký tự có dấu thành không dấu
                slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
                slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
                slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
                slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
                slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
                slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
                slug = slug.replace(/đ/gi, 'd');
                slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
                slug = slug.replace(/ /gi, "-");
                slug = slug.replace(/\-\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-\-/gi, '-');
                slug = slug.replace(/\-\-\-/gi, '-');
                slug = slug.replace(/\-\-/gi, '-');
                slug = '@' + slug + '@';
                slug = slug.replace(/\@\-|\-\@|\@/gi, '');
                document.getElementById('convert_slug').value = slug;
            }




        </script>
@endsection


