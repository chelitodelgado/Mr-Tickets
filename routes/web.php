<?php

use App\Http\Controllers\dashboard\CategoryController;
use App\Http\Controllers\dashboard\ProjectController;
use App\Http\Controllers\dashboard\TicketController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('vendor.adminlte.auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/categorias', [CategoryController::class, 'index'])->name('categorias.index');
Route::post('/categorias/store', [CategoryController::class, 'store'])->name('categorias.store');
Route::get('/categorias/{id}/edit', [CategoryController::class, 'edit'])->name('categorias.edit');
Route::post('/categorias/update', [CategoryController::class, 'update'])->name('categorias.update');
Route::get('/categorias/destroy/{id}', [CategoryController::class, 'destroy'])->name('categorias.destroy');

Route::get('/proyectos', [ProjectController::class, 'index'])->name('proyectos.index');
Route::post('/proyectos/store', [ProjectController::class, 'store'])->name('proyectos.store');
Route::get('/proyectos/{id}/edit', [ProjectController::class, 'edit'])->name('proyectos.edit');
Route::post('/proyectos/update', [ProjectController::class, 'update'])->name('proyectos.update');
Route::get('/proyectos/destroy/{id}', [ProjectController::class, 'destroy'])->name('proyectos.destroy');

Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::post('/tickets/store', [TicketController::class, 'store'])->name('tickets.store');
Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
Route::post('/tickets/update', [TicketController::class, 'update'])->name('tickets.update');
Route::get('/tickets/destroy/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');
