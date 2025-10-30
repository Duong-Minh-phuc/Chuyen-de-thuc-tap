<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('brands')->insert([
                'name' => 'Brand ' . $i,
                'slug' => Str::slug('Brand ' . $i),
                'image' => 'brand-' . $i . '.jpg',
                'description' => 'Description for Brand ' . $i,
                'sort_order' => 1,
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' =>1
            ]);
        }
    }
}

