<?php

use App\Http\Controllers\Api\V1\AgendaController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\UsuarioController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('auth/login', [AuthController::class, 'login'])->name('login');
Route::post('usuarios/cadastrar', [UsuarioController::class, 'cadastrar']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::group(['prefix' => 'v1/agendas'], function () {
        Route::post('filtrar', [AgendaController::class, 'filtrarAtividades']);
        Route::post('adicionar', [AgendaController::class, 'adicionarAtividade']);
        Route::put('{id}/atualizar', [AgendaController::class, 'atualizarAtividade']);
        Route::delete('{id}/remover', [AgendaController::class, 'removerAtividade']);
    });

    Route::post('auth/logout', [AuthController::class, 'logout'])->name('logout');
});
