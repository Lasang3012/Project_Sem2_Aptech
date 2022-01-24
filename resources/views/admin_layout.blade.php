<!--A Design by W3layouts
Author: W3layout
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->
<!DOCTYPE html>
<head>
    <title>Dashbord</title>
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="keywords" content="Visitors Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- bootstrap-css -->
    <link rel="stylesheet" href="{{asset('public/Backend/css/bootstrap.min.css')}}" >
    <!-- //bootstrap-css -->
    <!-- Custom CSS -->
    <link href="{{asset('public/Backend/css/style.css')}}" rel='stylesheet' type='text/css' />
    <link href="{{asset('public/Backend/css/style-responsive.css')}}" rel="stylesheet"/>
    <!-- font CSS -->
    <link href='//fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,400italic,500,500italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>
    <!-- font-awesome icons -->
    <link rel="stylesheet" href="{{asset('public/Backend/css/font.css')}}" type="text/css"/>
    <link href="{{asset('public/Backend/css/font-awesome.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/Backend/css/morris.css')}}" type="text/css"/>
    <link rel="stylesheet" href="{{asset('public/Backend/css/bootstrap-tagsinput.css')}}" type="text/css"/>
    <!-- calendar -->
    <link rel="stylesheet" href="{{asset('public/Backend/css/monthly.css')}}">
    <!-- //calendar -->
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
    <!-- //font-awesome icons -->
    <script src="{{asset('public/Backend/js/jquery2.0.3.min.js')}}"></script>

    <script src="{{asset('public/Backend/ckeditor/ckeditor.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
</head>
<body>
<section id="container">
    <!--header start-->
    <header class="header fixed-top clearfix" style="background: #353b48;">
        <!--logo start-->
        <div class="brand">
            <a href="{{url('/')}}" class="logo">
                @hasrole('SuperAdmin')
                    Admin
                @elseif('admin')
                    Admin
                @else
                   User
                @endhasrole
            </a>
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars"></div>
            </div>
        </div>
        <!--logo end-->

        <div class="top-nav clearfix" >
            <!--search & user info start-->
            <ul class="nav pull-right top-menu">
                <li>
                    <input type="text" class="form-control search" placeholder=" Search">
                </li>
            <?php


            use Illuminate\Support\Facades\Auth;
            $name = \Illuminate\Support\Facades\Auth::guard('admin')->user()->admin_name;
            $id = Auth::guard('admin')->id();
            $image_admin = Auth::guard('admin')->user()->admin_image;

            ?>
                <!-- user login dropdown start-->
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <img alt="" src="{{asset('public/upload/admin/'.$image_admin)}}">
                        <span class="username">
                              <?php




                            if (isset($name)){

                                echo $name;

                            }
                            ?>


                        </span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu extended logout">
                        <li><a href="{{url('profile-user/'.$id)}}"><i class=" fa fa-suitcase"></i>Profile</a></li>
                        <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
                        <li><a href="{{URL::to('/log-out')}}"><i class="fa fa-key"></i> Log Out</a></li>
                    </ul>
                </li>
                <!-- user login dropdown end -->

            </ul>
            <!--search & user info end-->
        </div>
    </header>
    <!--header end-->
    <!--sidebar start-->
    <aside>
        <div id="sidebar" class="nav-collapse">
            <!-- sidebar menu start-->
            <div class="leftside-navigation">
                <ul class="sidebar-menu" id="nav-accordion">
                    <li>
                        <a class="active" href="{{URL::to('dashbord')}}">
                            <i class="fa fa-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>


                    <li class="sub-menu">
                        <a  href="javascript:;"">
                            <i class="fa fa-book"></i>
                            <span>Banner</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/manage-slider')}}">Liệt kê Banner</a></li>
                            <li><a href="{{URL::to('/add-slider')}}">Thêm Banner</a></li>

                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Đơn hàng</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/manager-order')}}">Quản lý đơn hàng</a></li>


                        </ul>
                    </li>


                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Vận chuyển</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/delivery')}}">Quản lý vận chuyển</a></li>


                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Mã giảm giá</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/insert-coupon')}}">Thêm mã giảm giá</a></li>
                            <li><a href="{{URL::to('/list-coupon')}}">Danh sách mã giảm giá</a></li>

                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Danh mục sãn phẩm</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('add-categoryProduct')}}">Thêm danh mục</a></li>
                            <li><a href="{{URL::to('all-categoryProduct')}}">Liệt kê danh mục</a></li>
                            <li><a href="{{URL::to('category/restore')}}">Thu hồi</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Danh mục thương hiệu</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('add-brandProduct')}}">Thêm thương hiệu</a></li>
                            <li><a href="{{URL::to('all-brandProduct')}}">Liệt kê thương hiệu</a></li>
                            <li><a href="{{URL::to('brand/restore')}}">Thu hồi</a></li>

                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span> Sản phẩm</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('add-Product')}}">Thêm sản phẩm</a></li>
                            <li><a href="{{URL::to('all-Product')}}">Liệt kê sản phẩm</a></li>
                            <li><a href="{{URL::to('product/restore')}}">Thu hồi</a></li>
                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span> Bình luận</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('comment')}}">Liệt kê bình luận</a></li>

                        </ul>
                    </li>

                    @hasrole

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>User</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/user')}}">Liệt kê User</a></li>
                            <li><a href="{{URL::to('add-user')}}">Thêm User</a></li>

                        </ul>
                    </li>

                    @endhasrole


                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Danh mục bài viết</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/list-category-post')}}">Liệt kê danh mục bài viết</a></li>
                            <li><a href="{{URL::to('/add-category-post')}}">Thêm danh mục bài viết</a></li>

                        </ul>
                    </li>

                    <li class="sub-menu">
                        <a href="javascript:;">
                            <i class="fa fa-book"></i>
                            <span>Tin tức</span>
                        </a>
                        <ul class="sub">
                            <li><a href="{{URL::to('/list-post')}}">Liệt kê  bài viết</a></li>
                            <li><a href="{{URL::to('/add-post')}}">Thêm  bài viết</a></li>

                        </ul>
                    </li>





                </ul>            </div>
            <!-- sidebar menu end-->
        </div>
    </aside>
    <!--sidebar end-->
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
           @yield('admin_content')


        </section>
        <!-- footer -->

    </section>
    <!--main content end-->
</section>
<script src="{{asset('public/Backend/js/bootstrap.js')}}"></script>
<script src="{{asset('public/Backend/js/jquery.dcjqaccordion.2.7.js')}}"></script>
<script src="{{asset('public/Backend/js/scripts.js')}}"></script>
<script src="{{asset('public/Backend/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/Backend/js/jquery.nicescroll.js')}}"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="{{asset('public/Backend/js/flot-chart/excanvas.min.js')}}"></script><![endif]-->
<script src="{{asset('public/Backend/js/jquery.scrollTo.js')}}"></script>
<script src="{{asset('public/Backend/js/bootstrap-tagsinput.js')}}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
<script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="{{asset('public/Fontend/js/simple.money.format.js')}}"></script>
<!-- morris JavaScript -->

<script>
    $(document).ready( function () {
        $('#myTable').DataTable({
            'sort':false
        }
       ,   $('.money').simpleMoneyFormat()
    );

    } );
</script>
<script>
    $(document).ready(function (){
        $('.money').simpleMoneyFormat();
    });
</script>
<script type="text/javascript">
    $.validate({
        modules : 'security',
        form: "#frmSample",
        validateOnBlur: true, // enable validation when input looses focus
        scrollToTopOnError: true, // Set this property to true if you have a long form
        borderColorOnError: "rgb(167, 3, 0)",
        borderColorOnSuccess: "#a94442",
    });
</script>
<script>
    $(document).ready(function() {
        //BOX BUTTON SHOW AND CLOSE
        jQuery('.small-graph-box').hover(function() {
            jQuery(this).find('.box-button').fadeIn('fast');
        }, function() {
            jQuery(this).find('.box-button').fadeOut('fast');
        });
        jQuery('.small-graph-box .box-close').click(function() {
            jQuery(this).closest('.small-graph-box').fadeOut(200);
            return false;
        });

        //CHARTS
        function gd(year, day, month) {
            return new Date(year, month - 1, day).getTime();
        }

        graphArea2 = Morris.Area({
            element: 'hero-area',
            padding: 10,
            behaveLikeLine: true,
            gridEnabled: false,
            gridLineColor: '#dddddd',
            axes: true,
            resize: true,
            smooth:true,
            pointSize: 0,
            lineWidth: 0,
            fillOpacity:0.85,
            data: [
                {period: '2015 Q1', iphone: 2668, ipad: null, itouch: 2649},
                {period: '2015 Q2', iphone: 15780, ipad: 13799, itouch: 12051},
                {period: '2015 Q3', iphone: 12920, ipad: 10975, itouch: 9910},
                {period: '2015 Q4', iphone: 8770, ipad: 6600, itouch: 6695},
                {period: '2016 Q1', iphone: 10820, ipad: 10924, itouch: 12300},
                {period: '2016 Q2', iphone: 9680, ipad: 9010, itouch: 7891},
                {period: '2016 Q3', iphone: 4830, ipad: 3805, itouch: 1598},
                {period: '2016 Q4', iphone: 15083, ipad: 8977, itouch: 5185},
                {period: '2017 Q1', iphone: 10697, ipad: 4470, itouch: 2038},

            ],
            lineColors:['#eb6f6f','#926383','#eb6f6f'],
            xkey: 'period',
            redraw: true,
            ykeys: ['iphone', 'ipad', 'itouch'],
            labels: ['All Visitors', 'Returning Visitors', 'Unique Visitors'],
            pointSize: 2,
            hideHover: 'auto',
            resize: true
        });


    });
</script>
<script type="text/javascript">
      $.validate({

      });
</script>
<script>
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('ckeditor2');
    CKEDITOR.replace('ckeditor1');
    CKEDITOR.replace('ckeditor3');
    CKEDITOR.replace('ckeditor4');
    CKEDITOR.replace('post1');
    CKEDITOR.replace('post2');
    CKEDITOR.replace('post3');
    CKEDITOR.replace('post4');

</script>
<!-- calendar -->
<script type="text/javascript" src="{{asset('public/Backend/js/monthly.js')}}"></script>
<script type="text/javascript">
    $(window).load( function() {

        $('#mycalendar').monthly({
            mode: 'event',

        });

        $('#mycalendar2').monthly({
            mode: 'picker',
            target: '#mytarget',
            setWidth: '250px',
            startHidden: true,
            showTrigger: '#mytarget',
            stylePast: true,
            disablePast: true
        });

        switch(window.location.protocol) {
            case 'http:':
            case 'https:':
                // running on a server, should be good.
                break;
            case 'file:':
                alert('Just a heads-up, events will not work when run locally.');
        }

    });
</script>
<!-- //calendar -->
{{--Ajax vận chuyển--}}
<script>
    $(document).ready(function (){
        fetch_delivery();
        function fetch_delivery(){
            var _token = $('input[name="_token"]').val();
            $.ajax({
                url: '{{url('/select-feeship')}}',
                method:'POST',
                data : {_token:_token},
                success:function (data){
                    $('#load_delivery').html(data);
                }
            });
        }


        $('.add_delivery').click(function (){
             var city = $('.city').val();
             var province = $('.province').val();
            var wards = $('.wards').val();
            var fee_ship = $('.fee_ship').val();
            var token = $('input[name="_token"]').val();
            // alert(province);
            // alert(city);
            // alert(wards);
            // alert(fee_ship);
            $.ajax({
                url: '{{url('/insert-delivery')}}',
                method:'POST',
                data : {city:city,province:province,_token:token,wards:wards,fee_ship:fee_ship},
                success:function (data){
                    fetch_delivery();
                }
            });

        });
        //update phi van chuyen
        $(document).on('blur','.fee_feeship_edit',function(){

            var feeship_id = $(this).data('feeship_id');
            var fee_value = $(this).text();
            var _token = $('input[name="_token"]').val();
            // alert(feeship_id);
            // alert(fee_value);
            $.ajax({
                url : '{{url('/update-delivery')}}',
                method: 'POST',
                data:{feeship_id:feeship_id, fee_value:fee_value, _token:_token},
                success:function(data){
                    fetch_delivery();
                }
            });

        });
        //update phi van chuyen

            $('.choose').on('change',function (){
             var action = $(this).attr('id');
             var ma_id = $(this).val();
             var token = $('input[name="_token"]').val();

             var result = "";
             if (action =='city'){
                 result = 'province';
             }else{
                 result = 'wards';
             }
             $.ajax({
                 url: '{{url('/select-delivery')}}',
                 method:'POST',
                 data : {action:action,ma_id:ma_id,_token:token},
                 success:function (data){
                     $('#'+ result).html(data);
                 }
             });
        });

    });
</script>
{{--Ajax vận chuyển--}}

{{--Xử lý đơn hàng --}}
<script type="text/javascript">
    $(document).ready(function (){


    $('.order_success').change(function (){
         var order_status = $(this).val();
         var order_id = $(this).children(":selected").attr('id');
         var _token = $('input[name="_token"]').val();

         // lấy quantity
         quantity = [];
         $('input[name="product_sales_quantity"]').each(function (){
             quantity.push($(this).val());
         });
         // lấy product_id
        order_product_id = [];
        $('input[name="order_product_id"]').each(function (){
            order_product_id.push($(this).val());
        });
            $.ajax({
                url: '{{url('/update-order-quantity')}}',
                method:'POST',
                data : {order_status:order_status,order_id:order_id,_token:_token,quantity:quantity,order_product_id:order_product_id},
                success:function (){
                    alert('Thay doi tinh trang don hang thanh cong');
                    location.reload();
                }
            });


    });

    });
</script>
<script type="text/javascript">
       $('.update_quantity_order').click(function () {
           var order_product_id = $(this).data('product_id');
           var order_qty = $('.order_quantity_' + order_product_id).val();
           var order_code = $('.order_code').val();
           var _token = $('input[name="_token"]').val();

           // lấy quantity
           quantity = [];
           $('input[name="product_sales_quantity"]').each(function () {
               quantity.push($(this).val());
           });
           // lấy product_id
           order_product_id = [];
           $('input[name="order_product_id"]').each(function () {
               order_product_id.push($(this).val());
           });
           j = 0;
           for(i = 0;i < order_product_id.length ; i++){
                     // so luong khach hang dat
                      var order_qty = $('.order_quantity_' + order_product_id[i]).val();
                      //so luong ton kho
                       var order_qty_storage = $('.order_qty_storage_' + order_product_id[i]).val();

                       if (parseInt(order_qty) >= parseInt(order_qty_storage)){
                           j = j +1;
                           if (j = 1){
                               alert('so luong ban trong kho khong du');
                           }
                           $('.color_quantity_' + order_product_id[i]).css('background','red');
                       }
           }
           if (j == 0){


           $.ajax({
               url: '{{url('/update-quantity-order')}}',
               method: 'POST',
               data: {order_product_id: order_product_id, order_qty: order_qty, _token: _token, order_code: order_code},
               success: function () {
                   alert('Cập nhật số lượng thành công');
                   location.reload();
               }
           });
       }
       });
</script>

<script>
      $(document).ready(function (){
          load_gallery();
         function load_gallery(){
             var pro_id =  $('.pro_id').val();
             var _token = $('input[name="_token"]').val();
             // alert(pro_id);
             $.ajax({
                url:'{{url('/select-gallery')}}',
                 method: 'POST',
                 data:{pro_id:pro_id,_token:_token},
                 cache: false,
                 dataType:'json',
                 success:function (dataResult){
                    // console.log(dataResult);

                     var output = '';
                 if (dataResult.length > 0){
                     output += '<form> @csrf <table class="table table-hover"> <thead> <tr> <th>Tên hình ảnh</th> <th>Hình ảnh</th> <th>Quản lý</th> </tr> </thead> <tbody>'

                     $.each(dataResult,function (index,row){
                         output += '<tr>'
                         output += ' <td contenteditable="true" class="edit_gallery_name" data-gallery_id="'+row.id+'">'+row.name+'</td>'
                             + '<td><img src="'+row.image+'" class="img-thumbnail" width="120px">'
                             +'<input type="file" class="file_image" style="width: 40%" data-gallery_id="'+row.id+'" id="file-'+row.id+'" name="file" accept="image/*">'

                             +'</td>'
                             +' <td><button type="button" class="btn btn-danger delete-gal" data-gallery_id="'+row.id+'">Xóa</button></td>'
                             +'</tr>'
                     });
                 }else{
                     output +='<tr> <td colspan="4">Sản phẩm này chưa có ảnh</td> </tr>';
                 }


                    $('#gallery_load').html(output);
                 }
             });
         }
         $('#file').change(function (){
             var error = "";
             var file = $('#file')[0].files;

             if (file.length > 5){
                 error += '<p>Bạn chọn tối đa chỉ được 5 ãnh</p>';
             }else if(file.size > 2000000){
                 error += '<p>Bạn chọn tối đa chỉ được lớn hơn 2MB</p>';
             }else if(file.length == ""){
                 error += '<p>Bạn chọn không thể bỏ trống ãnh</p>';
             }
             if (error == ""){

             }else{
                 $('#file').val('');
                 $('#error_gallery').html('<span class="text-danger">'+error+'</span>');
                 return false;
             }
         });

           $(document).on('blur','.edit_gallery_name',function (){
                 var gal_id = $(this).data('gallery_id');
                 var gal_text = $(this).text();
                 var _token = $('input[name="_token"]').val();
                 $.ajax({
                     url:'{{url('/update-gallery-name')}}',
                     method:'POST',
                     data:{gal_id:gal_id,gal_text:gal_text,_token:_token},
                     success:function (data){
                           load_gallery();
                         $('#error_gallery').html('<span class="text-danger">Cập nhật hình ảnh thành công</span>');

                     }
                 });
           });

           $(document).on('click','.delete-gal',function (){
               var gal_id = $(this).data('gallery_id');
               var _token = $('input[name="_token"]').val();
               if (confirm('Bạn có muốn xóa ảnh này không ?')){
                   $.ajax({
                       url:'{{url('/delete-gallery')}}',
                       method:'POST',
                       data:{gal_id:gal_id,_token:_token},
                       success:function (data){
                           load_gallery();
                           $('#error_gallery').html('<span class="text-danger">Xóa hình ảnh thành công</span>').fadeOut(2000);
                           location.reload();

                       }
                   });
               }

           });

           $(document).on('change','.file_image',function (){
               var gal_id = $(this).data('gallery_id');
               var image = document.getElementById('file-'+gal_id).files[0];

               var form_data =  new FormData();
               form_data.append('file',document.getElementById('file-'+gal_id).files[0]);
               form_data.append('gallery_id',gal_id);


                   $.ajax({
                       url:'{{url('/update-gallery-image')}}',
                       method:'POST',
                       headers:{
                           'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                       },
                       data:form_data,
                       contentType:false,
                       cache:false,
                       processData:false,
                       success:function (data){
                           load_gallery();
                           $('#error_gallery').html('<span class="text-danger">Cập nhật hình ảnh thành công</span>');

                       }
                   });


           });

      });
</script>

{{--//commnet--}}
<script>
    $(document).ready(function (){
    $('.comment_active').click(function (){
        var comment_status = $(this).data('comment_status');
        var comment_id = $(this).data('comment_id');
        var comment_product_id = $(this).attr('id');
        var _token = $('input[name="_token"]').val();
        if (comment_status == 1){
            var alert = 'Duyệt bình luận thành công';
        }else{
            var alert = 'Thay đổi bình luận đã duyệt bình luận thành công';
        }
        $.ajax({
            url:'{{url('/allow-comment')}}',
            method:'POST',

            data:{comment_id:comment_id,comment_product_id:comment_product_id,comment_status:comment_status,_token:_token},

            success:function (data){
                location.reload();

                $('#notify_commentt').html('<span class="text-danger">'+alert+'</span>');

            }
        });

    });

      $('.btn-reply-comment').click(function (){
          var comment_id = $(this).data('comment_id');
         var comment = $('.reply_comment_'+comment_id).val();

          var comment_product_id = $(this).data('product_id');
          var _token = $('input[name="_token"]').val();


          $.ajax({
              url:'{{url('/reply-comment')}}',
              method:'POST',

              data:{comment_id:comment_id,comment_product_id:comment_product_id,comment:comment,_token:_token},

              success:function (data){
                   $('.reply_comment_'+comment_id).val('');
                  $('#notify_comment').html('<span class="text-danger">Trả lời bình luận thành công</span>');

              }
          });
      })
    });
</script>
{{--//commnet--}}

{{--//thongke--}}
<script>
    $( function() {
        $( "#datepicker" ).datepicker({
            prevText:'Tháng trước',
            nextText:'Tháng sau',
            dateFormat :'yy-mm-dd',
            dayNamesMin: ['Thứ 2' ,'Thứ 3' ,'Thứ 4' ,'Thứ 5' ,'Thứ 6' ,'Thứ 7' ,'Chủ nhật' ,],
            duration:'slow'
        });
        $( "#datepicker2" ).datepicker({
            prevText:'Tháng trước',
            nextText:'Tháng sau',
            dateFormat :'yy-mm-dd',
            dayNamesMin: ['Thứ 2' ,'Thứ 3' ,'Thứ 4' ,'Thứ 5' ,'Thứ 6' ,'Thứ 7' ,'Chủ nhật' ,],
            duration:'slow'
        });
    });
</script>

<script>
    $(document).ready(function (){
        chart30days();

      var chart =  new Morris.Area({
            // ID of the element in which to draw the chart.

            element: 'chart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            //option chart
             lineColors:['#819C79','#FC8710','#FF6541','#A4ADD3','#766B56'],
          //    pointFillColors: ['#ffffff'],
          //    pointStrokeColors: ['black'],
          //    fillOpacity:0.3,
          //    hideHover:'auto',
          //    parseTime:false,
          //
          //   // The name of the data record attribute that contains x-values.
          //
          //   xkey: 'period',
          //   // A list of names of data record attributes that contain y-values.
          //   ykeys: ['order','profit','sales','quantity'],
          // behaveLikeLine: true,
          //   // Labels for the ykeys -- will be displayed when you hover over the
          //   // chart.
          //   labels: ['Đơn hàng','Doanh số','Lợi nhuận','Số lượng']


          parseTime: false,
          hideHover: 'auto',
          xkey: 'period',
          ykeys: ['order','sales','profit','quantity'],
          labels: ['đơn hàng','Lợi nhuận','Doanh số','số lượng']
        });

        $('.dashboard-filter').change(function (){
            var _token = $('input[name="_token"]').val();
            var dashboard_value = $(this).val();
            // alert(dashboard_value);
            $.ajax({
                url:'{{url('/dashbord-filter')}}',
                method:'POST',
                dataType: 'JSON',

                data:{dashboard_value:dashboard_value,_token:_token},
                success:function(data){
                    chart.setData(data);
                }
            });
        });

         function chart30days(){
             var _token  = $('input[name="_token"]').val();
             $.ajax({
                 url:'{{url('/days-order')}}',
                 method:'POST',
                 dataType: 'JSON',
                 cache:false,
                 data:{_token:_token},
                 success:function(data){
                     chart.setData(data);
                 }
             });
         }
        $('#btn-dashboard-filter').click(function (){
           var _token = $('input[name="_token"]').val();
           var from_date = $('#datepicker').val();
           var to_date = $('#datepicker2').val();

            $.ajax({
               url:'{{url('/filter-by-date')}}',
                method:'POST',
                dataType: 'JSON',
                data:{from_date:from_date,to_date:to_date,_token:_token},
                success:function(data){
                    chart.setData(data);
                }
            });
        });
    })
</script>

<script>
    var colorDanger = "#FF1744";
    Morris.Donut({
        element: 'donut',
        resize: true,
        colors: [
            '#f54242',
            '#f5b342',
            '#8df542',
            '#42f5f5',

        ],
        labelColor:"#cccccc", // text color
        //backgroundColor: '#333333', // border color
        data: [
            {label:"Sản phẩm", value:<?php echo $product_donut; ?>, color:colorDanger},
            {label:"Bài viết", value:<?php echo $post_donut;   ?>},
            {label:"Đơn hàng", value:<?php echo $order_donut;  ?>},
            {label:"Khách hàng", value:<?php echo $customer_donut; ?>},

        ]
    });
</script>
{{--//thongke--}}


{{--//date insert-coupon--}}
<script>
    $( function() {
        $("#start_coupon").datepicker({
            prevText:'Tháng trước',
            nextText:'Tháng sau',
            dateFormat :'dd/mm/yy',
            dayNamesMin: ['Thứ 2' ,'Thứ 3' ,'Thứ 4' ,'Thứ 5' ,'Thứ 6' ,'Thứ 7' ,'Chủ nhật' ,],
            duration:'slow'
        });
        $("#end_coupon").datepicker({
            prevText:'Tháng trước',
            nextText:'Tháng sau',
            dateFormat :'dd/mm/yy',
            dayNamesMin: ['Thứ 2' ,'Thứ 3' ,'Thứ 4' ,'Thứ 5' ,'Thứ 6' ,'Thứ 7' ,'Chủ nhật' ,],
            duration:'slow'
        });
    });
</script>
{{--//date insert-coupon--}}

</body>
</html>
