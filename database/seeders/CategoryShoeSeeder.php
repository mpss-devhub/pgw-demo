<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class CategoryShoeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Define an array of shoe names and their corresponding categories
        $shoeCategories = [
            'Nike Air Max 90' => ['Athletic Shoes', 'Sneakers'],
            'Adidas Ultraboost' => ['Athletic Shoes', 'Running Shoes'],
            'Puma RS-X' => ['Athletic Shoes', 'Sneakers'],
            'Reebok Classic Leather' => ['Casual Shoes', 'Sneakers'],
            'New Balance 997' => ['Athletic Shoes', 'Sneakers'],
            'Vans Old Skool' => ['Casual Shoes', 'Sneakers'],
            'Converse Chuck Taylor All Star' => ['Casual Shoes', 'Sneakers'],
            'Under Armour HOVR Phantom' => ['Athletic Shoes', 'Running Shoes'],
        ];

        foreach ($shoeCategories as $shoeName => $categoryNames) {
            // Find the product by its name
            $product = Product::where('name', $shoeName)->first();

            if ($product) {
                foreach ($categoryNames as $categoryName) {
                    // Find the category by its name
                    $category = Category::where('name', $categoryName)->first();

                    if ($category) {
                        // Attach the product to the category
                        $product->categories()->attach($category->id);
                    }
                }
            }
        }
    }
}
