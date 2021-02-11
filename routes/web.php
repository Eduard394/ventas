<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'BuyController@home');
Route::get('/comprar', 'BuyController@comprar');
Route::get('/comprar1', 'BuyController@comprar');



/// products
Route::get('/product/new', 'ProductController@formProduct');
Route::post('/product/save', 'ProductController@store');
Route::get('/product/list', 'ProductController@allProducts');
Route::get('/product', 'ProductController@na');

Route::get('/cliente/create', 'ClientesController@create')->name('cliente');
Route::post('/cliente/store', 'ClientesController@store');
Route::get('/cliente/{id}/', 'ClientesController@show');
Route::get('/cliente', 'ClientesController@index');
Route::delete('/cliente/{id}/', 'ClientesController@destroy')->name('cliente.destroy');
Route::put('/cliente/{id}/', 'ClientesController@update')->name('cliente.update');

Route::get('/venta/create', 'VentasController@create')->name('venta');
Route::get('/venta/lista', 'VentasController@lista');
Route::post('/venta/store', 'VentasController@store')->name('venta.store');;
Route::get('/venta/{id}/', 'VentasController@show');
Route::get('/venta', 'VentasController@index');
Route::delete('/venta/{id}/', 'VentasController@destroy')->name('venta.destroy');
Route::put('/venta/{id}/', 'VentasController@update')->name('venta.update');