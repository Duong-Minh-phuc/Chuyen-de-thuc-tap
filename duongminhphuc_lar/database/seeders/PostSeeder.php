<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('post')->insert([
                'topic_id' => rand(1, 10),
                'title' => 'Post ' . $i,
                'slug' => Str::slug('Post ' . $i),
                'content' => 'Content for Post ' . $i,
                'description' => 'Description for Post ' . $i,
                'thumbnail' => 'post-' . $i . '.jpg',
                'type' => 'post',
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'deleted_at' => null,
            ]);
        }
    }
    
}
