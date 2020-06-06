<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'prefix' => 'scaling',
], function () {
    Route::get('/eager-loading', 'ScalingController@eagerLoading');
    Route::get('/caching-query-result', 'ScalingController@cachingQueryResult');
});


Route::get('/{md?}', 'MarkdownController');

