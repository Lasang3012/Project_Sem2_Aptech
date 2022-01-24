<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Roles;
class UserTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Admin::truncate();
//        $adminRoles = Roles::where('name','admin')->first();
//        $authorRoles = Roles::where('name','author')->first();
//        $userRoles = Roles::where('name','user')->first();
//
//        $admin = Admin::create([
//           'admin_name' => 'Nghia Admin',
//            'admin_email' => 'nghiapham1998000@gmail.com',
//            'admin_phone' => '0932093552',
//            'admin_password' => md5('123456')
//        ]);
//
//        $author = Admin::create([
//            'admin_name' => 'sang Author',
//            'admin_email' => 'sang@gmail.com',
//            'admin_phone' => '0932093552',
//            'admin_password' => md5('123456')
//        ]);
//
//        $user = Admin::create([
//            'admin_name' => 'Chien user',
//            'admin_email' => 'Chien@gmail.com',
//            'admin_phone' => '0932093552',
//            'admin_password' => md5('123456')
//        ]);
//
//        $admin->roles()->attach($adminRoles);
//        $author->roles()->attach($authorRoles);
//        $user->roles()->attach($userRoles);
    }
}
