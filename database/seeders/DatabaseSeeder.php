<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        User::create([
            'role' => 'president',
            'name' => 'Nara',
            'email' => 'admin01@gmail.com',
            'phone' => '09778997079',
            'gender' => 'male',
            'address' => 'London',
            'password' =>  Hash::make('admin123'),
        ]);

        User::create([
            'role' => 'user',
            'name' => 'Jessica Max',
            'email' => 'user01@gmail.com',
            'phone' => '09123123123',
            'gender' => 'female',
            'address' => 'Newzeland',
            'password' =>  Hash::make('user123123'),
        ]);
    }
}
