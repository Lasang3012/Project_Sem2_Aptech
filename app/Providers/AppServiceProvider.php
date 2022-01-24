<?php

namespace App\Providers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*',function ($view){
            $price_max = Product::max('product_price');
            $price_min = Product::min('product_price');
            $max_price_range = $price_max + 100000;
            $min_price_range = $price_min + 100000;

            $product_donut = Product::all()->count();
            $post_donut = Post::all()->count();
            $order_donut = Order::all()->count();
            $customer_donut = Customer::all()->count();

            $product_view = Product::orderBy('product_view','DESC')->take(20)->get();
            $post_view = Post::orderBy('post_view','DESC')->take(20)->get();
            $view->with(compact('product_donut','order_donut','post_donut','customer_donut','product_view','post_view','price_min','price_max'
            ,'max_price_range','min_price_range'));

        });


      Paginator::useBootstrap();
    }
}
