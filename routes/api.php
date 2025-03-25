<?php

use App\Http\Controllers\Api\v1\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::prefix("v1")->group(function(){

    // protected route
    Route::middleware("auth:sanctum")->group(function(){
        Route::controller(AuthController::class)->prefix("auth")->group(function(){
            Route::post("save-user-data","saveUserData");
        });
    });

    // unprotected routes
    Route::controller(AuthController::class)->prefix("auth")->group(function(){
        Route::post("login","login");
    });
});
