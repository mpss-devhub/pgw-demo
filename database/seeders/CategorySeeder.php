<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $categories = [
            'Athletic Shoes',
            'Casual Shoes',
            'Sneakers',
            'Boots',
            'Sandals',
            'Heels',
            'Flats',
            'Loafers',
            'Oxfords',
            'Slippers',
            'Espadrilles',
            'Wedges',
            'Mules',
            'Flip Flops',
            'Running Shoes',
            'Basketball Shoes',
            'Tennis Shoes',
            'Soccer Cleats',
            'Hiking Shoes',
            'Cycling Shoes',
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name' => $category,
            ]);
        }

    }

}
