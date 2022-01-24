@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê bình luận
            </div>

          <div id="notify_comment"></div>
            <form>
                @csrf
            <div class="table-responsive">

                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>

                        @if(session()->has('message'))
                            <span style="color: green;">{!! session()->get('message') !!} </span>
                        @elseif(session()->has('error'))
                            <span style="color: red;">{!! session()->get('error') !!} </span>
                        @endif
                        <th>Duyệt</th>
                        <th>Tên người gửi</th>
                        <th>Bình luận</th>
                            <th>Ngày gửi</th>
                        <th>Sản phẩm</th>
                        <th>Quản lý</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($comment as $key => $comm)
                           @if($comm->comment_parrent ==0 )
                        <tr>
                            <td>
                                @if($comm->comment_status == 0)
                                    <input type="button" data-comment_status="1" data-comment_id="{{$comm->comment_id}}" id="{{$comm->comment_product_id}}" class="comment_status_btn btn btn-primary btn-xs comment_active" value="Duyệt bình luận">
                                @else
                                    <input type="button" data-comment_status="0" data-comment_id="{{$comm->comment_id}}" id="{{$comm->comment_product_id}}" class="comment_status_btn btn btn-danger btn-xs comment_active" value="Bỏ duyêt">
                                 @endif

                            </td>
                            <td>{{$comm->comment_name}}</td>
                            <td>{{$comm->comment}}
                                <ul>
                                    @foreach($comment_rep as $key => $comment_reply)
                                        @if($comment_reply->comment_parrent == $comm->comment_id )
                                            <li>Trả lời :{{$comment_reply->comment}}</li>
                                        @endif
                                    @endforeach
                                </ul>
                                @if($comm->comment_status == 1)
                                    <br><textarea class="reply_comment_{{$comm->comment_id}} form-control" rows="3"></textarea>
                                    <br><button type="button" class="btn btn-default btn-xs btn-reply-comment" data-comment_id="{{$comm->comment_id}}" data-product_id="{{$comm->comment_product_id}}"">Trả lời</button>
                                  @endif
                            </td>
                            <td>{{$comm->comment_date}}</td>
                            <td><a href="{{url('/chitietsanpham/'.$comm->product->product_id)}}">{{$comm->product->product_name}}</a></td>
                            <td>

                                <a onclick="return confirm('Bạn có chắc muốn xóa không ?')" href="{{URL::to('/delete-comment/'.$comm->comment_id)}}" class="active btn btn-danger" ui-toggle-class="">
                                    Xóa comment</a>
                            </td>

                        </tr>
                        @endif
                    @endforeach

                    </tbody>
                </table>
            </div>
            </form>

        </div>
    </div>
@endsection


