<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/dashboard', function () {
    $user = auth()->user();
    return "
    <!DOCTYPE html>
    <html lang='id'>
    <head>
        <meta charset='UTF-8'>
        <title>Dashboard | Nexora</title>
        <link href='https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700&display=swap' rel='stylesheet'>
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
                background: radial-gradient(circle at 10% 20%, rgba(48, 10, 36, 1) 0%, rgba(26, 8, 38, 1) 45%, rgba(10, 4, 20, 1) 100%);
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                color: #fff;
                margin: 0;
            }
            .card {
                background: rgba(255, 255, 255, 0.03);
                backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.08);
                padding: 40px;
                border-radius: 20px;
                text-align: center;
                box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);
                max-width: 400px;
                width: 100%;
            }
            h1 {
                background: linear-gradient(to right, #c084fc, #f472b6);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-bottom: 8px;
            }
            p {
                color: rgba(255, 255, 255, 0.7);
                font-size: 14px;
            }
            .badge {
                display: inline-block;
                background: rgba(168, 85, 247, 0.2);
                border: 1px solid rgba(168, 85, 247, 0.4);
                color: #c084fc;
                padding: 4px 12px;
                border-radius: 9999px;
                font-size: 12px;
                font-weight: 600;
                margin: 15px 0;
            }
            a {
                display: inline-block;
                margin-top: 20px;
                color: rgba(255, 255, 255, 0.5);
                text-decoration: none;
                font-size: 13px;
                transition: color 0.2s;
            }
            a:hover {
                color: #f472b6;
            }
        </style>
    </head>
    <body>
        <div class='card'>
            <h1>NEXORA</h1>
            <p>Student Productivity Ecosystem</p>
            <div style='margin: 30px 0;'>
                <h3>Selamat Datang, {$user->name}!</h3>
                <p>Email: {$user->email}</p>
                <span class='badge'>Role: {$user->role->name}</span>
                <p style='font-size: 12px; color: rgba(255,255,255,0.4);'>Timezone: {$user->timezone}</p>
            </div>
            <a href='/logout'>Keluar / Logout</a>
        </div>
    </body>
    </html>
    ";
})->middleware('auth')->name('dashboard');

Route::get('/logout', function () {
    auth()->logout();
    return redirect()->route('login');
})->name('logout');
