<?php

namespace Database\Seeders;

use App\Models\admin\Carta;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'VLADY',
            'surname' => 'VELASQUEZ',
            'email' => 'yash_rahul@hotmail.com',
            'rol' => 'ADMINISTRADOR',
            'password' => Hash::make('123'),
            'active' => 1,
        ]);
        User::factory(20)->create();
        
        Carta::factory(50)->create();
       

        /* $users = factory(App\User::class, 50)->create(); */
    }
}
