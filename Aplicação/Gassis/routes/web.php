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

Route::get('/', ['as'=> '/','uses'=>'Controller@homepage']);

#==========================================================================

#--------------------------------------------------------------------------
// routes to auth
#--------------------------------------------------------------------------


Route::get('/login', ['as'=>'login','uses'=>'Controller@login']);

Route::post('/auth', ['as'=> 'auth' ,'uses'=>'AdminDashboardController@auth']);

Route::group(['middleware' => 'auth'], 
function() { 

    Route::get('/dashboard', ['as'=> 'dashboard','uses'=>'Controller@dashboard']);
    Route::get('/reqTables', ['as'=> 'reqTables','uses'=>'AdminDashboardController@reqTables']);
    Route::get('/logout', ['as'=> 'admin.logout' ,'uses'=>'AdminDashboardController@logout']);
    Route::get('/index', ['as'=> 'index' ,'uses'=>'AdminDashboardController@index']);
    Route::resources(['admin'=>'AdminsController']); 
    Route::get('/register', ['as'=> 'register' ,'uses'=>'AdminsController@register']);
    Route::post('/adminStore', ['as'=> 'adminStore' ,'uses'=>'AdminsController@store']);

    Route::resources(['tipoSol'=>'TipoSolicitantesController']);
    Route::post('/tipoSolStore', ['as'=> 'tipoSolStore' ,'uses'=>'TipoSolicitantesController@store']);

}); 


#==========================================================================


#Route::get('1', function () {
 #   return view('welcome');
#});*/
