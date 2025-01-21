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
            var token = localStorage.getItem('token');
            
            if (token) {
                fetch('http://127.0.0.1:8001/api/logout/', {
                    method: 'POST',
                    headers: {
                        'Authorization': 'Bearer ' + token,
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    // Hapus token dari localStorage
                    localStorage.removeItem('token');
                    // Redirect ke halaman login setelah logout
                    window.location.href = '/login';
                })
                .catch(error => {
                    console.error('Logout failed:', error);
                    // Tetap logout dan redirect ke login
                    localStorage.removeItem('token');
                    window.location.href = '/login';
                });
            } else {
                localStorage.removeItem('token');
                window.location.href = '/login';
            }
          </script>";
});


Route::get('/users/create', function () {
    return view('form-user');
});

Route::get('/users/{id}/edit', function ($id) {
    return view('form-user', ['id' => $id]);
});

