<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\cartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\CustomerRegister;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
Route::get('/invoice', [HomeController::class, 'invoice'])->name('invoice');

//FrontendController
Route::get('/', [FrontendController::class, 'welcome'])->name('home');
Route::post('/product/get_size', [FrontendController::class, 'get_size']);
Route::post('product/get_stock', [FrontendController::class, 'get_stock']);
Route::get('/product/details/{slug}', [FrontendController::class, 'product_details'])->name('product.details');
Route::get('/product/checkout', [FrontendController::class, 'checkout'])->name('checkout');

//category
Route::get('/category', [CategoryController::class, 'category'])->name('category');
Route::post('/category', [CategoryController::class, 'category_insert'])->name('insert.category');
Route::get('/category/delete/{id}', [CategoryController::class, 'category_delete'])->name('delete.category');
Route::post('/category/update/{id}', [CategoryController::class, 'category_update'])->name('update.category');
Route::post('/category/checked-delete/', [CategoryController::class, 'category_checked_delete'])->name('checked_delete_category');
Route::get('/trash/categories', [CategoryController::class, 'trashed_categories'])->name('trashed.categories');
Route::get('/trash/category/delete/{id}', [CategoryController::class, 'trash_deleted'])->name('trash.delete');
Route::get('/trash/category/restore/{id}', [CategoryController::class, 'trash_restore'])->name('trash.category.restore');
Route::post('/trash/category/checked-delete', [CategoryController::class, 'trash_category_checked_delete'])->name('trashed.category.checked.delete');

//Products
Route::get('/products/add',[ProductController::class, 'add_product'])->name('add.product');
Route::post('/products/getsubcategory',[ProductController::class, 'getsubcategory']);
Route::post('/products/insert',[ProductController::class, 'product_insert'])->name('product.insert');
Route::get('/products/list',[ProductController::class, 'product_list'])->name('product.list');
Route::get('/products/view/{id}',[ProductController::class, 'product_view'])->name('product.view');
Route::get('/products/delete/{id}',[ProductController::class, 'product_delete'])->name('delete.product');
Route::post('/product/show',[ProductController::class, 'product_show'])->name('show.product');

//Inventory
Route::get('/products/inventory/{id}',[InventoryController::class, 'inventory'])->name('inventory');
Route::post('/products/inventory_add',[InventoryController::class, 'inventory_add'])->name('add.inventory');
Route::get('/products/inventory_delete/{id}',[InventoryController::class, 'inventory_delete'])->name('inventory.delete');
// Sub-Category

Route::get('/sub-category', [SubCategoryController::class, 'sub_category'])->name('sub-category');
Route::post('/sub-category/insert', [SubCategoryController::class, 'sub_category_insert'])->name('sub_category.insert');
Route::post('/sub-category/update/{id}', [SubCategoryController::class, 'sub_category_update'])->name('sub_category.update');
Route::get('/sub-category/delete/{id}', [SubCategoryController::class, 'sub_category_delete'])->name('sub_category.delete');

//user
Route::get('/user/edit', [UserController::class, 'edit_user'])->name('edit.user');
Route::get('/user/user_list', [UserController::class, 'user_list'])->name('user.list');
Route::post('/user/update', [UserController::class, 'update_user'])->name('update.user');
Route::get('/user/delete/{id}', [UserController::class, 'user_delete'])->name('user.delete');
Route::post('/user/password', [UserController::class, 'change_password'])->name('change.password');
Route::post('/user/profile_pic', [UserController::class, 'change_profile_pic'])->name('change.profile.pic');

//profile
Route::middleware('auth')->group(function () {
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/profile/orders', [ProfileController::class, 'customer_orders'])->name('customer.orders');
Route::get('/download/invoice/{id}', [ProfileController::class, 'download_invoice'])->name('download.invoice');

//Tags
Route::get('/product/tags',[TagController::class, 'tags'])->name('tag.list');
Route::post('/product/tags/insert',[TagController::class, 'tags_insert'])->name('insert.tag');
Route::get('/product/tags/delete/{id}',[TagController::class, 'tags_delete'])->name('tag.delete');

//Brand

Route::get('/brand', [BrandController::class, 'brand'])->name('brand');
Route::post('/brand/insert', [BrandController::class, 'brand_insert'])->name('insert.brand');
Route::get('/brand/delete/{id}', [BrandController::class, 'brand_delete'])->name('delete.brand');

//variation
Route::get('/variation', [InventoryController::class, 'variation'])->name('variation');
Route::post('/variation/add_color', [InventoryController::class, 'add_color'])->name('add.color');
Route::post('/variation/add_size', [InventoryController::class, 'add_size'])->name('add.size');

//banner
Route::get('/banner', [BannerController::class, 'banner'])->name('banner');
Route::post('/banner/add', [BannerController::class, 'banner_add'])->name('add.banner.slider');
Route::get('/banner/status/{id}', [BannerController::class, 'banner_status'])->name('banner.status');
Route::get('/banner/delete/{id}', [BannerController::class, 'banner_delete'])->name('banner.delete');

//Newsletter 
Route::get('/newsletter' , [NewsletterController::class, 'newsletter'])->name('newsletter');
Route::post('/newsletter/update' , [NewsletterController::class, 'newsletter_update'])->name('newsletter.update');
Route::post('/newsletter/store' , [NewsletterController::class, 'newsletter_store'])->name('newsletter.store');

//customer register
Route::get('/user/register', [CustomerRegister::class, 'register'])->name('user.register');
Route::get('/user/login', [CustomerRegister::class, 'user_login'])->name('user.login');
Route::get('/user/logout', [CustomerRegister::class, 'user_logout'])->name('user.logout');
Route::post('/user/login/post', [CustomerRegister::class, 'user_login_post'])->name('user.login.post');
Route::post('/user/profile/update', [CustomerRegister::class, 'user_profile_update'])->name('user.profile.update');
Route::post('/user/register/store', [CustomerRegister::class, 'register_store'])->name('register.store');
Route::get('/user/profile', [CustomerRegister::class, 'user_profile'])->name('user.profile')->middleware('customer');

//add to cart
Route::post('product/add_to_cart/{product_id}', [cartController::class, 'add_to_cart'])->name('add.cart');
Route::post('product/update_cart', [cartController::class, 'update_cart'])->name('update.cart');
Route::get('product/delete_cart/{id}', [cartController::class, 'delete_cart'])->name('delete.cart');
Route::get('product/cart/{customer_id}', [cartController::class, 'cart'])->name('cart');

//coupon
Route::get('/coupon' , [CouponController::class, 'coupon'])->name('coupon');
Route::post('/coupon/store' , [CouponController::class, 'coupon_store'])->name('coupon.store');
Route::get('/coupon/delete/{id}' , [CouponController::class, 'coupon_delete'])->name('delete.coupon');

//Checkout
Route::post('product/order_confirm', [CheckoutController::class , 'order_confirm'])->name('order.confirm');
Route::post('/get_cities', [CheckoutController::class , 'get_cities']);
Route::get('/order_placed', [CheckoutController::class , 'order_placed']);

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::get('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END
  
//StripePayment
Route::controller(StripePaymentController::class)->group(function(){
    Route::get('stripe', 'stripe')->name('stripe');
    Route::post('stripe/{id}', 'stripePost')->name('stripe.post');
});

//Orders
Route::get('/orders' , [OrderController::class , 'orders'])->name('orders');
Route::post('/order/status_change/{id}' , [OrderController::class , 'status_change'])->name('order.change.status');
Route::post('/review/store/{id}' , [OrderController::class , 'review_store'])->name('review.store');


require __DIR__.'/auth.php';
