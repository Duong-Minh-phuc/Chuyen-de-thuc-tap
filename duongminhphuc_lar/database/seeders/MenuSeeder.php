<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
{
    for ($i = 1; $i <= 10; $i++) {
        DB::table('menu')->insert([
            'name' => 'Menu ' . $i,
            'link' => '/menu-' . $i,
            'type' => 'internal',
            'position' => $i % 2 === 0 ? 'footermenu' : 'mainmenu',
            'sort_order' =>1,
            'parent_id' => 0,

            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => 1,
            'deleted_at' => null,
        ]);
    }
}

}
