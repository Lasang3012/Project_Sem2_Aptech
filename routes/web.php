<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomersAPI;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RestoreController;
use Illuminate\Support\Facades\Route;
use  App\Http\Controllers\HomeController;
use  App\Http\Controllers\BrandProduct;
use  App\Http\Controllers\CategoryProduct;
use  App\Http\Controllers\CartController;
use  App\Http\Controllers\CouponController;
use  App\Http\Controllers\CheckOutController;
use  App\Http\Controllers\AdminController;
use  App\Http\Controllers\DeliveryController;
use  App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryPostController;

Route::get('/', [HomeController::class , 'index'] );
Route::get('/trang-chu', [HomeController::class , 'index'] );
Route::get('/shop', [HomeController::class , 'index']);
Route::get('/tim-kiem', [HomeController::class , 'search_product']);
Route::post('/autocomplete-ajax',[HomeController::class,'autocomplete_ajax']);
Route::get('/404',[HomeController::class, 'erorr']);

Route::get('/danhmucsanpham/{category_slug}', [CategoryProduct::class,'show_category_home']);
Route::get('/thuonghieusanpham/{brand_slug}', [BrandProduct::class,'show_brand_home']);
Route::get('/chitietsanpham/{product_id}', [ProductController::class,'detail_product']);
Route::get('/tags/{product_tags}', [ProductController::class,'tag']);
//comment
Route::post('/load-comment',[ProductController::class,'load_comment']);
Route::post('/send-comment',[ProductController::class,'send_comment']);

Route::get('/danhmucbaiviet/{cate_post_slug}', [PostController::class,'danhmucbaiviet']);
Route::get('/bai-viet/{cate_post_slug}', [PostController::class,'baiviet']);
Route::get('/detail', [HomeController::class , 'detail']);
Route::get('/about-us', [HomeController::class , 'about_us']);
Route::get('/contact-us', [HomeController::class , 'contact_us']);
Route::post('/send-mail',[HomeController::class,'sendMail']);
Route::get('/cart', [HomeController::class , 'cart']);
Route::get('/register',[HomeController::class,'register']);
Route::get('/verify_customer/{to_email}/{token}',[CheckOutController::class,'verify_customer']);
Route::get('/quen-mat-khau',[MailController::class,'quen_mat_khau']);
Route::post('/recover-password',[MailController::class,'recover_password']);
Route::get('/update-new-pass',[MailController::class,'update_new_pass']);
Route::post('/reset-new-pass',[MailController::class,'reset_new_password']);


//login google
Route::get('login-customer-google',[CustomersAPI::class,'login_customer_google']);
Route::get('customer/google/callback',[CustomersAPI::class,'callback_customer_google']);

//login facebook
Route::get('/login-customer-facebook',[CustomersAPI::class,'login_customer_facebook']);
Route::get('/customer/facebook/callback',[CustomersAPI::class,'callback_facebook']);

//cart

Route::post('add-cart-ajax',[CartController::class,'add_cart_ajax']);
Route::get('/show-cart-ajax',[CartController::class,'show_cart_ajax']);
Route::get('/show-cart-menu',[CartController::class,'show_cart_menu']);

Route::post('/update-cart-ajax',[CartController::class,'update_cart_ajax']);
Route::get('/delete-ajax/{session_id}',[CartController::class,'delete_cart_ajax']);
Route::post('/save-cart',[CartController::class,'save_cart']);
Route::get('/del-all-cart',[CartController::class,'delete_all_ajax']);


//coupon fontend
Route::post('/check-coupon',[CartController::class,'check_coupon']);
Route::get('/unset-coupon',[CouponController::class,'unset_coupon']);




//check out
Route::get('/logout',[CheckOutController::class,'logout_checkout']);
Route::get('/login-checkout',[CheckOutController::class,'login_checkout']);
Route::post('/login-customer',[CheckOutController::class,'login_customer']);
Route::post('/add-customer',[CheckOutController::class,'add_customer']);
Route::post('/select-delivery-home',[CheckOutController::class,'select_delivery_home']);
Route::post('/calculate-fee',[CheckOutController::class,'calculate_fee']);
Route::get('/unset-fee',[CheckOutController::class,'unset_fee']);
Route::post('/confrim-order',[CheckOutController::class,'confrim_order']);

//history
Route::get('/history',[\App\Http\Controllers\HistoryController::class,'history']);
Route::get('/view-history-order/{order_code}',[\App\Http\Controllers\HistoryController::class,'view_history_order']);
Route::post('/huy-don-hang',[OrderController::class,'huy_don_hang']);

//verify
Route::get('/verify/{to_email}/{token}',[AuthController::class,'verify']);

Route::prefix('/')->middleware('checklogin')->group(function (){
    Route::get('/checkout',[CheckOutController::class,'checkout']);
});





//backend
Route::group(['middleware' => 'prevent-back-history'],function(){
Route::prefix('/')->middleware('checkloginAdmin')->group(function (){


    // start Middelware SuperAdmin
    Route::group(['middleware' => 'auth_roles'  ] , function (){
        Route::post('/assign-roles',[UserController::class,'assign_roles']);
        Route::get('/delete-user-roles/{admin_id}',[UserController::class,'delete_roles']);
        Route::get('/add-user',[UserController::class,'add_user']);
        Route::post('/store-users',[UserController::class,'store_users']);
        Route::get('/delete-slider/{slider_id}',[SliderController::class,'delete_slider']);
        Route::get('/delete-order/{order_code}',[OrderController::class,'delete_order']);
        Route::get('/delete-category/{category_product_id}',[CategoryProduct::class , 'delete_category']);
        Route::get('/delete-brand/{brand_product_id}',[BrandProduct::class , 'delete_brand']);
        Route::get('/delete-Product/{product_id}',[ProductController::class , 'delete_product']);




    });
    // end Middelware SuperAdmin



    // Middelware Admin
    Route::group(['middleware' => 'admin_roles' ] , function (){
   /// Category Product (Danh mục sãn phẩm)
        Route::get('/add-categoryProduct',[CategoryProduct::class , 'add_category_product']);
        Route::post('/save-category' ,[CategoryProduct::class , 'save_category_product']);
        Route::get('/edit-category/{category_product_id}',[CategoryProduct::class , 'edit_category']);
        Route::post('/update-category/{category_product_id}',[CategoryProduct::class , 'update_category']);
        Route::get('/active-category/{category_product_id}',[CategoryProduct::class , 'active_category_product']);
        Route::get('/un_active-category/{category_product_id}',[CategoryProduct::class , 'un_active_category_product']);

    // Brand Product (Thương hiệu sản phẩm)
        Route::get('/add-brandProduct',[BrandProduct::class , 'add_brand_product']);
        Route::post('/save-brand' ,[BrandProduct::class , 'save_brand_product']);
        Route::get('/edit-brand/{brand_product_id}',[BrandProduct::class , 'edit_brand']);
        Route::post('/update-brand/{brand_product_id}',[BrandProduct::class , 'update_brand']);
        Route::get('/active-brand/{brand_product_id}',[BrandProduct::class , 'active_brand_product']);
        Route::get('/un_active-brand/{brand_product_id}',[BrandProduct::class , 'un_active_brand_product']);

        // Product ( sản phẩm )
        Route::get('/add-Product',[ProductController::class , 'add_product']);
        Route::post('/save-Product' ,[ProductController::class , 'save_product']);
        Route::get('/edit-product/{product_id}',[ProductController::class , 'edit_product']);
        Route::post('/update-Product/{product_id}',[ProductController::class , 'update_product']);
        Route::get('/active-product/{product_id}',[ProductController::class , 'active_product']);
        Route::get('/un_active-product/{product_id}',[ProductController::class , 'un_active_product']);


      //coupon Admins
        Route::get('/insert-coupon',[CouponController::class,'insert_coupon']);
        Route::get('/delete-coupon/{coupon_id}',[CouponController::class,'delete_coupon']);
        Route::get('/list-coupon',[CouponController::class,'list_coupon']);
        Route::post('/insert-coupon-code',[CouponController::class,'insert_coupon_code']);
     //send-mail-coupon
        Route::get('/send-coupon-vip/{coupon_time}/{coupon_conditon}/{coupon_number}/{coupon_code}',[MailController::class,'send_coupon_vip']);
        Route::get('/send-coupon/{coupon_time}/{coupon_conditon}/{coupon_number}/{coupon_code}',[MailController::class,'send_coupon']);
        Route::get('/mail-example',[MailController::class,'mail_example']);

      //Banner slider
        Route::get('/manage-slider',[SliderController::class,'manage_slider']);
        Route::get('/add-slider',[SliderController::class,'add_slider']);
        Route::post('/insert-slider',[SliderController::class,'insert_slider']);
        Route::get('/active-slider/{slider_id}',[SliderController::class , 'active_slider']);
        Route::get('/un_active-slider/{slider_id}',[SliderController::class , 'un_active_slider']);

        //User
        Route::get('/user',[UserController::class,'index']);
        //Delivery
        Route::get('/delivery',[\App\Http\Controllers\DeliveryController::class,'delivery']);
        //Category Post
        Route::get('/add-category-post',[CategoryPostController::class,'add_category_post']);
        Route::get('/list-category-post',[CategoryPostController::class,'list_category_post']);
        Route::get('/edit-category-post/{cate_post_id}',[CategoryPostController::class,'edit_category_post_id']);
        Route::post('/save-category-post',[CategoryPostController::class,'save_category_post']);
        Route::post(' /update-category-post/{cate_post_id}',[CategoryPostController::class,'update_category_post']);
        Route::get('/delete-category-post/{cate_post_id}',[CategoryPostController::class,'delete_category_post_id']);

        //post
        Route::get('/add-post',[PostController::class,'add_post']);
        Route::post('/save-post',[PostController::class,'save_post']);
        Route::get('/list-post',[PostController::class,'list_post']);
        Route::get('/edit-post/{post_id}',[PostController::class,'edit_post']);
        Route::post('/update-post/{post_id}',[PostController::class,'update_post']);

        Route::get('/delete-post/{post_id}',[PostController::class,'delete_post']);

        //gallery
        Route::get('/add-gallery/{product_id}',[GalleryController::class,'add_gallery']);
        Route::post('/select-gallery',[GalleryController::class,'select_gallery']);
        Route::post(' /insert-gallery/{product_id}',[GalleryController::class,'insert_gallery']);
        Route::post('/update-gallery-name',[GalleryController::class,'update_gallery_name']);
        Route::post('/delete-gallery',[GalleryController::class,'delete_gallery']);
        Route::post('/update-gallery-image',[GalleryController::class,'update_gallery_image']);

        //comment
        Route::get('/comment',[ProductController::class,'list_comment']);
        Route::post('/allow-comment',[ProductController::class,'allow_comment']);
        Route::post('/reply-comment',[ProductController::class,'reply_comment']);
        Route::get(' /delete-comment/{comment_id}',[ProductController::class,'delete_comment']);

        //restore
        Route::get('category/restore/{id}',[RestoreController::class,'restore_category']);
        Route::get('/category/restore',[RestoreController::class,'index_category']);
        Route::get('/delete_category/restore/{id}',[RestoreController::class,'delete_restore_category']);
        Route::get('brand/restore/{id}',[RestoreController::class,'restore_brand']);
        Route::get('/brand/restore',[RestoreController::class,'index_brand']);
        Route::get('/delete_brand/restore/{id}',[RestoreController::class,'delete_restore_brand']);
        Route::get('product/restore/{id}',[RestoreController::class,'restore_product']);
        Route::get('/product/restore',[RestoreController::class,'index_product']);
        Route::get('/delete_product/restore/{id}',[RestoreController::class,'delete_restore_product']);
    });
    // end Middelware Admin





    Route::get('/dashbord',[AdminController::class , 'show_dashbord']);
    Route::post('/filter-by-date',[AdminController::class,'filter_by_date']);
    Route::post('/dashbord-filter',[AdminController::class,'dashbord_filter']);
    Route::post('/days-order',[AdminController::class,'days_order']);

    //Order-admin
    Route::post('/update-order-quantity',[OrderController::class,'update_order']);
    Route::post('/update-quantity-order',[OrderController::class,'update_quantity_order']);
    Route::get('/manager-order',[OrderController::class,'manager_order']);
    Route::get('view-order/{order_code}',[OrderController::class,'view_order']);
    Route::get('/print-order/{checkout_code}',[OrderController::class,'print_order']);


    // Category Product (Danh mục sãn phẩm)
    Route::get('/all-categoryProduct',[CategoryProduct::class , 'all_category_product']);

    // Brand Product (Thương hiệu sản phẩm)
    Route::get('/all-brandProduct',[BrandProduct::class , 'all_brand_product']);

    // Product ( sản phẩm )
    Route::get('/all-Product',[ProductController::class , 'all_product']);


    // Delivery
    Route::post('/select-delivery',[DeliveryController::class,'select_delivery']);
    Route::post('/insert-delivery',[DeliveryController::class,'insert_delivery']);
    Route::post('/select-feeship',[DeliveryController::class,'select_feeship']);
    Route::post('/update-delivery',[DeliveryController::class,'update_delivery']);
});



Route::get('forget-password',[MailController::class,'forget_password']);
Route::post('recover-password-admin',[MailController::class,'recover_password_admin']);
Route::get('/update-new-pass-admin',[MailController::class,'update_new_pass_admin']);
Route::post('/reset-new-password-admin',[MailController::class,'reset_new_password_admin']);
//backend
Route::get('/admin',   [AuthController::class , 'login_auth']);
//authentication roles
Route::get('/register-auth',[AuthController::class,'register_auth']);
Route::post('/register-admin',[AuthController::class,'register_admin']);
Route::get('/login-auth',[AuthController::class,'login_auth']);
Route::post('/login-admin',[AuthController::class,'login_admin']);
Route::get('/log-out',[AuthController::class , 'log_out']);

//profile
Route::get('profile-user/{id}',[AdminController::class,'profile']);
Route::post('update-profile',[AdminController::class,'update_profile']);

});


Route::get('delete-delivery/{id}',[DeliveryController::class,'delete_delivery']);








Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
