<?php

Route::name('admin.')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::name('account.')->prefix('account')->group(function() {
        Route::get('/', 'AccountController@index')->name('index');
    });

    Route::name('users.')->prefix('users')->group(function() {
        Route::get('/', 'UserController@index')->name('index');

        Route::post('/get-users', 'UserController@getUsers')->name('getUsers');
    });

    Route::name('roles.')->prefix('roles')->group(function() {
        Route::get('/', 'RoleController@index')->name('index');

        Route::post('/get-roles', 'RoleController@getRoles')->name('getRoles');
    });

    Route::name('permissions.')->prefix('permissions')->group(function() {
        Route::get('/', 'PermissionController@index')->name('index');
    });

    Route::name('settings.')->prefix('settings')->group(function() {
        Route::get('/', 'SettingController@index')->name('index');
        Route::get('/{setting_groups}', 'SettingController@show')->name('show');
    });
});
