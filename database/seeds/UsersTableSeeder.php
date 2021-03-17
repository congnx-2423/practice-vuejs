<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory(User::class, 10)->create();
    }
}
