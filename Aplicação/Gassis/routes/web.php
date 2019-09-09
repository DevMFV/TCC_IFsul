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

Route::post('/auth', ['as'=> 'auth' ,'uses'=>'UserDashboardController@auth']);

Route::group(['middleware' => 'auth'], 
function() { 

    #========================================================================================================
    // DASHBOARD
    #--------------------------------------------------------------------------------------------------------
        Route::get('/dashboard', ['as'=> 'dashboard','uses'=>'Controller@dashboard']);
        Route::get('/logout', ['as'=> 'user.logout' ,'uses'=>'UserDashboardController@logout']);
        Route::get('/index', ['as'=> 'index' ,'uses'=>'UserDashboardController@index']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================
    

    // USER

        Route::resources(['requester'=>'RequestersController']); 

    //

    #========================================================================================================
    // ASSISTED
    #--------------------------------------------------------------------------------------------------------
        Route::get('/assistedRegister', ['as'=> 'assistedRegister' ,'uses'=>'AssistedsController@register']);
        Route::post('/assistedStore', ['as'=> 'assistedStore' ,'uses'=>'AssistedsController@store']);
        Route::resources(['assisted'=>'AssistedsController']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================

    #========================================================================================================
    // REQUESTER
    #--------------------------------------------------------------------------------------------------------
        Route::get('/requesterRegister', ['as'=> 'requesterRegister' ,'uses'=>'RequestersController@register']);
        Route::post('/requesterStore', ['as'=> 'requesterStore' ,'uses'=>'RequestersController@store']);
        Route::resources(['requester'=>'RequestersController']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================

    #========================================================================================================
    // PRODUCTOR
    #--------------------------------------------------------------------------------------------------------
        Route::get('/productorRegister', ['as'=> 'productorRegister' ,'uses'=>'ProductorsController@register']);
        Route::post('/productorStore', ['as'=> 'productorStore' ,'uses'=>'ProductorsController@store']);
        Route::resources(['productor'=>'ProductorsController']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================


    #========================================================================================================
        // TIPO SOLICITANTE
    #--------------------------------------------------------------------------------------------------------
        Route::resources(['tipoSol'=>'TipoSolicitantesController']);
        Route::post('/tipoSolStore', ['as'=> 'tipoSolStore' ,'uses'=>'TipoSolicitantesController@store']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================
    
    

}); 


#==========================================================================


#Route::get('1', function () {
 #   return view('welcome');
#});*/
