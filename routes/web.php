<?php

//Auth::routes();

Route::get('/', 'PestController@index')->name('home');
Route::get('detail', 'PestController@index');
Route::get('chooseGame', 'PestController@index');
Route::get('startGame', 'PestController@index');
Route::get('playGame', 'PestController@index');
Route::get('over', 'PestController@index');

Route::post('login', 'PestController@loginPost');
Route::post('pest', 'PestController@pest');
Route::post('pestInfo', 'PestController@pestInfo');
Route::post('storeUserAnswer', 'PestController@storeUserAnswer');
