<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'John Doe',
            'email' => 'demo@demo.com',
            'password' => bcrypt('secret'),
        ]);
    }
}
