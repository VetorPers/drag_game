<?php

//Auth::routes();

Route::get('/', 'PestController@index')->name('home');
Route::post('login', 'PestController@loginPost');
Route::post('pest', 'PestController@pest');
Route::post('pestInfo', 'PestController@pestInfo');
Route::post('storeUserAnswer', 'PestController@storeUserAnswer');
