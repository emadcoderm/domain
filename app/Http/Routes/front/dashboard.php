<?php

Route::get('dashboard', [
    'as' => 'user.dashboard',
    'uses' => 'Front\DashboardController@getShow'
]);
