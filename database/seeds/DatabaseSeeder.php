<?php

use App\User;
use Illuminate\Database\Seeder;

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
            'name' => 'lucas',
            'email' => 'lucashoffmann@gmail.com',
            'password' => '$2y$12$CJ6PghrLA6v6qE/K1du/R.rjC2y7GCBlYePHoC0TIXMmtEsZ2EoRu', // password
            'remember_token' => Str::random(10)

        ]);
    }
}
