<?php

Route::post('register', 'RegisterController');
Route::post('login', 'LoginController');
Route::post('logout', 'LogoutController');

Route::post('password/forgot', 'Password\ForgotController');
Route::post('password/reset', 'Password\ResetController');

Route::get('me', 'MeController');
