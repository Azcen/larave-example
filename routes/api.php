<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Resources\ProductController;
use App\Http\Controllers\Auth\AuthController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', [AuthController::class, 'authenticate']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group([
        'middleware' => 'jwt.verify'
      ], function() {
          Route::get('logout',  [AuthController::class, 'logout']);
          Route::get('user', [AuthController::class, 'user']);
      });
});

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('user',[UserController::class, 'getAuthenticatedUser']);
    Route::resource('user', UserController::class);
    Route::resource('product', ProductController::class);
});
