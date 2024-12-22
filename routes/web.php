<?php

use App\Http\Livewire\Blog\Blog;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Kategori\Kategori;
use App\Http\Livewire\Dashboard\Dashboard;
use App\Http\Livewire\Mahasiswa\Mahasiswa;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Livewire\Beautifier\Code;
use App\Http\Livewire\Beautifier\Html;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->name('login');

Route::post('/', [AuthenticatedSessionController::class, 'store']);

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    Route::get('beautifier/code', Code::class);
    Route::get('beautifier/html', Html::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('kategori', Kategori::class)->name('kategori');
    Route::get('blog', Blog::class)->name('blog');
    Route::get('mahasiswa', Mahasiswa::class)->name('mahasiswa');
});

Route::group(['middleware' => ['auth', 'role:user']], function () {
});

Route::group(['middleware' => ['auth', 'role:developer']], function () {
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__ . '/auth.php';
