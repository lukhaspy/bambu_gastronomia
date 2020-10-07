<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{

    public function run()
    {


        Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'normal']);

        User::create([
            'name' => 'SitiosPy',
            'email' => 'sitiospy@sitiospy.com',
            'password' => bcrypt('sitiospy7750'), // password
            'remember_token' => Str::random(10)
        ])->assignRole('super-admin');

        User::create([
            'name' => 'Bambu',
            'email' => 'bambu@gmail.com',
            'password' => bcrypt('bambu-gastronomia'),
            'remember_token' => Str::random(10)
        ])->assignRole('super-admin');
    }
}
