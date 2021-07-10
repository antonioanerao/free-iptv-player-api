<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\IptvListController;
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

Route::post('auth/login', [LoginController::class, 'login'])->name('login');
Route::post('live-tv-groups', [IptvListController::class, 'liveTvGroups'])->name('liveTvGroups');
Route::post('live-tv-channels', [IptvListController::class, 'liveTvChannels'])->name('liveTvChannels');
