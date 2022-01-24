@section('title','Post')

@include('include.header')
<main id="main" class="main-site">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">home</a></li>
                <li class="item-link"><span>list of articles</span></li>
            </ul>
        </div>
    </div>

    <div class="container">
        <!-- <div class="main-content-area"> -->
        <div class="aboutus-info style-center">
            <b style="font-size: 30px;font-style: italic" class="box-title">{{$meta_title}}</b>

        </div>





        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                @foreach($post as $key => $value)
                    <div class="aboutus-info style-small-left" style="margin: 10px 0">
                    <a href="{{url('/bai-viet/'.$value->post_slug)}}">
                       <img style="float: left;width: 40%;padding: 5px" src="{{asset('public/upload/post/'.$value->post_image)}}" alt="{{$value->post_slug}}">
                    </a>
                    <h4 style="padding: 5px;position: relative;top: 10px;left:20px;font-size: 34px;line-height: 50px" class="box-title">
                        <a href="{{url('/bai-viet/'.$value->post_slug)}}" style="color: black">
                            {{$value->post_title}}</a></h4>
                    <p class="txt-content" style="position: relative;top: 10px">{!!$value->post_desc  !!}</p>
                      <div class="text-right">
                          <a href="{{url('/bai-viet/'.$value->post_slug)}}" class="btn btn-default btn-sm">Xem bài viết</a>
                      </div>
                    </div>
                    <div style="clear: both"></div>
                @endforeach


            </div>




        </div>


        <!-- </div> -->


    </div><!--end container-->

</main>
@include('include.footer')
