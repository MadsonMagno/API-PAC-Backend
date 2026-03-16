<?php

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
    return view('welcome');
});

Route::get('/mailable', function () {
    $solicitacao = \App\Models\Solicitacoes::find(21);

    return new App\Mail\SendSolicitacao($solicitacao);
});



Route::get('send-mail', function () {

    $solicitacao = \App\Models\Solicitacoes::find(55);

    $details = [
        'title' => 'Mail from ItSolutionStuff.com',
        'body' => 'This is for testing email using smtp'
    ];

    \Mail::to('johngna@gmail.com')->send(new \App\Mail\SendConfirmacao($solicitacao));

    dd("Email is Sent.");
});
