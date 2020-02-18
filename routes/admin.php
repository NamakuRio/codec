<?php

Route::name('admin.')->group(function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::name('account.')->prefix('account')->group(function () {
        Route::get('/', 'AccountController@index')->name('index');
        Route::put('/', 'AccountController@update')->name('update');
    });

    Route::name('users.')->prefix('users')->group(function () {
        Route::get('/', 'UserController@index')->name('index');

        Route::middleware('ajax')->group(function () {
            // CRUD
            Route::post('/', 'UserController@store')->name('store');
            Route::post('/show', 'UserController@show')->name('show');
            Route::put('/', 'UserController@update')->name('update');
            Route::delete('/', 'UserController@destroy')->name('destroy');

            // manage user
            Route::post('/manage', 'UserController@showManage')->name('show.manage');
            Route::put('/manage', 'UserController@manage')->name('manage');

            // server-side datatable
            Route::post('/get-users', 'UserController@getUsers')->name('getUsers');

            Route::post('/check-username', 'UserController@checkUsername')->name('checkUsername');
        });
    });

    Route::name('roles.')->prefix('roles')->group(function () {
        Route::get('/', 'RoleController@index')->name('index');

        Route::middleware('ajax')->group(function () {
            // CRUD
            Route::post('/', 'RoleController@store')->name('store');
            Route::post('/show', 'RoleController@show')->name('show');
            Route::put('/', 'RoleController@update')->name('update');
            Route::delete('/', 'RoleController@destroy')->name('destroy');

            // manage role
            Route::post('/manage', 'RoleController@showManage')->name('show.manage');
            Route::put('/manage', 'RoleController@manage')->name('manage');

            // set default
            Route::put('/set-default', 'RoleController@setDefault')->name('setDefault');

            // server-side datatable
            Route::post('/get-roles', 'RoleController@getRoles')->name('getRoles');

            Route::post('/select2', 'RoleController@select2')->name('select2');
        });
    });

    Route::name('permissions.')->prefix('permissions')->group(function () {
        Route::get('/', 'PermissionController@index')->name('index');

        Route::middleware('ajax')->group(function () {
            // CRUD
            Route::post('/', 'PermissionController@store')->name('store');
            Route::post('/show', 'PermissionController@show')->name('show');
            Route::put('/', 'PermissionController@update')->name('update');
            Route::delete('/', 'PermissionController@destroy')->name('destroy');

            // server-side datatable
            Route::post('/get-permissions', 'PermissionController@getPermissions')->name('getPermissions');
        });
    });

    Route::name('settings.')->prefix('settings')->group(function () {
        Route::get('/', 'SettingController@index')->name('index');
        Route::get('/{setting_groups}', 'SettingController@show')->name('show');
    });
});
