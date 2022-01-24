@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê users
            </div>

            <div class="table-responsive">
                @if(session()->has('message'))
                    <span style="color: green;">{!! session()->get('message') !!} </span>
                @elseif(session()->has('error'))
                    <span style="color: red;">{!! session()->get('error') !!} </span>
                @endif
                <style>
                    .table > thead > tr > th{
                        color: #0D0A0A;
                    }
                </style>
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>


                        <th>Tên user</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Password</th>
                        <th>Super Admin</th>
                        <th>Admin</th>
                        <th>User</th>



                        <th style="width:30px;"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($admin as $key => $user)
                        <form action="{{url('/assign-roles')}}" method="POST">
                            @csrf
                            <tr>


                                <td>{{ $user->admin_name }}</td>
                                <td>
                                    {{ $user->admin_email }}
                                    <input type="hidden" name="admin_email" value="{{ $user->admin_email }}">
                                    <input type="hidden" name="admin_id" value="{{ $user->admin_id }}">
                                </td>
                                <td>{{ $user->admin_phone }}</td>
                                <td>{{ $user->admin_password }}</td>
                                <td><input type="checkbox" name="SuperAdmin_role"  {{$user->hasRole('SuperAdmin') ? 'checked' : ''}}></td>

                                <td><input type="checkbox" name="admin_role"  {{$user->hasRole('admin') ? 'checked' : ''}}></td>
                                <td><input type="checkbox" name="user_role"  {{$user->hasRole('user') ? 'checked' : ''}}></td>


                                <td>


                                    <p style="margin-bottom:10px"><input type="submit" value="Phân quyền" class="btn btn-sm btn-primary"></p>
                                    <p><a style="width: 100%" class="btn btn-sm btn-danger" href="{{url('/delete-user-roles/'.$user->admin_id)}}">Xóa user</a></p>

                                </td>

                            </tr>
                        </form>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">


                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {{$admin->links()}}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
