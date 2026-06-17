<?php

Route::get('register', [
    'as' => 'user.register',
    'uses' => 'Front\Auth\AuthController@getRegister'
]);

Route::post('register', [
    'as' => 'user.register',
    'uses' => 'Front\Auth\AuthController@postRegister'
]);

Route::get('login', [
    'as' => 'user.login',
    'uses' => 'Front\Auth\AuthController@getLogin'
]);

Route::post('login', [
    'as' => 'user.login',
    'uses' => 'Front\Auth\AuthController@postLogin'
]);

Route::get('logout', [
    'as' => 'user.logout',
    'uses' => 'Front\Auth\AuthController@getLogout'
]);

Route::controllers([
    'password' => 'Front\Auth\PasswordController',
]);
