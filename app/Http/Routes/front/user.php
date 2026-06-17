<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('profile', [
        'as' => 'user.edit.profile',
        'uses' => 'Front\UserController@getEdit'
    ]);

    Route::post('profile', [
        'as' => 'user.edit_profile',
        'uses' => 'Front\UserController@postEdit'
    ]);
});
