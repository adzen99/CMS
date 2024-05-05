<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::create([
            'username' => 'alex.dzen',
            'password' => Hash::make('123dzen123'),
            'email' => 'dzenalex9@gmail.com',
            'first_name' => 'Alex',
            'last_name' => 'Dzen',
            'phone' => '0751321045',
        ]);
    }
}
