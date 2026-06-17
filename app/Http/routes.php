<?php

Route::get('/', [
    'as' => 'home',
    'uses' => 'HomeController@index'
]);

Route::post('/check_domain', [
    'as' => 'home.domain.search',
    'uses' => 'HomeController@postCheckDomain'
]);

/**
 * include all route
 */
foreach (new \DirectoryIterator(__DIR__ . '/Routes/front') as $file) {
    if ($file->isFile()) {
        require_once($file->getPathname());
    }
}

/**
 * Only include if the request path is to admin page
 */

$admin = 'admin';

Route::get($admin, [
    'as' => $admin.'.dashboard',
    'uses' => 'Admin\DashboardController@index',
    'middleware' => 'auth.admin'
]);

// if (Request::is($admin.'*')) {
    Route::group(['prefix' => $admin, 'middleware' => 'auth.admin'], function () {
        Route::resource('contact', 'Admin\ContactController', [
            'only' => ['index', 'show', 'destroy']
        ]);
        Route::resource('apikey', 'Admin\ApiKeyController');
        Route::post('zone/{zone}/dns', [
            'as' => 'admin.zone.store_dns',
            'uses' => 'Admin\ZoneController@storeDns',
        ]);
        Route::put('zone/{zone}/dns/{zonedns}', [
            'as' => 'admin.zone.update_dns',
            'uses' => 'Admin\ZoneController@updateDns',
        ]);
        Route::delete('zone/{zone}/dns/{zonedns}', [
            'as' => 'admin.zone.destroy_dns',
            'uses' => 'Admin\ZoneController@destroyDns',
        ]);
        Route::resource('zone', 'Admin\ZoneController');
        Route::resource('user', 'Admin\UserController', [
            'except' => ['create', 'store', 'destroy']
        ]);
        Route::resource('blacklist-domain', 'Admin\BlacklistDomainController');
        Route::resource('page', 'Admin\PageController', [
            'except' => ['show']
        ]);
        Route::resource('user.domain', 'Admin\UserDomainController', [
            'only' => ['show']
        ]);
        Route::resource('setting', 'Admin\SettingController', [
            'only' => ['index', 'edit', 'update']
        ]);
        Route::resource('thanks', 'Admin\ThanksController', [
            'only' => ['index']
        ]);
    });
// }
