<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('index');
// });
Route::get('/', [TestController::class, 'index'])->name('index');
Route::get('/test', [TestController::class, 'test']);
Route::post('/store', [TestController::class, 'store'])->name('product.store');

// Route::post('login', [AuthenticationController::class, 'login']);

Route::group(['prefix' => 'v2'], function () {

    // Route::post('login', [AuthenticationController::class, 'login']);

});
