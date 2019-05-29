<?php

use Illuminate\Database\Seeder;

use App\Entities\Requester;

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
        Requester::create([

            'name'              => 'Marcos', 
            'birth'             => '2010-05-23',
            'filename'          => 'asdfasdasdfasdf', 
            'email'             => 'marcos@gmail.com', 
            'password'          => env('PASSWORD_HASH') ? bcrypt('124356789') : '124356789'
        ]);
        
    }
}
