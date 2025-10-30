<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('categories')->insert([
                'name' => 'Category ' . $i,
                'slug' => Str::slug('Category ' . $i),
                'parent_id' =>0,
                'sort_order' =>1,
                'image' => 'category-' . $i . '.jpg',
                'description' => 'Description for Category ' . $i,
            
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1
            ]);
        }
    }
}
