<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductController;
// use App\Http\Controllers\StarRatingController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



// Route::get('/profile', [AuthController::class, 'getUser']);





Route::group(['middleware' => 'auth:api'], function(){
    Route::get('/profile', [AuthController::class, 'profile']);
    
    Route::get("/users", [UserController::class, "index"]);
    Route::get("/users/{id}", [UserController::class, "show"])->where('id', '[0-9]+');
    Route::delete("/users/{id}/delete", [UserController::class, "destroy"])->where('id', '[0-9]+');
    Route::post("/user/{id}/update", [UserController::class, "update"])->where('id', '[0-9]+');
    
    Route::delete("/products/{id}/delete",[ProductController::class, "destroy"])->where('id', '[0-9]+');
    Route::post("/products/create", [ProductController::class, "store"]);
    Route::post("/products/{id}/update", [ProductController::class, "update"])->where('id', '[0-9]+');
    
    Route::post("/reviews/{id}/store", [ReviewController::class, "storeReview"])->where('id', '[0-9]+');
    Route::delete("/reviews/{id}/delete", [ReviewController::class, "destroyReview"])->where('id', '[0-9]+');
    Route::post("/ratings/{id}/store", [ReviewController::class, "storeRating"])->where('id', '[0-9]+');

    Route::get("/cart", [CartController::class, "index"]);
    Route::post("/cart/{id}/store", [CartController::class, "store"])->where('id', '[0-9]+');
    Route::delete("/cart/{id}/delete", [CartController::class, "destroy"])->where('id', '[0-9]+');
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get("/products", [ProductController::class, "index"]);
Route::get("/products/{id}", [ProductController::class, "show"])->where('id', '[0-9]+');




Route::get('/clear', function() {

    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('route:cache');

    return "Cleared!";
});
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



