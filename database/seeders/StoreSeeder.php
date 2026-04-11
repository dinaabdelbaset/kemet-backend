<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class StoreSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('order_items')->truncate();
        DB::table('products')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = [
            // --- ART ---
            [
                'name' => 'Authentic Egyptian Papyrus',
                'description' => 'Original hand-painted papyrus canvas illustrating the Tree of Life.',
                'price' => 45.00,
                'category' => 'Art',
                'image' => '/shop-products/papyrus.png',
                'stock' => 100
            ],
            [
                'name' => 'Pharaonic Canvas Art',
                'description' => 'Beautiful stretched canvas depicting ancient Egyptian gods and mythology.',
                'price' => 60.00,
                'category' => 'Art',
                'image' => '/shop-products/papyrus.png',
                'stock' => 50
            ],
            [
                'name' => 'Nubian Wall Tapestry',
                'description' => 'Handwoven vivid tapestry from Aswan with local motifs.',
                'price' => 55.00,
                'category' => 'Art',
                'image' => '/shop-products/basket.png',
                'stock' => 30
            ],
            [
                'name' => 'Handmade Nubian Basket Craft',
                'description' => 'Vibrantly colored, hand-woven Nubian basket directly from traditional artisans.',
                'price' => 25.00,
                'category' => 'Art',
                'image' => '/shop-products/basket.png',
                'stock' => 100
            ],

            // --- FOOD ---
            [
                'name' => 'Premium Aswan Spices Box',
                'description' => 'A curated selection of premium Egyptian spices including cumin, coriander, and saffron.',
                'price' => 35.00,
                'category' => 'Food',
                'image' => '/shop-products/spice_box.png',
                'stock' => 150
            ],
            [
                'name' => 'Organic Hibiscus Tea',
                'description' => 'Premium dried hibiscus flowers from Aswan for making authentic Karkadeh.',
                'price' => 15.00,
                'category' => 'Food',
                'image' => '/shop-products/spice_box.png',
                'stock' => 200
            ],
            [
                'name' => 'Siwa Oasis Dates',
                'description' => 'Luxurious, sweet organic dates harvested directly from the Siwa Oasis.',
                'price' => 20.00,
                'category' => 'Food',
                'image' => '/shop-products/spice_box.png',
                'stock' => 120
            ],
            [
                'name' => 'Khan El Khalili Coffee Blend',
                'description' => 'Traditional rich Turkish-style coffee blend with cardamom.',
                'price' => 18.00,
                'category' => 'Food',
                'image' => '/shop-products/spice_box.png',
                'stock' => 80
            ],

            // --- STATUES ---
            [
                'name' => 'Alabaster Nefertiti Bust',
                'description' => 'Hand-carved authentic alabaster statue of Queen Nefertiti from Luxor.',
                'price' => 85.00,
                'category' => 'Statues',
                'image' => '/shop-products/nefertiti.png',
                'stock' => 45
            ],
            [
                'name' => 'Pharaonic God Anubis',
                'description' => 'Exquisite replica statue of Anubis, the ancient Egyptian god.',
                'price' => 95.00,
                'category' => 'Statues',
                'image' => '/shop-products/anubis.png',
                'stock' => 30
            ],
            [
                'name' => 'Mask of Tutankhamun Replica',
                'description' => 'A stunning museum-quality replica of the golden mask of King Tut.',
                'price' => 250.00,
                'category' => 'Statues',
                'image' => '/shop-products/tutankhamun.png',
                'stock' => 10
            ],
            [
                'name' => 'Granite Bastet Cat Statue',
                'description' => 'A powerful small statue of the Cat Goddess Bastet, carved from dark heavy stone.',
                'price' => 65.00,
                'category' => 'Statues',
                'image' => '/shop-products/anubis.png',
                'stock' => 60
            ],

            // --- CLOTHING ---
            [
                'name' => 'Pure Egyptian Cotton Scarf',
                'description' => '100% genuine woven Egyptian cotton scarf. Soft, breathable.',
                'price' => 35.00,
                'category' => 'Clothing',
                'image' => '/shop-products/scarf.png',
                'stock' => 100
            ],
            [
                'name' => 'Traditional Silk Galabeya',
                'description' => 'Elegant, flowing traditional Egyptian dress with beautiful modern patterns.',
                'price' => 80.00,
                'category' => 'Clothing',
                'image' => '/shop-products/scarf.png',
                'stock' => 40
            ],
            [
                'name' => 'Custom Silver Cartouche',
                'description' => 'Personalized sterling silver cartouche with your name.',
                'price' => 120.00,
                'category' => 'Clothing', // Added to clothing as an accessory
                'image' => '/shop-products/cartouche.png',
                'stock' => 200
            ],
            [
                'name' => 'Pharaonic Golden Necklace',
                'description' => 'Exquisite jewelry piece inspired by ancient Egyptian royalties.',
                'price' => 150.00,
                'category' => 'Clothing',
                'image' => '/shop-products/cartouche.png',
                'stock' => 50
            ],

            // --- DECOR ---
            [
                'name' => 'Stained Glass Brass Lantern',
                'description' => 'Handcrafted traditional Arabian lantern from historic Islamic Cairo.',
                'price' => 110.00,
                'category' => 'Decor',
                'image' => '/shop-products/papyrus.png',
                'stock' => 25
            ],
            [
                'name' => 'Mother of Pearl Jewelry Box',
                'description' => 'Ornate Islamic geometric patterns inlaid with mother of pearl.',
                'price' => 90.00,
                'category' => 'Decor',
                'image' => '/shop-products/spice_box.png',
                'stock' => 40
            ],
            [
                'name' => 'Hand-Painted Glass Perfume Bottle',
                'description' => 'Delicate, intricately painted glass bottle blown by local artists.',
                'price' => 25.00,
                'category' => 'Decor',
                'image' => '/shop-products/cartouche.png',
                'stock' => 150
            ],
            [
                'name' => 'Woven Bedouin Rug',
                'description' => 'A beautifully hand-woven rug with deep rich colors from Sinai.',
                'price' => 200.00,
                'category' => 'Decor',
                'image' => '/shop-products/basket.png',
                'stock' => 15
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
