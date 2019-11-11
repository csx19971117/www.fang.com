<?php

//后台路由
Route::group(['namespace'=>'Admin','prefix'=>'admin','as'=>'admin.'],function (){
   Route::get('login','LoginController@index')->name('login');
   Route::post('login','LoginController@login')->name('login');
});