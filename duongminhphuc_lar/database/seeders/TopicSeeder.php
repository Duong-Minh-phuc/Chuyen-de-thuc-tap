<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('topic')->insert([
                'name' => 'Topic ' . $i,
                'slug' => Str::slug('Topic ' . $i),
                'sort_order' => 1,
                'description' => 'Description for Topic ' . $i,
                'status' => 1,
                'created_at' =>date('Y-m-d H:i:s'),
                'created_by' => 1,
                'deleted_at' => null,
            ]);
        }
    }
}
