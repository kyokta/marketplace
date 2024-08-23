<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Iphone 16',
                'store' => 1, 
                'category_id' => 1, 
                'price' => 20000000, 
                'stock' => 50,
                'image' => null,
                'description' => 'Apple Product',
            ],
            [
                'name' => 'Denim Jacket',
                'store' => 1,
                'category_id' => 2,
                'price' => 100000,
                'stock' => 20,
                'image' => null, 
                'description' => 'Blue Jacket',
            ],
            [
                'name' => 'Pot',
                'store' => 1,
                'category_id' => 3,
                'price' => 20000,
                'stock' => 15,
                'image' => null,
                'description' => 'Black Pot',
            ],
            [
                'name' => 'Sunscreen',
                'store' => 1,
                'category_id' => 4,
                'price' => 50000,
                'stock' => 100,
                'image' => null,
                'description' => 'Azarine SPF 50+++',
            ],
            [
                'name' => 'Ball',
                'store' => 1,
                'category_id' => 5, 
                'price' => 5000,
                'stock' => 30,
                'image' => null, 
                'description' => 'Stripped Ball',
            ],
            [
                'name' => 'Car',
                'store' => 1,
                'category_id' => 6,
                'price' => 25000,
                'stock' => 25,
                'image' => null,
                'description' => 'Purple Car',
            ],
            [
                'name' => 'Motorcycle',
                'store' => 1,
                'category_id' => 7, 
                'price' => 18000000,
                'stock' => 10,
                'image' => null,
                'description' => 'Honda 70',
            ],
        ];

        DB::table('products')->insert($products);
    }
}