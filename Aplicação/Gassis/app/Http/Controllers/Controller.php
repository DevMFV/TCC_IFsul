<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AssistedsController;
use App\Http\Controllers\RequestersController;
use App\Http\Controllers\ProductorsController;
use App\Entities\User;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @var AssistedsController
     */
    protected $assisted;


    public function homepage(){
        return view('welcome');
    }

    /*

                1 -> Assistido
				2 -> Solicitante
				3 -> Produtor
				4 -> Administrador

    */

    public function dashboard(){
            return view('index');
    }

    #--------------------------------------------------------------------------
    // method to requester login VIEW
    #--------------------------------------------------------------------------

    public function login(){
        return view('login');
    }

    //=========================================================================

}
