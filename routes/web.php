<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|----------------------------------------------------------------------
| Web Routes
|----------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/dashboard', function() {
    return view('dashboard');
});

Route::get('/master-pengguna', function() {
    return view('master-pengguna');
});

Route::get('/logout', function () {
    echo "<script>
            localStorage.removeItem('token');
            window.location.href = '/login';
          </script>";
});

Route::get('/users/create', function () {
    return view('form-user');
});

Route::get('/users/{id}/edit', function ($id) {
    return view('form-user', ['id' => $id]);
});

