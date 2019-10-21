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
        Route::get('/editPassword', ['as'=> 'editPassword' ,'uses'=>'UserDashboardController@editPassword']);
        Route::post('/updatePassword', ['as'=> 'updatePassword' ,'uses'=>'UsersController@updatePassword']);
        Route::get('/show', ['as'=> 'show' ,'uses'=>'UserDashboardController@show']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================
    

    // USER

        Route::resources(['requester'=>'RequestersController']); 

    //

    #========================================================================================================
    // ASSISTED
    #--------------------------------------------------------------------------------------------------------
        Route::get('/assistedRegister', ['as'=> 'assistedRegister' ,'uses'=>'AssistedsController@register']);
        Route::resources(['assisted'=>'AssistedsController']);
        Route::post('/editAssisted', ['as'=> 'editAssisted' ,'uses'=>'AssistedsController@edit']);

    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================

    #========================================================================================================
    // REQUESTER
    #--------------------------------------------------------------------------------------------------------
        Route::get('/requesterRegister', ['as'=> 'requesterRegister' ,'uses'=>'RequestersController@register']);
        Route::resources(['requester'=>'RequestersController']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================

    #========================================================================================================
    // PRODUCTOR
    #--------------------------------------------------------------------------------------------------------
        Route::get('/productorRegister', ['as'=> 'productorRegister' ,'uses'=>'ProductorsController@register']);
        Route::resources(['productor'=>'ProductorsController']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================


    #========================================================================================================
        // TIPO SOLICITANTE
    #--------------------------------------------------------------------------------------------------------
        Route::resources(['tipoSol'=>'TipoSolicitantesController']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================

    #========================================================================================================
        // DEMANDA
    #--------------------------------------------------------------------------------------------------------
        Route::get('/demandRegister', ['as'=> 'demandRegister' ,'uses'=>'DemandsController@register']);
        Route::post('/demandDetails', ['as'=> 'demandDetails' ,'uses'=>'DemandsController@details']);
        Route::post('/editDemand', ['as'=> 'editDemand' ,'uses'=>'DemandsController@edit']);
        Route::post('/updateDemand', ['as'=> 'updateDemand' ,'uses'=>'DemandsController@update']);
        Route::post('/startProduction', ['as'=> 'startProduction' ,'uses'=>'DemandsController@startProduction']);
        Route::resources(['demand'=>'DemandsController']);
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================


}); 


#==========================================================================


#Route::get('1', function () {
 #   return view('welcome');
#});*/
