<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\Admin\TempImgController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\Admin\SubCategoryController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::group(['prefix' => 'admin',], function(){
    Route::group(['middleware' => 'admin.guest'], function(){
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate',[AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
        
    });

    Route::group(['middleware' => 'admin.auth'], function(){
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class,'logout'])->name('admin.logout');
        // Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::post('/upload-temp-image', [TempImgController::class, 'create'])->name('temp-images.create');
        
        Route::resource('category', CategoryController::class);
        Route::resource('brand', BrandController::class);
        Route::resource('subcategory', SubCategoryController::class);

        // products routes
        Route::get('/product', [ProductController::class, 'index'])->name('product.index');
        Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
        Route::post('/product/create', [ProductController::class, 'store'])->name('product.store');


        // slug creator 

        Route::get('/getSlug', function (Request $request){
            $slug = '';
            if (!empty($request->title)) {
                $slug = Str::slug($request->title);
            }
            return response()->json([
                'status' => true,
                'slug' => $slug
            ]);

        })->name('getSlug');
        


       

    });

});
