<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use App\Models\Admin;
class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('hasrole',function (){
            if (Auth::guard('admin')->user()){
                if(Auth::guard('admin')->user()->hasAnyRoles(['SuperAdmin','admin'])){
                    return true;
                }
            }
            return false;
        });
    }
}
