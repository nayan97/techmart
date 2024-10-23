<?php

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\Admin\TempImgController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\ProductSubCategoryController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/',[FrontController::class, 'index'])->name('front.index');
Route::get('/shop/{categortSlug?}/{subCategorySlug?}',[ShopController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}',[ShopController::class, 'product'])->name('product.index');

Route::get('/cart',[CartController::class, 'cart'])->name('front.cart');
Route::post('/add-to-cart',[CartController::class, 'addToCart'])->name('front.addToCart');
Route::post('/update-cart',[CartController::class, 'updateCart'])->name('front.updateCart');
Route::post('/delete-cart-item',[CartController::class, 'deleteCartItem'])->name('front.deleteCartItem');
Route::get('/checkout',[CartController::class, 'checkout'])->name('front.checkout');
Route::post('/process-checkout',[CartController::class, 'processCheckout'])->name('front.processCheckout');
Route::get('/thankyou/{orderId}',[CartController::class, 'thankYou'])->name('front.thankyou');

// change order summary
Route::post('get-order-summery',[CartController::class, 'getOrderSummary'])->name('front.getOrderSummary');

//discount code
Route::post('apply-discount',[CartController::class, 'applyDiscount'])->name('front.applyDiscount');
Route::post('remove-discount',[CartController::class, 'removeCoupon'])->name('front.removeCoupon');

// user middleware

Route::group(['prefix' => 'account',], function(){
   Route::group(['middleware' => 'guest'], function(){
    
        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
      
        
        Route::get('/register', [AuthController::class, 'register'])->name('account.register');
        Route::post('/customer-register', [AuthController::class, 'customerRegister'])->name('account.customerRegister');

   });
   Route::group(['middleware' => 'auth'], function(){
        Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::get('/myorder-detail/{orderId}', [AuthController::class, 'orderDetail'])->name('account.orderDetail');
        Route::get('/myorder', [AuthController::class, 'myOrders'])->name('account.myOrders');
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
   });

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
        Route::resource('discountcode', DiscountCodeController::class);
        // products route
        Route::resource('products', ProductController::class);
        Route::get('/product-subcategories', [ProductSubCategoryController::class, 'index'])->name('product-subcategories.index');
        Route::post('/product-image/update', [ProductImageController::class, 'update'])->name('product-images.update');
        Route::delete('/product-image', [ProductImageController::class, 'destroy'])->name('product-images.destroy');
            
        // shiping route
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping', [ShippingController::class, 'store'])->name('shipping.store');           
        Route::get('/shipping/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');           
        Route::put('/shipping/{id}', [ShippingController::class, 'update'])->name('shipping.update');           
        Route::delete('/shipping/{id}', [ShippingController::class, 'destroy'])->name('shipping.delete');  
        
        // order routes
        Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [OrderController::class, 'detail'])->name('orders.detail');
        Route::post('/orders/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('orders.updateStatus');

   


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
