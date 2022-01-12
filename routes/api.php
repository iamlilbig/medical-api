<?php

use App\Http\Controllers\api\v1\AttendantController;
use App\Http\Controllers\api\v1\MedicalInformationController;
use App\Http\Controllers\api\v1\UserController;
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
        UserController::class,'login'
    ]);

    Route::post('register',[
        UserController::class,'register'
    ]);
    Route::post('confirm-phone',[
        UserController::class,'confirmPhone'
    ])->middleware('auth:sanctum');

    Route::middleware(['auth:sanctum','phone.confirm'])->group(function(){
        Route::prefix('users')->group(function (){
            Route::get('/',[
                UserController::class,'show'
            ]);

            Route::put('/',[
                UserController::class,'update'
            ]);

            Route::delete('tokens/',[
                UserController::class,'tokenDelete'
            ]);

            Route::delete('/',[
                UserController::class,'destroy'
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
            Route::apiResource('attendants', AttendantController::class);

            Route::prefix('attendants')->group(function(){
                Route::post('/{attendant}',[
                    AttendantController::class,'sendSMS'
                ]);
            });
        });

    });
});
