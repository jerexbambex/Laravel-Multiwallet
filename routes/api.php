<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\UsersController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Wallets\WalletController;
use App\Http\Controllers\Users\UserWalletController;


Route::prefix('/v1')->group(function(){
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/wallets', [WalletController::class, 'index']);
    Route::get('/wallets/{wallet}', [WalletController::class, 'show']);
    Route::get('/users', [UsersController::class, 'index']);
    Route::get('/users/{user}', [UsersController::class, 'show']);

    // User Wallet 
    Route::prefix('/user/wallets')->middleware('auth:api')->group(function () {
        Route::get('/', [UserWalletController::class, 'index']);
        Route::post('/create', [UserWalletController::class, 'store']);
        Route::post('/sendmoney/{wallet}', [UserWalletController::class, 'sendMoney']);
        Route::post('/addmoney/{wallet}', [UserWalletController::class, 'addMoney']);
    });


    // Excel Imports
    Route::get('lgastates', [ImportController::class, 'index']);

});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


