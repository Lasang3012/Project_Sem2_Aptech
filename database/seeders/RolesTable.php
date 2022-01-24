<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Roles;
class RolesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Roles::truncate();

        Roles::create(['name'=> 'SuperAdmin']);
        Roles::create(['name'=> 'admin']);
        Roles::create(['name'=> 'user']);


    }
}
