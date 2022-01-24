@extends('admin_layout')
@section('admin_content')
    <div class="container">
        <div class="row my-2">

            <div class="col-lg-4  text-center">
                <img src="{{asset('public/upload/admin/'.$admin->admin_image)}}" class="mx-auto img-fluid img-circle d-block" alt="avatar" width="200px" >


            </div>
            <div class="col-lg-7 ">
                <ul class="nav nav-tabs">

                    <li class="nav-item">
                        <a href="" data-target="#edit" data-toggle="tab" class="nav-link" style="color: whitesmoke;font-style: italic">Edit</a>
                    </li>
                </ul>
                <?php
                $message = \Illuminate\Support\Facades\Session::get('message');
                if ($message){
                    echo '<span style="color: green">'.$message.'</span>';
                    Session::put('message',null);
                }
                ?>
                <div class="">

                    <div class="tab-pane" id="edit">
                        <form role="form" id="frmSample" action="{{url('update-profile')}}" method="post" enctype="multipart/form-data">
                                @csrf
                            <input type="hidden" value="{{$admin->admin_id}}" name="admin_id">
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label" style="color: whitesmoke;font-style: italic">Email</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="email" name="admin_email" value="{{$admin->admin_email}}">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label" style="color: whitesmoke;font-style: italic">Phone</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="admin_phone" value="{{$admin->admin_phone}}" placeholder="Street">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label" style="color: whitesmoke;font-style: italic">Address</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="admin_address" value="{{$admin->admin_address}}" placeholder="Street">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label" style="color: whitesmoke;font-style: italic">Username</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" name="admin_name" value="{{$admin->admin_name}}">
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label" style="color: whitesmoke;font-style: italic">Image</label>
                                <div class="col-lg-9">

                                        <input type="file" id="file" name="admin_image" class=" " >


                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label" style="color: whitesmoke;font-style: italic">Password</label>
                                <div class="col-lg-9">
                                    <input class="form-control"  type="password"  value="{{$admin->admin_password}}" data-validation="length" data-validation-length="min8"  name="pass_confirmation">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label" style="color: whitesmoke;font-style: italic">Confirm password</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="password" value="" data-validation="confirmation"  name="pass" >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <input type="reset" class="btn btn-secondary" value="Cancel">

                                    <button type="submit" name="edit_user" class="btn btn-info">Cập nhật</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

