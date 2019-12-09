<?php

use Illuminate\Database\Seeder;

use App\Entities\User;
use App\Entities\TipoDeficiencia;
use App\Entities\TipoSolicitante;
use App\Entities\Fase;
use App\Entities\CurrentState;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        
        TipoSolicitante::create([
            'tipo'            => 'Exemplo',
        ]);
        
        User::create([
            'name'                      => 'Exemplo Solicitante',
            'filename'                  => 'asdfasdasdfasdf', 
            'email'                     => 'requesterexemple@gmail.com',
            'tipo_solicitante_id'       => 1,   
            'permission'                => 2,
        ]);

        
        User::create([
            'name'                      => 'Matheus',
            'filename'                  => 'asdfasdasdfasdf', 
            'email'                     => 'madmin@gmail.com', 
            'password'                  => env('PASSWORD_HASH') ? bcrypt('987654321') : '987654321', 
            'permission'                => 4,
        ]);


        TipoDeficiencia::create([
            'tipo'            => 'Deficiência Visual',
            'codigo'          => 1
        ]);

        TipoDeficiencia::create([
            'tipo'            => 'Deficiência Auditiva',
            'codigo'          => 2
        ]);

        TipoDeficiencia::create([
            'tipo'            => 'Deficiência Mental',
            'codigo'          => 3
        ]);

        TipoDeficiencia::create([
            'tipo'            => 'Deficiência Física',
            'codigo'          => 4
        ]);

        TipoDeficiencia::create([
            'tipo'            => 'Deficiência Múltipla',
            'codigo'          => 5
        ]);


        Fase::create([
            'fase'            => 'Recursos',
            'codigo'          => 1
        ]);

        Fase::create([
            'fase'            => 'Desenvolvimento',
            'codigo'          => 2
        ]);

        Fase::create([
            'fase'            => 'Teste',
            'codigo'          => 3
        ]);

        Fase::create([
            'fase'            => 'Adaptação',
            'codigo'          => 4
        ]);

        Fase::create([
            'fase'            => 'Finalizada',
            'codigo'          => 5
        ]);


        CurrentState::create([
            'state'            => 'Em espera',
            'codigo'            => 1
        ]);

        CurrentState::create([
            'state'            => 'Em produção',
            'codigo'            => 2
        ]);

        CurrentState::create([
            'state'            => 'Pausada',
            'codigo'            => 3
        ]);
        
        CurrentState::create([
            'state'            => 'Suspensa',
            'codigo'            => 4
        ]);
        
    }
}
