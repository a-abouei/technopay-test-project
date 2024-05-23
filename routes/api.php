<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function (){

    Route::prefix('backoffice')->group(function (){

        Route::get('orders', [OrderController::class, 'index']);

    });

});
