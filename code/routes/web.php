<?php

use Illuminate\Support\Facades\Route;

Route::get('/messages/', 'MessagesController@index')->name('messages.home');
Route::get('/messages/view-messages', 'MessagesController@view')->name('messages.view');
Route::get('/messages/fill-order', 'MessagesController@fillOrder')->name('messages.fillOrder');
Route::post('/messages/create-order', 'MessagesController@submitOrder')->name('messages.createOrder');

Route::resource('api/messages', 'ApiMessagesController');