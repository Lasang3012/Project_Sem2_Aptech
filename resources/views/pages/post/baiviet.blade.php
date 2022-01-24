@section('title','Post')

@include('include.header')
<main id="main" class="main-site">

    <div class="container">

        <div class="wrap-breadcrumb">
            <ul>
                <li class="item-link"><a href="#" class="link">home</a></li>
                <li class="item-link"><span>{{$meta_title}}</span></li>
            </ul>
        </div>
    </div>

    <div class="container">




        <div class="row">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">


                @foreach($post as $key => $value)
                    <div class="aboutus-info style-small-left" style="margin: 10px 0">
                       {!! $value->post_content !!}
                    </div>

                @endforeach


            </div>




        </div>


        <!-- </div> -->


    </div><!--end container-->

</main>
@include('include.footer')

