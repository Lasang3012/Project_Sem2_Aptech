@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê Banner
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="0">Bulk action</option>
                        <option value="1">Delete selected</option>
                        <option value="2">Bulk edit</option>
                        <option value="3">Export</option>
                    </select>
                    <button class="btn btn-sm btn-default">Apply</button>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" placeholder="Search">
                        <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="button">Go!</button>
          </span>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th style="width:20px;">
                            <label class="i-checks m-b-none">
                                <input type="checkbox"><i></i>
                            </label>
                        </th>
                        @if(session()->has('message'))
                            <span style="color: green;">{!! session()->get('message') !!} </span>
                        @elseif(session()->has('error'))
                            <span style="color: red;">{!! session()->get('error') !!} </span>
                        @endif
                        <th>Tên Slider</th>
                        <th>Hình ãnh</th>
                        <th>Mô tã</th>
                        <th>Trạng thái</th>

                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($all_slider as $key => $slider)
                        <tr>

                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label></td>
                            <td>{{$slider->slider_name}}</td>
                            <td><img src="{{asset('public/upload/slider/'.$slider->slider_image)}}" width="50px"></td>
                            <td>{{$slider->slider_desc}}</td>
                            <td><span class="text-ellipsis">
                                <?php
                                    if ( $slider->slider_status == 1){
                                    ?>
                           <a href= "{{URL::to('/un_active-slider/'.$slider->slider_id)}}"><span class="fa-thumb-styling fa fa-thumbs-up" style="font-size: 28px; color: green;"></span></a>
                                    <?php
                                    }else{
                                    ?>

                              <a href="{{URL::to('/active-slider/'.$slider->slider_id)}}" ><span class="fa-thumb-styling fa fa-thumbs-down" style="font-size: 28px; color: red;"></span></a>
                                    <?php
                                    }
                                    ?>

                            </span></td>
                            <td>

                                <a onclick="return confirm('Bạn có muốn xóa không ?')" href="{{URL::to('/delete-slider/'.$slider->slider_id)}}" class="active btn btn-danger" ui-toggle-class="">
                                    Xóa banner</a>
                            </td>

                        </tr>
                    @endforeach






                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection

