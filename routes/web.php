<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    if (Auth::check()) {
        return view('utama');
    }else{
        return view('login');
    }
    
})->name('login_again');

Route::post('/login', 'Auth\LoginController@login')->name('login');

Route::group(['middleware' =>['auth']], function () {
    Route::get('/utama', function () {
        return view('utama');
    })->name('utama');

    Route::get('/barang_masuk', function () {
        return view('barang_masuk');
    })->name('barang_masuk');

    Route::get('/barang_keluar', function () {
        return view('barang_keluar');
    })->name('barang_keluar');

    Route::get('/kartu_stock', function () {
        return view('kartu_stock');
    })->name('kartu_stock');

    Route::get('/master_barang', function () {
        return view('master_barang');
    })->name('master_barang');

    Route::get('/order/allOrderNumber', 'OrderController@getAllOrderNumber');
    Route::get('/order/detailOrderByOrderNumber', 'OrderController@detailOrderByOrderNumber');
    Route::post('/order/receiveOrder', 'OrderController@receiveOrder');
    Route::get('/order/allItems', 'OrderController@getAllItems');
    Route::get('/order/checkLastStock', 'OrderController@getLastStockItem');
    Route::post('/order/itemUsage', 'OrderController@itemUsage');
    Route::get('/stockCard', 'StockCardController@getAllStock');
    Route::get('/item/getAllComboboxItemMaster', 'ItemMasterController@getAllComboboxItemMaster');
    Route::get('/item/allItems', 'ItemMasterController@getAllItems');
    Route::post('/item/saveItem', 'ItemMasterController@saveItem');
    Route::post('/item/deleteItem', 'ItemMasterController@deleteItem');
    
});

Route::get('/api/stockCard', 'StockCardController@getAllStock');
