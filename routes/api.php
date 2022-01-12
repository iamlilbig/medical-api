<?php

use App\Http\Controllers\api\v1\MedicalInformationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::prefix('v1')->group(function(){
    Route::post('login',[
        \App\Http\Controllers\api\v1\UserController::class,'login'
    ]);

    Route::post('register',[
        \App\Http\Controllers\api\v1\UserController::class,'register'
    ]);

    Route::middleware('auth:sanctum')->group(function(){
        Route::post('confirm-phone',[
            \App\Http\Controllers\api\v1\UserController::class,'confirmPhone'
        ]);

        Route::prefix('users')->group(function (){
            Route::get('show',[
                \App\Http\Controllers\api\v1\UserController::class,'show'
            ]);

            Route::put('update',[
                \App\Http\Controllers\api\v1\UserController::class,'update'
            ]);

            Route::delete('tokens/delete',[
                \App\Http\Controllers\api\v1\UserController::class,'tokenDelete'
            ]);

            Route::delete('delete',[
                \App\Http\Controllers\api\v1\UserController::class,'delete'
            ]);

            Route::prefix('medical-information')->group(function(){
                Route::get('/',[
                    \App\Http\Controllers\api\v1\MedicalInformationController::class,'show'
                ]);

                Route::post('/',[
                    \App\Http\Controllers\api\v1\MedicalInformationController::class,'store'
                ]);

                Route::put('/',[
                    \App\Http\Controllers\api\v1\MedicalInformationController::class,'update'
                ]);

                Route::delete('/',[
                    \App\Http\Controllers\api\v1\MedicalInformationController::class,'destroy'
                ]);
            });
        });
    });
});
