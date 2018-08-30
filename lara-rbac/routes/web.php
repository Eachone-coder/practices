<?php

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::namespace('Admin')->prefix('admin')->group(function () {
    Auth::routes();

    Route::get('/home', 'HomeController@index')->name('admin.home');

    Route::resource('admin_user', 'AdminUserController')->names('admin.admin_user');
    Route::post('admin_user/destroyall', 'AdminUserController@destroyAll')->name('admin.admin_user.destroy.all');

    Route::resource('permission', 'PermissionController')->names('admin.permission');
    Route::post('permission/destroyall', 'PermissionController@destroyAll')->name('admin.permission.destroy.all');

    Route::resource('role', 'RoleController')->names('admin.role');
    Route::post('role/destroyall', 'RoleController@destroyAll')->name('admin.role.destroy.all');
    Route::get('role/{id}/permissions', 'RoleController@permissions')->name('admin.role.permissions');
    Route::post('role/{id}/permissions', 'RoleController@storePermissions')->name('admin.role.permissions');
});