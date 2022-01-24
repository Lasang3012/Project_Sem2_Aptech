@extends('admin_layout')
@section('admin_content')


    <div class="container-fluid">
        <style>
            p.title_thongke{
                text-align: center;
                font-size: 20px;
                font-weight: bold;
                color: white;
            }
        </style>
        <div class="row">
             <p class="title_thongke">Thống kê đơn hàng doanh số</p>
            <form autocomplete="off">
                @csrf
                <div class="col-md-2">
                    <p class="title_thongke">Từ ngày : <input type="text" id="datepicker" class="form-control"></p>
                    <input type="button" id="btn-dashboard-filter" class="btn btn-primary btn-sm" value="Lọc kết quả" >
                </div>
                <div class="col-md-2">
                    <p class="title_thongke" >Đến ngày : <input type="text" id="datepicker2" class="form-control"></p>
                </div>
                <div class="col-md-2">
                  <p class="title_thongke">
                      Lọc theo
                      <select class="dashboard-filter form-control">
                          <option>--Chọn--</option>
                          <option value="7ngay">7 Ngày qua</option>
                          <option value="thangtruoc">Tháng trước</option>
                          <option value="thangnay">Tháng này</option>
                          <option value="365ngayqua">365 ngày qua</option>

                      </select>
                  </p>
                </div>
            </form>
            <div class="col-md-12">
                <div id="chart" style="height: 250px;"></div>
            </div>
        </div>


        <div class="row">
            <style>
                table.table-bordered.table-dark{
                    background: #32383e;
                }
                table.table-bordered.table-dark tr th{
                    color: #fff;
                }
            </style>
            <p class="title_thongke">Thống kê truy cập</p>
            <table class="table table-bordered table-dark">
                <thead>
                <tr>
                    <th scope="col">Đang online</th>
                    <th scope="col">Tổng tháng trước</th>
                    <th scope="col">Tổng tháng này</th>
                    <th scope="col">Tổng một năm</th>
                    <th scope="col">Tổng truy cập</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">{{$visitor_count}}</th>
                    <td>{{$visitor_last_month_count}}</td>
                    <td>{{ $visitor_this_month_count}}</td>
                    <td>{{$visitor_in_one_year_count}}</td>
                    <td>{{$vistor_all}}</td>

                </tr>

                </tbody>
            </table>
        </div>

        <div class="row">
             <div class="col-md-4 col-xs-12">
                 <p class="title_thongke">Thống kê sản phẩm bài viết đơn hàng</p>
                 <div id="donut" class="moris-donut-inverse"></div>
             </div>

            <div class="col-md-4 col-xs-12">
                 <p class="title_thongke">Bài viết xem nhiều</p>
                <ul class="list-view">
                    @foreach($post_view as $key => $post)
                     <li>
                         <a target="_blank" style="color: yellow" href="{{url('/bai-viet/'.$post->post_slug)}}">{{$post->post_title}} | <span style="color: black">{{$post->post_view}}</span></a>
                     </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-4 col-xs-12">
                <p class="title_thongke">Sản phẩm xem nhiều</p>
                <ul class="list-view">
                    @foreach($product_view as $key => $product)
                        <li>
                            <a target="_blank" href="{{url('/chitietsanpham/'.$product->product_id)}}">{{$product->product_name}} | <span style="color: black">{{$product->product_view}}</span></a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
@endsection
