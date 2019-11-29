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
        Route::get('/assistedRemoved', ['as'=> 'assistedRemoved' ,'uses'=>'AssistedsController@removeds']);
        Route::post('/recoverAssisted', ['as'=> 'recoverAssisted' ,'uses'=>'AssistedsController@recover']);

    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================

    #========================================================================================================
    // REQUESTER
    #--------------------------------------------------------------------------------------------------------
        Route::get('/requesterRegister', ['as'=> 'requesterRegister' ,'uses'=>'RequestersController@register']);
        Route::resources(['requester'=>'RequestersController']);
        Route::post('/editRequester', ['as'=> 'editRequester' ,'uses'=>'RequestersController@edit']);
        Route::get('/requesterRemoved', ['as'=> 'requesterRemoved' ,'uses'=>'RequestersController@removeds']);
        Route::post('/recoverRequester', ['as'=> 'recoverRequester' ,'uses'=>'RequestersController@recover']);
  
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================

    #========================================================================================================
    // PRODUCTOR
    #--------------------------------------------------------------------------------------------------------
        Route::get('/productorRegister', ['as'=> 'productorRegister' ,'uses'=>'ProductorsController@register']);
        Route::resources(['productor'=>'ProductorsController']);
        Route::post('/editProductor', ['as'=> 'editProductor' ,'uses'=>'ProductorsController@edit']);
        Route::get('/productorRemoved', ['as'=> 'productorRemoved' ,'uses'=>'ProductorsController@removeds']);
        Route::post('/recoverProductor', ['as'=> 'recoverProductor' ,'uses'=>'ProductorsController@recover']);
  
    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================


    #========================================================================================================
        // TIPO SOLICITANTE
    #--------------------------------------------------------------------------------------------------------
        Route::resources(['tipoSol'=>'TipoSolicitantesController']);
        Route::get('/tipoSolRemoved', ['as'=> 'tipoSolRemoved' ,'uses'=>'TipoSolicitantesController@removeds']);
        Route::post('/recoverTipoSol', ['as'=> 'recoverTipoSol' ,'uses'=>'TipoSolicitantesController@recover']);
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
        Route::get('/demandRemoved', ['as'=> 'demandRemoved' ,'uses'=>'DemandsController@removeds']);
        Route::post('/recoverDemand', ['as'=> 'recoverDemand' ,'uses'=>'DemandsController@recover']);

    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================

    #========================================================================================================
        // PRODUCAO
    #--------------------------------------------------------------------------------------------------------
        Route::post('/productionDetails', ['as'=> 'productionDetails' ,'uses'=>'ProductionsController@details']);
        Route::resources(['production'=>'ProductionsController']);
        Route::get('/productionMateriais', ['as'=> 'productionMateriais' ,'uses'=>'ProductionsController@materiais']);
        Route::get('/productionRemoved', ['as'=> 'productionRemoved' ,'uses'=>'ProductionsController@removeds']);
        Route::post('/recoverProduction', ['as'=> 'recoverProduction' ,'uses'=>'ProductionsController@recover']);
        Route::post('/updateProduction', ['as'=> 'updateProduction' ,'uses'=>'ProductionsController@update']);
        Route::post('/Avaliacao', ['as'=> 'createEvaluation' ,'uses'=>'ProductionsController@update']);
        Route::post('/suspendProduction', ['as'=> 'suspendProduction' ,'uses'=>'ProductionsController@suspend']);

    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================


    #========================================================================================================
        // AVALIAÇÃO
    #--------------------------------------------------------------------------------------------------------

        Route::post('/registerEvaluation', ['as'=> 'registerEvaluation' ,'uses'=>'EvaluationsController@register']);
        Route::resources(['evaluation'=>'EvaluationsController']);
        Route::post('/evaluationShow', ['as'=> 'evaluationShow' ,'uses'=>'EvaluationsController@show']);

    #--------------------------------------------------------------------------------------------------------
    #========================================================================================================


}); 


#==========================================================================


#Route::get('1', function () {
 #   return view('welcome');
#});*/
