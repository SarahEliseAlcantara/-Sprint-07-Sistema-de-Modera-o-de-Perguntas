<?php

use App\Http\Controllers\EventoController;
use App\Http\Controllers\ModeracaoController;
use Illuminate\Support\Facades\Route;

Route::get('/', [EventoController::class, 'index'])->name('eventos.index');
Route::get('/eventos/criar', [EventoController::class, 'create'])->name('eventos.create');
Route::post('/eventos', [EventoController::class, 'store'])->name('eventos.store');
Route::get('/eventos/{id}', [EventoController::class, 'show'])->name('eventos.show');
Route::post('/eventos/{id}/perguntas', [EventoController::class, 'storePergunta'])->name('perguntas.store');

// Rota do Ticket #011 protegida por autenticação
Route::post('/perguntas/{pergunta}/votar', [EventoController::class, 'votar'])
    ->middleware('auth')
    ->name('perguntas.votar');


// Sprint 07 - Sistema de Moderação de Perguntas
Route::middleware('auth')->group(function () {
    Route::post('/perguntas/{pergunta}/moderar', [ModeracaoController::class, 'store'])
        ->name('moderacoes.store');

    Route::get('/eventos/{evento}/moderacoes', [ModeracaoController::class, 'index'])
        ->name('moderacoes.index');

    Route::patch('/moderacoes/{moderacao}/status', [ModeracaoController::class, 'updateStatus'])
        ->name('moderacoes.status');
});
