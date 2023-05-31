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
                'name' => 'Under Armour HOVR Phantom',
                'price' => 139.99,
                'description' => 'Running shoes with cushioning and energy return.',
                'image_url' => 'https://underarmour.scene7.com/is/image/Underarmour/3025516-101_A?rp=standard-30pad|pdpMainDesktop&scl=1&fmt=jpg&qlt=85&resMode=sharp2&cache=on,on&bgc=f0f0f0&wid=566&hei=708&size=536,688',
                'brand_id' => 8, // Brand ID for Under Armour
            ]
        ];

        foreach ($shoes as $shoeData) {
            Product::create($shoeData);
        }
    }
}
