<?php

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

use Illuminate\Support\Facades\DB;
use App\Modelo;
use App\Compra;
use App\Cliente;
use App\Endereco;


Route::group(['middleware'=>['auth']],function(){
	
	Route::get('/', function(){
		return redirect('/dashboard');
	});

	Route::get('/dashboard','DashboardController@dashboardView')->name('pagina.geral');
	Route::post('/dashboard','DashboardController@dashboardWithTime')->name('pagina.geral.set');
	Route::get('/modelos','DashboardController@getModelos')->name('pagina.modelos');
	Route::get('/clientes','DashboardController@getClientes')->name('pagina.clientes');


	Route::get('/cadastrarcliente',function(){return view('cadastrocliente');})
	->name('cad.cliente');
	Route::post("/cadastrandocliente",'ClientController@cadastrarCliente')
	->name('cadastrandocliente');
	Route::get('/editarcliente/{id}','ClientController@editarCliente');
	Route::post('/editandocliente/','ClientController@editandoCliente')
	->name('editandocliente');
	Route::get('/vercliente/{id}','ClientController@verCliente');
	Route::get('/excluircliente/{id}','ClientController@deleteCliente');
	

	Route::get('/vendas','DashboardController@getVendas')->name('pagina.vendas');
	Route::get('/cadastrarvenda','SalesController@formVenda')->name('cad.venda');
	Route::post("/cadastrandovenda" ,'SalesController@cadastrarCompra');
	Route::get('/editarvenda/{id}','SalesController@editarCompra');
	Route::post('/editandovenda/' ,'SalesController@editandoCompra');
	Route::get('/excluirvenda/{id}','SalesController@excluirVenda');
	Route::post('/calculo','SalesController@calculo')->name('calculo');
	

	Route::get('/cadastrarmodelo',function(){return view('cadastromodelo');})->name('cad.modelo');
	Route::post('/cadastrandomodelo'  ,'ModelController@cadastrarModelo');
	Route::get('/editarmodelo/{id}','ModelController@editarModelo');
	Route::post('/editandomodelo/' ,'ModelController@editandoModelo');
	Route::post('/addestoque', 'ModelController@addEstoque');
	Route::get('/getmodelo/{id}','ModelController@getModelo')->name('getmodelo');

	


});


Auth::routes();
