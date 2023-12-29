<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SopController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TrailController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\pendaftaranController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index']);
Route::get('/load-more', [TrailController::class, 'loadmore']);

Route::get('/jalur', [TrailController::class, 'index']);

Route::get('/about', [AboutController::class, 'index']);

Route::get('/sop', [SopController::class, 'index']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);


Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);


Route::get('/ticket', [TicketController::class, 'index'])->middleware('auth')->name('ticket.index');
Route::delete('/tiket/{id}', [TicketController::class, 'destroy'])->name('ticket.destroy');

Route::get('/ticket/{id}', [TicketController::class, 'show'])->name('ticket.show');
Route::get('/ticket/{id}/edit', [TicketController::class, 'edit'])->name('ticket.edit');
Route::put('/ticket/{id}', [TicketController::class, 'update'])->name('ticket.update');

Route::get('/pendaftaran', [pendaftaranController::class, 'index'])->middleware('auth');
