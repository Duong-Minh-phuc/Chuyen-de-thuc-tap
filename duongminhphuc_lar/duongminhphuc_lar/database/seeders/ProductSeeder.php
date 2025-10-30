<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('products')->insert([
                'category_id' => rand(1, 5),
                'brand_id' => rand(1, 5),
                'name' => 'Product ' . $i,
                'slug' => Str::slug('Product ' . $i),
                'content' => 'Content for Product ' . $i,
                'description' => 'Description for Product ' . $i,
                'price_buy' => rand(100, 10000),
                'price_sale' => rand(50, 900),
                'qty' => rand(10, 100),

                'thumbnail' => 'product-' . $i . '.jpg',
                
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'status' => 1,
               
                'deleted_at' => null,
            ]);
        }
    }
}
