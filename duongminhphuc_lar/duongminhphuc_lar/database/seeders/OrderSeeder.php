<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('order')->insert([
                'user_id' => rand(1, 5),
                'name' => 'Customer ' . $i,
                'email' => 'customer' . $i . '@example.com',
                'phone' => '12345678' . $i,
                'address' => 'Address ' . $i,
                'status' => 1,
                'created_at' =>date('Y-m-d H:i:s'),
                'created_by' => 1,
                'deleted_at' => null,
            ]);
        }
    }
    
}
