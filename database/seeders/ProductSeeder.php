<?php

namespace Database\Seeders;

use App\Models\Product;
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

        // Define the shoe data
        $shoes = [
            [
                'name' => 'Nike Air Max 90',
                'price' => 149.99,
                'description' => 'Classic design with superior cushioning.',
                'image_url' => 'https://static.nike.com/a/images/c_limit,w_592,f_auto/t_product_v1/baa2520d-49da-4a27-ab2c-7fb133fb3008/air-max-90-mens-shoes-6n3vKB.png',
                'brand_id' => 1, // Brand ID for Nike
            ],
            [
                'name' => 'Sunshine Red',
                'price' => 69.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => asset('images/sunshine/red.jpg'),
                'brand_id' => 13, // Brand ID for Converse
            ],
            [
                'name' => 'The North Face Ridgewall Soft Shell Jacket',
                'price' => 300,
                'description' => 'Classic design with superior cushioning.',
                'image_url' =>  asset('images/softshell/heather_jacket.jpg'),
                'brand_id' => 1, // Brand ID for Nike
            ],

            [
                'name' => 'Sunshine Wood',
                'price' =>900.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => asset('images/sunshine/wood.jpg'),
                'brand_id' => 13, // Brand ID for Converse
            ],
            [
                'name' => 'Adidas Ultraboost',
                'price' => 179.99,
                'description' => 'High-performance running shoes with responsive cushioning.',
                'image_url' => 'https://assets.adidas.com/images/w_383,h_383,f_auto,q_auto,fl_lossy,c_fill,g_auto/369e2a875b794e7a8daaafa5011b9528_9366/ultraboost-light-running-shoes.jpg',
                'brand_id' => 2, // Brand ID for Adidas
            ],
            [
                'name' => 'Puma RS-X',
                'price' => 129.99,
                'description' => 'Retro-inspired sneakers with modern cushioning technology.',
                'image_url' => "https://images.puma.com/image/upload/f_auto,q_auto,b_rgb:fafafa,w_350,h_350/global/393393/01/sv01/fnd/PNA/fmt/png/PUMA-NYC-RS-X-Park-Flagship-Men's-Sneakers",
                'brand_id' => 3, // Brand ID for Puma
            ],
            [
                'name' => 'Softshell Micro Fleece',
                'price' => 69.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => asset('images/softshell/micro_fleece_jacket.jpg'),
                'brand_id' => 12, // Brand ID for Converse
            ],
            [
                'name' => 'Reebok Classic Leather',
                'price' => 89.99,
                'description' => 'Timeless and versatile sneakers with a leather upper.',
                'image_url' => 'https://reebok.bynder.com/transform/aab6d22a-de13-47ab-944c-f17c1821626c/100008494_TPP_eCom-tif?io=transform:fit,width:250&quality=100',
                'brand_id' => 4, // Brand ID for Reebok
            ],
            [
                'name' => 'New Balance 997',
                'price' => 159.99,
                'description' => 'Stylish sneakers with excellent comfort and support.',
                'image_url' => 'https://nb.scene7.com/is/image/NB/pr997hwk_nb_02_i?$pdpflexf2$&qlt=80&fmt=webp&wid=440&hei=440',
                'brand_id' => 5, // Brand ID for New Balance
            ],
            [
                'name' => 'Softshell Sky Line Jacket',
                'price' => 80.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => '/images/softshell/sky_line_jacket.jpg',
                'brand_id' => 12, // Brand ID for Converse
            ],
            [
                'name' => 'Vans Old Skool',
                'price' => 59.99,
                'description' => 'Iconic skate shoes with a durable canvas upper.',
                'image_url' => 'https://images.vans.com/is/image/Vans/VN000D3H_BKA_HERO?$PLP-IMAGE$',
                'brand_id' => 6, // Brand ID for Vans
            ],
            [
                'name' => 'Converse Chuck Taylor All Star',
                'price' => 69.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => 'https://www.converse.com/dw/image/v2/BCZC_PRD/on/demandware.static/-/Sites-cnv-master-catalog/default/dwc70b9350/images/e_08/A03423C_E_08X1.jpg?sw=406',
                'brand_id' => 7, // Brand ID for Converse
            ],

            [
                'name' => 'Cover Me Blue Umbrella',
                'price' => 100,
                'description' => 'Iconic skate shoes with a durable canvas upper.',
                'image_url' => '/images/coverme/blue.jpg',
                'brand_id' => 11, // Brand ID for Vans
            ],
            [
                'name' => 'Cover Me Blue Strips Umbrella',
                'price' => 500,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => '/images/coverme/blue_strips.jpg',
                'brand_id' => 11, // Brand ID for Converse
            ],
            [
                'name' => 'Cover Me Light Green Umbrella',
                'price' => 69.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => '/images/coverme/light_green.jpg',
                'brand_id' => 11, // Brand ID for Converse
            ],
            [
                'name' => 'Softshell Heather Jacket',
                'price' => 300.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => '/images/softshell/heather_jacket.jpg',
                'brand_id' => 12, // Brand ID for Converse
            ],
            [
                'name' => 'Cover Me Red Umbrella',
                'price' => 69.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => '/images/coverme/red.jpg',
                'brand_id' => 11, // Brand ID for Converse
            ],
            [
                'name' => 'Cover Me Yellow Umbrella',
                'price' => 69.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => asset('images/coverme/yellow.jpg'),
                'brand_id' => 11, // Brand ID for Converse
            ],

            //softshell

            [
                'name' => 'Softshell Lined Soft',
                'price' => 80.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => '/images/softshell/lined_soft_shell_jacket.jpg',
                'brand_id' => 12, // Brand ID for Converse
            ],

            [
                'name' => 'Softshell Vest Jacket',
                'price' => 69.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => asset('images/softshell/vest_jacket.jpg'),
                'brand_id' => 12, // Brand ID for Converse
            ],
            //sunshine
            [
                'name' => 'Sunshine Cool Green',
                'price' => 300.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => '/images/sunshine/cool_green.jpg',
                'brand_id' => 13, // Brand ID for Converse
            ],
            [
                'name' => 'Sunshine Moon',
                'price' => 80.99,
                'description' => 'Timeless high-top sneakers with a rubber toe cap.',
                'image_url' => '/images/sunshine/moon_shine.jpg',
                'brand_id' => 13, // Brand ID for Converse
            ],


        ];

        foreach ($shoes as $shoeData) {
            Product::create($shoeData);
        }
    }
}
