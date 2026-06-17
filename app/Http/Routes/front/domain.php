<?php

Route::group(['prefix' => 'domain', 'middleware' => 'auth'], function () {
    Route::get('/', [
        'as' => 'user.domain.list',
        'uses' => 'Front\DomainController@getList'
    ]);

    Route::get('add', [
        'as' => 'user.domain.create',
        'uses' => 'Front\DomainController@getCreate'
    ]);

    Route::post('add', [
        'as' => 'user.domain.create',
        'uses' => 'Front\DomainController@postCreate'
    ]);

    Route::delete('{domainName}/delete', [
        'as' => 'user.domain.delete',
        'uses' => 'Front\DomainController@deleteDomain'
    ]);

    // manage domain
    Route::get('{domainName}/manage', [
        'as' => 'user.domain.manage',
        'uses' => 'Front\DomainController@getManage'
    ]);

    Route::post('{domainName}/dns', [
        'as' => 'user.domain.dns.create',
        'uses' => 'Front\DomainController@postCreateDns'
    ]);

    Route::put('{domainName}/dns/{id}', [
        'as' => 'user.domain.dns.update',
        'uses' => 'Front\DomainController@postUpdateDns'
    ]);

    Route::delete('{domainName}/dns/{id}/delete', [
        'as' => 'user.domain.dns.delete',
        'uses' => 'Front\DomainController@deleteDns'
    ]);
});
