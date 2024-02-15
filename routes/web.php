<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontendController::class, 'welcome']);
Route::get('/dashboard', [HomeController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/user/logout', [HomeController::class, 'logout'])->name('user.logout');
Route::get('/dropzone', [FrontendController::class, 'dropzone']);

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

require __DIR__.'/auth.php';
