<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['middleware' => ['web'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::any('login','LoginController@login');
    Route::any('code','LoginController@code');
});
Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    Route::get('index','IndexController@index');
    Route::get('info','IndexController@info');
    Route::get('quit','LoginController@quit');
    Route::get('comment','CommentController@index');
    Route::get('visitor','VisitorController@index');
    Route::any('pass','IndexController@pass');
    Route::post('cate/changeorder','CategoryController@changeOrder');
    Route::post('navs/changeorder','NavsController@changeOrder');
    Route::post('config/changeorder','ConfigController@changeOrder');
    Route::post('config/changecontent','ConfigController@changeContent');
    Route::post('comment/allowComment','CommentController@allowComment');
    Route::resource('category','CategoryController');
    Route::resource('article','ArticleController');
    Route::resource('navs','NavsController');
    Route::resource('config','ConfigController');
});

Route::group(['middleware' => ['web'],'namespace'=>'Home'], function () {
    Route::any('/','IndexController@index');
    Route::get('/rss', 'IndexController@rss');
    Route::get('/a/{art_id}','IndexController@article');
    Route::get('/{cate_id}','IndexController@cate')->where('cate_id', '[0-9]+');
    Route::get('/achieve','IndexController@achieve');
    Route::post('comment/create','CommentController@comment');
});
Route::group(['prefix'=>'Wechat','namespace'=>'Wechat'], function () {
    Route::any('/serve','ReplyController@serve');
	Route::any('/menu/set','MenuController@set');
});
