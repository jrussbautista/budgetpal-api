<?php

namespace Database\Seeders;


use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // Admin 
        User::create([
            'name' => 'Admin Admin',
            'password' => Hash::make('password'),
            'email' => 'admin@gmail.com',
            'is_admin' => true,
        ]);

        // User 
        User::create([
            'name' => 'John Doe',
            'password' => Hash::make('password'),
            'email' => 'test@gmail.com',
            'is_admin' => false,
        ]);
    }
}
