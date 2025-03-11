<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Item;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create categories
        $categories = [
            'Electronics',
            'Office Supplies',
            'Furniture',
            'Books',
            'Tools'
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        // Create sample items
        $items = [
            [
                'product_name' => 'Laptop',
                'quantity' => 15,
                'price' => 999.99,
                'category_id' => 1
            ],
            [
                'product_name' => 'Printer Paper',
                'quantity' => 500,
                'price' => 5.99,
                'category_id' => 2
            ],
            [
                'product_name' => 'Office Chair',
                'quantity' => 8,
                'price' => 199.99,
                'category_id' => 3
            ],
            [
                'product_name' => 'Programming Book',
                'quantity' => 25,
                'price' => 49.99,
                'category_id' => 4
            ],
            [
                'product_name' => 'Screwdriver Set',
                'quantity' => 30,
                'price' => 29.99,
                'category_id' => 5
            ]
        ];

        foreach ($items as $itemData) {
            Item::create($itemData);
        }
    }
}
