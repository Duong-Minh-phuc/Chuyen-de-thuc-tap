<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderdetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('orderdetail')->insert([
                'order_id' => rand(1, 10),
                'product_id' => rand(1, 10),
                'qty' => rand(1, 5),
                'price' => rand(100, 1000),
                'discount' => rand(0, 100),
                'amount' => rand(100, 1000),
            ]);
        }
    }
}
