@extends('layout')
@section('title','History')
@section('content')
    <div class="wrap-shop-control">
        <div class="wrap-breadcrumb">
            <ul>

                <li class="item-link"><span>Lịch sử mua hàng</span></li>
            </ul>
        </div>
        <style>
            table {
                font-family: arial, sans-serif;
                border-collapse: collapse;
                width: 100%;
            }

            td, th {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }

            tr:nth-child(even) {
                background-color: #dddddd;
            }
        </style>


        <table>
            <tr>
                <th>Stt</th>
                <th>Mã đơn hàng</th>
                <th>Ngày đặt hàng</th>
                <th>Tình trạng đơn hàng</th>

                <th style="width: 30px;"></th>
            </tr>
            @php
              $i = 0;
            @endphp
            @if($getorder->count() == 0)
                <tr>
                    <td colspan="5"> <span class="text-danger" style="text-align: center;display: block">Bạn chưa có giao dịch nào</span></td>
                </tr>

            @endif
            @foreach($getorder as $key => $value)

            <tr>
                <th scope="row">{{$getorder->firstItem()+$loop->index}}</th>
                <td>{{$value->order_code}}</td>
                <td>{{$value->created_at}}</td>
                <td>
                    @if($value->order_status == 1)
                        <span class="text-success">Đơn hàng mới</span>
                    @elseif($value->order_status == 2)
                        <span class="text-warning">Đã xử lý</span>
                    @else
                        <span class="text-danger">Đơn hàng đã hủy</span>
                    @endif
                  </td>

                <td>

                    <!-- Button trigger modal -->
                    @if($value->order_status == 1)
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                            Hủy đơn hàng
                        </button>
                        @endif


                    <!-- Modal -->

                    <a class="btn btn-success" href="{{url('view-history-order/'.$value->order_code)}}">Xem đơn hàng</a></td>
            </tr>
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form>
                            @csrf

                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Lý do hủy đơn hàng</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p><textarea rows="5" cols="75" class="lydohuydon" required placeholder="Lý do hủy đơn hàng...(bắt buộc)"></textarea></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                                    <button type="button" id="{{$value->order_code}}" onclick="Huydonhang(this.id)" class="btn btn-primary">Gửi lý do hủy </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach

        </table>







        </div>

   <!--end wrap shop control-->

    <div class="row">



    </div>
    <div class="wrap-pagination-info">
        <ul class="page-numbers" style="font-size: 26px">


            {!! $getorder->links() !!}


        </ul>
        <p class="result-count">Showing 1-8 of 12 result</p>
    </div>

@endsection

