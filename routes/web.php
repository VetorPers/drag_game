<?php

//Auth::routes();

Route::get('/', 'PestController@index')->name('home');
Route::get('login', 'PestController@login')->name('login');
Route::post('login', 'PestController@loginPost');

Route::group(['prefix' => 'pest', 'middleware' => ['auth']], function () {
    Route::get('questions/{tree_sign}', 'PestController@questions');
    Route::post('storeUserAnswer', 'PestController@storeUserAnswer');
    Route::get('result', 'PestController@result');
});
