<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\projetoTestesController;



//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', 'App\Http\Controllers\projetoTestesController@index')->name('home');
Route::get('/cadPesFisica', 'App\Http\Controllers\projetoTestesController@cadPessoaFisica')->name('pagina.cadastro');
Route::get('/pagina/update/{cpf}', 'App\Http\Controllers\projetoTestesController@updatePessoaFisica')->name('pagina.update');

Route::POST('/cadastrocpf', '\App\Http\Controllers\projetoTestesController@cadCPF')->name('cpf.cadastrar');
Route::POST('/deletecpf', '\App\Http\Controllers\projetoTestesController@delCPF')->name('cpf.deletar');
Route::post('/alteracpf', '\App\Http\Controllers\projetoTestesController@alteraCPF')->name('cpf.alterar');
