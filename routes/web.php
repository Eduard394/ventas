<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'BuyController@home');
Route::get('/comprar', 'BuyController@comprar');
Route::get('/comprar1', 'BuyController@comprar');



/// products
Route::get('/product/new', 'ProductController@formProduct');
Route::post('/product/save', 'ProductController@store');
Route::get('/product/list', 'ProductController@allProducts');
