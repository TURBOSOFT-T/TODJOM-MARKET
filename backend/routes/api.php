<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\{
    AuthController,
    CategoryController,
    ConfigController,
    ProduitController,
    SubscriberController,
    UserController,
    ShopController,
    BannerController
};

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/banners', [BannerController::class, 'index']);
Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/config', [ConfigController::class, 'index']);
Route::post('/subscribe', [SubscriberController::class, 'store']);

Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'getuser']);
Route::middleware('auth:sanctum')->post('/update-profile', [UserController::class, 'updateProfile']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/verify/pin', [AuthController::class, 'verifyPin']);
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::post('unauthorized', [AuthController::class, 'unauthorized']);



Route::post('change_password', [AuthController::class, 'change_password']);
Route::post('login', [AuthController::class, 'login']);

Route::post('register', [AuthController::class, 'register']);
//Route::get('getuser', [AuthController::class, 'getuser']);
Route::post('forgotPassword', [AuthController::class, 'forgotPassword']);
Route::post('changepassword', [AuthController::class, 'changepassword']);
Route::post('resetpassword', [AuthController::class, 'resetpassword']);

Route::get('user/activation/{token}', [AuthController::class, 'userActivation']);


//////////////////////SHOP/////////////////////////
Route::post('create-shop', [ShopController::class, 'create_shop']);
Route::post('login-shop', [ShopController::class, 'login_shop']);
Route::post('logoutSeller', [ShopController::class, 'logoutSeller']);
Route::middleware('auth:sanctum')->get('/getseller', [ShopController::class, 'getseller']); 
//Route::middleware('auth:shop')->put('/update-seller-info', [ShopController::class, 'update_seller_info']);
//Route::middleware('auth:sanctum')->put('/update-shop-avatar', [ShopController::class, 'updateAvatar']);
Route::middleware('auth:sanctum')->group(function () {
    Route::put('/update-seller-info', [ShopController::class, 'update_seller_info']);
    Route::put('/update-shop-avatar', [ShopController::class, 'updateAvatar']);
});
 // Route::put('/update-shop-avatar', [ShopController::class, 'updateAvatar']);
 Route::post('create-product', [ProduitController::class, 'create_product']);
 Route::get(
    '/shop/{id_shop}/produits',
    [ProduitController::class, 'produits_shop']
);
Route::get('/product/shop/{id}', [ProduitController::class, 'getByShop']);
Route::get('/get-all-products-shop/{id}', [ProduitController::class, 'getShopProducts']);
Route::delete('/delete-shop-product/{id}', [ProduitController::class, 'delete_shop_product']);
Route::get('/get-all-products-home', [ProduitController::class, 'getHomeProducts']);
Route::get('/products/category/{id}', [ProduitController::class, 'productsByCategory']);
Route::get('/products/search', [ProduitController::class, 'searchProducts']);
Route::get('/products/search', [ProduitController::class, 'search']);
Route::get('/get-all-products', [ProduitController::class, 'get_all_products']);
Route::get('/best-selling-products', [ProduitController::class, 'getBestSellingProducts']);