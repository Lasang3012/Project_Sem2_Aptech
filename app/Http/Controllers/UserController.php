<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Roles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index(){
        $admin = Admin::with('roles')->orderBy('admin_id','DESC')->paginate(5);
        return view('admin.User.all_user')->with(compact('admin'));
    }
    public function assign_roles(Request $request){


        if (Auth::guard('admin')->id() == $request->admin_id){
            return redirect()->back()->with('message','Ban không được cấp quyền cho chính mình');
        }

        $user = Admin::where('admin_email',$request->admin_email)->first();
        $user->roles()->detach();

        if($request['user_role']){
            $user->roles()->attach(Roles::where('name','user')->first());
        }
        if($request['admin_role']){
            $user->roles()->attach(Roles::where('name','admin')->first());
        }
        if($request['SuperAdmin_role']){
            $user->roles()->attach(Roles::where('name','SuperAdmin')->first());
        }
        return redirect()->back()->with('message','Cấp quyền thành công');
    }

    public function delete_roles ($admin_id){
        if (Auth::guard('admin')->id() == $admin_id){
            return redirect()->back()->with('message','Ban không được xóa chính mình');
        }
        $admin = Admin::find($admin_id);
        if ($admin){
            $admin->roles()->detach();
            $admin->delete();
        }
        return redirect()->back()->with('message','Xóa User thành công');
    }


   public function add_user(){
        return view('admin.User.add_user');
   }


    public function store_users(Request $request){
        $data = $request->all();
        $admin = new Admin();
        $admin->admin_name = $data['admin_name'];
        $admin->admin_phone = $data['admin_phone'];
        $admin->admin_email = $data['admin_email'];
        $admin->admin_password = md5($data['admin_password']);
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $admin->created_at = now();
        $admin->save();

        $admin->roles()->attach(Roles::where('name','user')->first());
        Session::put('message','Thêm users thành công');
        return Redirect::to('user');
    }
}
