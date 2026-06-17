<?php

Route::get('contact', [
    'as' => 'contact',
    'uses' => 'Front\ContactController@getCreate'
]);

Route::post('contact', [
    'as' => 'contact',
    'uses' => 'Front\ContactController@postCreate'
]);
