@extends('layout')
@section('title','View History')
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
                <th>Sản phẩm</th>
                <th>Giá sản phẩm</th>
                <th >Số lượng</th>
                <th >Phí vận chuyển</th>
                <th>Tổng tiền</th>
            </tr>
            @php
                $i = 0;
                $total = 0;
            @endphp
            @foreach($order_Details as $key => $value)
                @php
                    $i++;
                    $subtotal = $value->product_price * $value->product_sales_quantity;
                    $total += $subtotal;
                @endphp
                <tr>
                    <td>{{$i}}</td>
                    <td>{{$value->order_code}}</td>
                    <td>{{$value->product_name}}</td>
                    <td>{{number_format($value->product_price,0,',','.')}} VND</td>
                    <td>{{$value->product_sales_quantity}}</td>
                    <td>{{number_format($value->product_feeship,0,',','.')}} VND</td>
                    <td>{{number_format($subtotal,0,',','.')}} VND</td>
                </tr>
            @endforeach
            <tr>

                <td colspan="10" style="">
                    @php
                        $total_coupon = 0;
                    @endphp
                    @if($coupon_condition == 1)
                        @php
                            $total_after_coupon = ($total * $coupon_number)/100;
                             echo 'Tổng giảm:' .number_format($total_after_coupon,0,',','.'). 'VND';
                            $total_coupon = $total - $total_after_coupon + $value->product_feeship;
                        @endphp
                    @else
                        @php
                            echo 'Tổng giảm:' .number_format($coupon_number,0,',','.'). 'VND';
                                $total_coupon = $total - $coupon_number+ $value->product_feeship;

                        @endphp
                    @endif

                </td>

            </tr>
            <tr >
                <td colspan="8">  Phí vận chuyển:  {{number_format($value->product_feeship,0,',','.').' VND'}}</td><br>

            </tr>
            <tr >

                <td colspan="8">  Tổng đơn hàng:  {{number_format($total_coupon,0,',','.').'VND'}}</td>
            </tr>
        </table>







    </div>

    <!--end wrap shop control-->

    <div class="row">



    </div>
    <div class="wrap-pagination-info">
        <ul class="page-numbers" style="font-size: 26px">





        </ul>
        <p class="result-count">Showing 1-8 of 12 result</p>
    </div>

@endsection

