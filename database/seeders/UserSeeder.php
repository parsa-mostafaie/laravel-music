<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->developer()->create([
            'email' => 'pmostafaie1390@gmail.com',
            'password' => Hash::make('pmostafaie1390@gmail.com'),
            'name' => "Parsa Mostafaie"
        ]);

        User::factory(100)->unverified()->create();

        User::factory(100)->create();
    }
}
