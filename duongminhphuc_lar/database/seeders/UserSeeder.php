<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'username' => 'user' . $i,
                'password' => bcrypt('password' . $i),
                'fullname' => 'User ' . $i,
                'gender' => $i % 2 === 0 ? 'Male' : 'Female',
                'thumbnail' => 'user-' . $i . '.jpg',
                'email' => 'user' . $i . '@example.com',
                'phone' => '123456789' . $i,
                'address' => 'Address ' . $i,
                'roles' => $i % 2 === 0 ? 'admin' : 'customer',
               
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'deleted_at' => null,
            ]);
        }
    }
}
