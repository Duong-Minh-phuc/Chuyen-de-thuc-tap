<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\SoftDeletes;
class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
     public function run(): void
     { 
        for ($i = 1; $i <= 10; $i++) {
            DB::table('banner')->insert([
            'name' => 'Slider show',
            'link' => 'slider-show-' . $i,
            'image' => "slider-" .$i. ".png",
            'position' => 'slideshow',
            'description' => 'Mo ta',
            'sort_order' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'created_by' => 1,
            'status' => 1
            
           
            ]);
        }
        
     }   
     
     

}
