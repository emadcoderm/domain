<?php

Route::get('page/{slug}', [
    'as' => 'page.show',
    'uses' => 'Front\PageController@getShow'
]);
