<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\AgendamentoController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\SolicitacoesController;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login2', [LoginController::class, 'login2'])->name('login2');

Route::apiResource('auth', LoginController::class);

Route::get('usuario/{id}', [UsuarioController::class, 'usuario'])->name('usuario');
Route::post('alterar_senha', [UsuarioController::class, 'alterar_senha'])->name('alterar_senha');
Route::get('usuarios', [UsuarioController::class, 'usuarios'])->name('usuarios');
Route::post('create_user', [UsuarioController::class, 'create_user'])->name('create_user');
Route::get('medicos', [UsuarioController::class, 'medicos'])->name('medicos');
Route::get('convenios', [UsuarioController::class, 'convenios'])->name('convenios');

Route::get('historicos', [AgendamentoController::class, 'getHistoricos'])->name('getHistoricos');
Route::get('paciente', [AgendamentoController::class, 'paciente'])->name('paciente');
Route::get('especialidades', [AgendamentoController::class, 'especialidades'])->name('especialidades');
Route::post('documentos', [SolicitacoesController::class, 'index'])->name('documentos');
Route::get('solicitacao', [SolicitacoesController::class, 'solicitacao'])->name('solicitacao');
Route::get('pesquisa_solicitacao', [SolicitacoesController::class, 'pesquisa_solicitacao'])->name('pesquisa_solicitacao');
Route::get('agendamento/{aviso}/{cpf}', [AgendamentoController::class, 'getByAviso'])->name('getByAviso');
Route::apiResource('agendamento', AgendamentoController::class);
