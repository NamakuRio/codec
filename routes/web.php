<?php

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/starter', function() {
    return view('templates.master');
});
