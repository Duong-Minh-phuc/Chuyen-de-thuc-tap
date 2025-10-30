<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('contact')->insert([
            [
                'name' => 'John Doe',
                'email' => 'john.doe@example.com',
                'phone' => '123456789',
                'title' => 'Inquiry about product',
                'content' => 'Can you provide more details about product X?',
                'reply_id' => 0,
                'user_id' => 1,
               
              
                'status' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 1,
                'deleted_at' => null,
            ],
        ]);
    }
}
