<?php

//后台路由
Route::group(['namespace'=>'Admin','prefix'=>'admin','as'=>'admin.'],function (){
   Route::get('login','LoginController@index')->name('login');
   Route::post('login','LoginController@login')->name('login');



   // 中间件   
Route::group(['middleware'=>['checkadmin:chensixu']],function (){

   // 后台首页  
 Route::get('index','IndexController@index')->name('index');
   
 //欢迎页
//  Route::get('welcome','IndexController@welcome')->name('welcome')->middleware('checkadmin');
 Route::get('welcome','IndexController@welcome')->name('welcome');


 Route::get('logout','IndexController@logout')->name('logout');
 

//  用户管理页
Route::get('user/index','AdminController@index')->name('user.index');

   
   // 用户添加页面 
   Route::get('user/create','AdminController@create')->name('user.create');
   // 用户添加上传
   Route::post('user/create','AdminController@store')->name('user.store');


   // 用户修改页面
   Route::get('user/edit{id}','AdminController@edit')->name('user.edit');
   // 用户修改上传
   Route::put('user/edit{id}','AdminController@update')->name('user.update');   
   // 用户删除操作
   // Route::get('user/delete{id}','AdminController@delete')->name('user.delete');

   Route::delete('user/destroy/{id}','AdminController@destroy')->name('user.destroy');
   // 全选删除
   Route::delete('user/delall','AdminController@delall')->name('user.delall');

   // 个人信息操作
   Route::get('show','IndexController@show')->name('show');
   //恢复
   Route::get('user/restore','AdminController@restore')->name('user.restore');

   Route::resource('role','RoleController');

   // node
   Route::resource('node','NodeController');
    // 路由规则定义  越精确越靠前，越模糊越向后
        // 文件上传 admin/article/upfile  admin/article/{article}
        Route::post('article/upfile','ArticleController@upfile')->name('article.upfile');
          // 文章的封面图片删除
          Route::get('article/delfile','ArticleController@delfile')->name('article.delfile');
        // 文章管理
        Route::resource('article','ArticleController');

   
   
   });

});


