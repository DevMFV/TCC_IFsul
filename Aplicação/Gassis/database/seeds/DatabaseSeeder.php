<?php

use Illuminate\Database\Seeder;

use App\Entities\User;
use App\Entities\Requester;
use App\Entities\Admin;
use App\Entities\TipoDeficiencia;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
       
       /*
        Requester::create([

            'name'              => 'Marcos', 
            'birth'             => '2010-05-23',
            'filename'          => 'asdfasdasdfasdf', 
            'email'             => 'marcos@gmail.com', 
            'password'          => env('PASSWORD_HASH') ? bcrypt('124356789') : '124356789'
        ]);
        

        */
        

        User::create([
            'name'                      => 'Vinícius',
            'filename'                  => 'asdfasdasdfasdf', 
            'email'                     => 'vrequester@gmail.com', 
            'password'                  => env('PASSWORD_HASH') ? bcrypt('987654321') : '987654321',
            //'tipo_solicitante_id'       => 1,   
            'permission'                => 2,
        ]);

        /* 

        TipoDeficiencia::create([
            'tipo'            => 'Deficiência Múltipla',
            'codigo'          => 5
        ]);

        */
        
    }
}
