<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PrincipalController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\CitaController;

Route::get('/', [PrincipalController::class, 'index']);
Route::get('/nosotros', [PrincipalController::class, 'nosotros']);
Route::get('/citasf', [PrincipalController::class, 'citas']);
Route::get('/serviciosf', [PrincipalController::class, 'servicios']);
Route::get('/mascotasf', [PrincipalController::class, 'mascotas']);

// Rutas de Servicios
Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
Route::post('/servicios', [ServicioController::class, 'store'])->name('servicios.store');
Route::get('/servicios/{id}/edit', [ServicioController::class, 'edit'])->name('servicios.edit');
Route::put('/servicios/{id}', [ServicioController::class, 'update'])->name('servicios.update');
Route::delete('/servicios/{id}', [ServicioController::class, 'destroy'])->name('servicios.destroy');
Route::get('/servicios/search', [ServicioController::class, 'search'])->name('servicios.search');

// Rutas de Mascotas
Route::get('/mascotas', [MascotaController::class, 'index'])->name('mascotas.index'); 
Route::get('/mascotas/create', [MascotaController::class, 'create'])->name('mascotas.create'); 
Route::post('/mascotas', [MascotaController::class, 'store'])->name('mascotas.store'); 
Route::get('/mascotas/{id}/edit', [MascotaController::class, 'edit'])->name('mascotas.edit'); 
Route::put('/mascotas/{id}', [MascotaController::class, 'update'])->name('mascotas.update'); 
Route::delete('/mascotas/{id}', [MascotaController::class, 'destroy'])->name('mascotas.destroy'); 
Route::get('/mascotas/search', [MascotaController::class, 'search'])->name('mascotas.search'); 

// Rutas de Citas
Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');     
Route::get('/citas/create', [CitaController::class, 'create'])->name('citas.create');  
Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');   
Route::get('/citas/{id}/edit', [CitaController::class, 'edit'])->name('citas.edit'); 
Route::put('/citas/{id}', [CitaController::class, 'update'])->name('citas.update');  
Route::delete('/citas/{id}', [CitaController::class, 'destroy'])->name('citas.destroy');  
Route::get('/citas/search', [CitaController::class, 'search'])->name('citas.search'); 

// Rutas de Vacunas
Route::get('/vacunas', [VacunaController::class, 'index'])->name('vacunas.index');
Route::get('/vacunas/create', [VacunaController::class, 'create'])->name('vacunas.create');
Route::post('/vacunas', [VacunaController::class, 'store'])->name('vacunas.store');
Route::get('/vacunas/{id}/edit', [VacunaController::class, 'edit'])->name('vacunas.edit');
Route::put('/vacunas/{id}', [VacunaController::class, 'update'])->name('vacunas.update');
Route::delete('/vacunas/{id}', [VacunaController::class, 'destroy'])->name('vacunas.destroy');
Route::get('/vacunas/search', [VacunaController::class, 'search'])->name('vacunas.search');