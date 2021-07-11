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

/* Rota de login */
Route::get('auth/login', [LoginController::class, 'login'])->name('login');

/* Rotas para live tv */
Route::get('live-tv-groups', [IptvListController::class, 'liveTvGroups'])->name('liveTvGroups');
Route::get('live-tv-channels', [IptvListController::class, 'liveTvChannels'])->name('liveTvChannels');

/* Rotas para filmes */
Route::get('movies-groups', [IptvListController::class, 'moviesGroups'])->name('moviesGroups');
Route::get('movies-channels', [IptvListController::class, 'moviesChannels'])->name('moviesChannels');

/* Rotas para series */
Route::get('series-groups', [IptvListController::class, 'seriesGroups'])->name('seriesGroups');
Route::get('series-channels', [IptvListController::class, 'seriesChannels'])->name('seriesChannels');
