<?php

use App\Branch;
use App\PaymentMethod;
use App\ProductCategory;
use App\Provider;
use App\Sale;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder{

    public function run(){

        /*    Role::create(['name' => 'super-admin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'normal']);

        User::create([
            'name' => 'SitiosPy',
            'email' => 'sitiospy@sitiospy.com',
            'password' => bcrypt('sitiospy7750'), // password
            'remember_token' => Str::random(10)
        ])->assignRole('super-admin')->branches()->attach([1]);

        Branch::create([
            'name' => 'Casa Central'
        ]);

        User::create([
            'name' => 'Bambu',
            'email' => 'bambu@gmail.com',
            'password' => bcrypt('bambu-gastronomia'),
            'remember_token' => Str::random(10)
        ])->assignRole('super-admin')->branches()->attach([1]);


        PaymentMethod::create([
            'name' => 'Efectivo'
        ]);*/

        for ($i = 0; $i < 55; $i++) {
            Sale::create([
                'user_id' => 1,
                'client_id' => 1,
                'date' => date('Y-m-d', strtotime('+ ' . $i . ' days'))
            ]);
        }
    }
}
