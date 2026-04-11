<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Hotel;
use App\Models\Room;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locations = [
            'Cairo' => [
                'The Nile Ritz-Carlton', 'Cairo Marriott Hotel & Omar Khayyam', 'Four Seasons Hotel Cairo at Nile Plaza', 'Kempinski Nile Hotel', 'Om Kolthoom Hotel', 'Fairmont Nile City'
            ],
            'Luxor' => [
                'Sofitel Winter Palace Luxor', 'Hilton Luxor Resort & Spa', 'Jolie Ville Hotel & Spa', 'Steigenberger Nile Palace', 'Pavillon Winter Luxor', 'Sonesta St. George Hotel'
            ],
            'Aswan' => [
                'Sofitel Legend Old Cataract', 'Mövenpick Resort Aswan', 'Tolip Aswan Hotel', 'Citymax Hotel Aswan', 'Basma Hotel Aswan', 'Pyramisa Island Hotel Aswan'
            ],
            'Sharm El-Sheikh' => [
                'Rixos Premium Seagate', 'Four Seasons Resort Sharm El Sheikh', 'Sunrise Arabian Beach Resort', 'Steigenberger Alcazar', 'Mövenpick Resort Sharm', 'Stella Di Mare Beach Hotel'
            ],
            'Hurghada' => [
                'Steigenberger ALDAU Beach Hotel', 'Sunrise Royal Makadi Resort', 'Jaz Makadi Star & Spa', 'Baron Palace Sahl Hasheesh', 'Titanic Palace', 'Desert Rose Resort'
            ],
            'Alexandria' => [
                'Four Seasons San Stefano', 'Steigenberger Cecil Hotel', 'Helnan Palestine Hotel', 'Tolip Hotel Alexandria', 'Hilton Alexandria Corniche', 'Paradise Inn Le Metropole'
            ],
            'Giza' => [
                'Marriott Mena House', 'Le Méridien Pyramids Hotel', 'Steigenberger Pyramids Cairo', 'Triumph Luxury Hotel', 'Oasis Hotel Pyramids', 'Grand Pyramids Hotel'
            ],
            'Marsa Matrouh' => [
                'Jaz Almaza Beach Resort', 'Carols Beau Rivage Hotel', 'Beau Site Belle Vue', 'Porto Matrouh Beach Resort', 'Adriatica Hotel', 'Negresco Hotel'
            ],
            'Port Said' => [
                'Resta Port Said Hotel', 'Port Said Hotel', 'Jewel Port Said Hotel', 'Grand Hotel Port Said', 'Palace Hotel Port Said', 'Noras Village'
            ],
            'Fayoum' => [
                'Lazib Inn Resort & Spa', 'Byoum Lakeside Hotel', 'Helnan Auberge Fayoum', 'Tunis Village Resort', 'Tzila Lodge', 'Zad Al Mosafer Guest House'
            ],
            'Marsa Alam' => [
                'Jaz Lamaya Resort', 'Steigenberger Coraya Beach', 'Hilton Marsa Alam Nubian Resort', 'The Three Corners Fayrouz Plaza', 'Aurora Bay Resort', 'Gorgonia Beach Resort'
            ],
            'Dahab' => [
                'Le Meridien Dahab Resort', 'Swiss Inn Resort Dahab', 'Tropitel Dahab Oasis', 'Jaz Dahabeya', 'Tirana Dahab Resort', 'Acacia Dahab Hotel'
            ]
        ];

        $images = [
            '/images/hotels/siwa.png',
            '/images/hotels/pyramids.png',
            '/images/hotels/redsea.png',
            '/images/hotels/luxor.png',
            '/images/hotels/aswan.png',
            '/images/hotels/sharm_bungalows.png',
            '/images/hotels/cairo_boutique.png',
            '/images/hotels/cairo_heritage.png',
            '/images/hotels/alex.png',
            '/images/hotels/aswan_cruise.png',
            '/images/hotels/desert.png',
            '/images/hotels/luxor_sunset.png',
            '/images/hotels/marsa_lodge.png',
            '/images/hotels/matrouh.png',
            '/images/hotels/nile.png',
            '/images/hotels/north_coast.png'
        ];

        // Placeholder 3D model for AR view
        $arUrl = 'https://modelviewer.dev/shared-assets/models/Astronaut.glb'; 

        $hotelDescriptions = [
            "Experience luxury at its finest with breathtaking views, world-class amenities, and exquisite dining options.",
            "A serene getaway offering the perfect blend of modern comfort and traditional charm. Relax in our beautiful gardens or pamper yourself at the spa.",
            "Located in the heart of the city, perfect for both business and leisure. Enjoy exceptional service and meticulously designed rooms.",
            "Discover unmatched elegance and sophistication. Our resort features pristine private beaches, infinity pools, and gourmet restaurants.",
            "Immerse yourself in a cultural oasis. Our hotel combines local heritage with luxury facilities to provide an unforgettable stay.",
            "The ideal family destination with plenty of activities, kids clubs, and spacious suites offering panoramic views."
        ];

        $roomFeaturesPool = ["Free WiFi", "AC", "TV", "Mini Bar", "Sea View", "City View", "Bathtub", "Balcony", "Room Service", "Coffee Machine"];

        $hotelImageMap = [
            'Cairo Marriott Hotel & Omar Khayyam' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/797079050.jpg?k=41e5fa87be51b19dfe5a07048154204153fd382745471d510c419bb4cc3bb3ef&o=',
            'Four Seasons Hotel Cairo at Nile Plaza' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/94190040.jpg?k=ef1c7c9927dbc4c9bb8ade64114c12302c1490a01530fec267460efffb8fdf47&o=',
            'Kempinski Nile Hotel' => 'https://storage.kempinski.com/cdn-cgi/image/w=1920,f=auto,fit=scale-down/ki-cms-prod/images/1/7/1/5/65171-1-eng-GB/abb1d7474666-73654605_4K.jpg',
            'Om Kolthoom Hotel' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/587837448.jpg?k=943e9a56bbf7bc001d90e96eff5f51fb7a5cffce5255a3b5a941bb2ebacf65c8&o=',
            'Fairmont Nile City' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/765210500.jpg?k=edcf60bab46b3afb37f173db0d739d1eecac8e9069c0f82fcd0858697637c5f7&o=',
            'Sofitel Winter Palace Luxor' => 'https://phgcdn.com/images/uploads/LXRSW/overviewimages/1600x813-Winter-Palace-Exterior-and-Nile-River-at-Night.jpg',
            'Hilton Luxor Resort & Spa' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/19/cc/82/fe/hotel-main-swimming-pool.jpg?w=900&h=500&s=1',
            'Jolie Ville Hotel & Spa' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQpXq1U3HnO70tbf4t4imo3gLxqI8AAjx1zhw&s',
            'Steigenberger Nile Palace' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/520473784.jpg?k=183c0863529ab6a6fcc707a1b473722c404da45c1e7ce02f0af421cc3707c882&o=',
            'Sonesta St. George Hotel' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQvBBihkp2TaEPtuyZK5gOMq4GBr7KejWLsaQ&s',
            'Sofitel Legend Old Cataract' => 'https://www.ahstatic.com/photos/1666_ho_00_p_1024x768.jpg',
            'Mövenpick Resort Aswan' => 'https://m.ahstatic.com/is/image/accorhotels/Aswan_xxxxxxxxxxxx_i130214:8by10?wid=412&hei=515&dpr=on,2.625&qlt=75&resMode=sharp2&op_usm=0.5,0.3,2,0&iccEmbed=true&icc=sRGB',
            'Citymax Hotel Aswan' => 'https://www.hoteliermiddleeast.com/2021/05/zpjydscU-Citymax-Aswan.jpg',
            'Basma Hotel Aswan' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSrEbvwqi6GTKCgMBJik86X4fNMM-pWUC_HWg&s',
            'Pyramisa Island Hotel Aswan' => 'https://static21.com-hotel.com/uploads/hotel/61097/photo/pyramisa-island-hotel-aswan_15828427011.jpg',
            'Rixos Premium Seagate' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/25/03/8e/75/rixos-premium-seagate.jpg?w=900&h=500&s=1',
            'Four Seasons Resort Sharm El Sheikh' => 'https://static.prod.r53.tablethotels.com/media/hotels/slideshow_images_staged/large/1414922.jpg',
            'Sunrise Arabian Beach Resort' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSMCGJ8j91vHMl4PQVz31TGWucd0PNfmPrOuw&s',
            'Steigenberger Alcazar' => 'https://assets.hrewards.com/assets/572_SHR_Alcazar_exterior_Overview_Night_f9bee851ef.jpg',
            'Mövenpick Resort Sharm' => 'https://q-xx.bstatic.com/xdata/images/hotel/max500/244332007.jpg?k=8a3ea8cb1076f50b645f8f167f8dcde2059252b53995fa753983acc25f29ff05&o=',
            'Stella Di Mare Beach Hotel' => 'https://q-xx.bstatic.com/xdata/images/hotel/max500/81552816.jpg?k=741a94a22ea8781430ae987436b19082c452bcf641a0a12e52d9842d85fead5b&o=',
            'Steigenberger ALDAU Beach Hotel' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/611083499.jpg?k=7c459a47c8f9a0fd10240c51d07aa65aac9256a6217e373af17b720d77f42a09&o=',
            'Sunrise Royal Makadi Resort' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRIjcrmlVZ5MYF_ZXbEwm6yuVOn5mugzD3fcQ&s',
            'Jaz Makadi Star & Spa' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/11/94/d6/ad/jaz-makadi-star-spa.jpg?w=500&h=-1&s=1',
            'Baron Palace Sahl Hasheesh' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSawu1UIOT1tu-59DifAdNRpwp5TlXZWHx5Ug&s',
            'Titanic Palace' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/32/6b/01/03/birds-eye-overview-of.jpg?w=500&h=-1&s=1',
            'Desert Rose Resort' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTOzeJOIJIcegapUUg0J5CWhPUjK_vq3f0KQQ&s',
            'Four Seasons San Stefano' => 'https://www.siac.com.eg/sites/default/files/san-stefano-front-view-siac.jpg',
            'Steigenberger Cecil Hotel' => 'https://static.wixstatic.com/media/0dbdf2_be300604eaf64c9b8b75532d2873fab1~mv2_d_3916_3307_s_4_2.jpg/v1/fill/w_1956,h_838,al_c,q_85,usm_0.66_1.00_0.01,enc_avif,quality_auto/0dbdf2_be300604eaf64c9b8b75532d2873fab1~mv2_d_3916_3307_s_4_2.jpg',
            'Helnan Palestine Hotel' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/363689492.jpg?k=2d7bed4ab44f43f924cb6187830b34adbf3fb41a1987fd0f5061e6b2a358fe4f&o=',
            'Tolip Hotel Alexandria' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/288644202.jpg?k=5ba38f47744415ee4d072303af89bf69b987e9f15ab3e69dc8c442d085a675d9&o=',
            'Hilton Alexandria Corniche' => 'https://www.hilton.com/im/en/ALYACHI/3160549/pool-generic-horizontal.jpg?impolicy=crop&cw=5694&ch=3188&gravity=NorthWest&xposition=0&yposition=303&rw=768&rh=430',
            'Paradise Inn Le Metropole' => 'https://cf.bstatic.com/xdata/images/hotel/max500/423611952.jpg?k=956daa67d1bbc4331ae665c65ea4954f21a664dab2672dd152151c1eadb0c0b0&o=&hp=1',
            'Marriott Mena House' => 'https://images.trvl-media.com/lodging/18000000/17170000/17162700/17162680/2ac8dde9.jpg?impolicy=fcrop&w=1200&h=800&quality=medium',
            'Le Méridien Pyramids Hotel' => 'https://www.marsaalamtours.com/images/Egypt_attraction_guide/le-meridien-pyramids-hotel/le-meridien-pyramids-hotel_29777.jpg',
            'Steigenberger Pyramids Cairo' => 'https://www.egypttoursportal.com/images/2024/05/Steigenberger-Pyramids-Cairo-Egypt-Tours-Portal.jpg',
            'Triumph Luxury Hotel' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1a/2b/4b/b0/triumph-luxury-hotel.jpg?w=900&h=500&s=1',
            'Oasis Hotel Pyramids' => 'https://images.trvl-media.com/lodging/74000000/73570000/73569100/73569070/d043103b_edited_8b58.jpg?impolicy=resizecrop&rw=575&rh=575&ra=fill',
            'Grand Pyramids Hotel' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/267723989.jpg?k=57f4edbe9ec212b877edd3010001f9f2a0698c27f4a31afbf1ef024152b0bb6e&o=',
            'Jaz Almaza Beach Resort' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/2a/e5/7f/fd/caption.jpg?w=500&h=-1&s=1',
            'Carols Beau Rivage Hotel' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/19/12/81/c4/overlooking-the-hotel.jpg?w=900&h=500&s=1',
            'Beau Site Belle Vue' => 'https://static21.com-hotel.com/uploads/hotel/61260/photo/beau-site-belle-vue-hotel_15380002378.jpg',
            'Porto Matrouh Beach Resort' => 'https://cf.bstatic.com/xdata/images/hotel/max500/303253632.jpg?k=e372582b539789e88fb01d1b5f68dc0af5cfc0a82396b0bbb8af5ed646928282&o=&hp=1',
            'Adriatica Hotel' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/550831891.jpg?k=d3a616e964928354eddf3b3836fe9579cf2d5a777c13f90bde000c07fb86f298&o=',
            'Negresco Hotel' => 'https://imagesawe.s3.amazonaws.com/styles/max980/s3/companies/images/2021/02/negresco_hotel.png?itok=xI2Ad3Kj',
            'Resta Port Said Hotel' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/419857883.jpg?k=7a59dd191d279d23d9d41c3d55ec1aab17a5e49e94ea3a6644566209fc14b369&o=',
            'Port Said Hotel' => 'https://portsaidmisrtravel.com/img/about/hotel.jpg',
            'Jewel Port Said Hotel' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/267863563.jpg?k=49cf6059bf5010be653f9bf1423d7fc9c7792b0656d5f04d59fc2cffac106ef5&o=',
            'Grand Hotel Port Said' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/453782406.jpg?k=3865ec3ef0e6a0d789d2feab3477bc12e4f474f22204d473c08be1d17ddfc693&o=',
            'Palace Hotel Port Said' => 'https://q-xx.bstatic.com/xdata/images/hotel/max500/507142438.jpg?k=884b50b6d8a9812362f95c92d1cba6f61223b6b7378755bafb7aa73642142feb&o=',
            'Noras Village' => 'https://www.eg-northcoast.com/data/Photos/OriginalPhoto/10756/1075689/1075689649/photo-noras-beach-hotel-port-said-1.JPEG',
            'Lazib Inn Resort & Spa' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/16/ee/97/d6/general-area-of-the-pool.jpg?w=900&h=500&s=1',
            'Byoum Lakeside Hotel' => 'https://blogs.realestate.gov.eg/wp-content/uploads/2024/08/hotel-panoramic-view.jpg',
            'Helnan Auberge Fayoum' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/219692026.jpg?k=5321f658340a433cc9bad08955b66501baf1dbb4b088a2897c6c3f8f4e1fbcf8&o=',
            'Tunis Village Resort' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTQnyej2smTL2Y5G8TVISGMJB8i9n_KTLxQg&s',
            'Tzila Lodge' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTjY0_Pkhc1nwbQuTaiRML5vKXrYRqRiPjQbg&s',
            'Zad Al Mosafer Guest House' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/409193308.jpg?k=1310c0befefdad26c908e1cc8b3e31ce3ec64aa4693e3ca5dade3bb428d6264d&o=',
            
            // Marsa Alam
            'Jaz Lamaya Resort' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1b/33/f1/44/jaz-lamaya-resort.jpg?w=900&h=-1&s=1',
            'Steigenberger Coraya Beach' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/38289886.jpg?k=3cc9b1fa3f381fcc8f8ab64d6db38ad269661cd81881dc1c25eed49683fb080f&o=',
            'Hilton Marsa Alam Nubian Resort' => 'https://www.hilton.com/im/en/RMFHIHI/14681699/exterior-1522.jpg?impolicy=crop&cw=5760&ch=3230&gravity=NorthWest&xposition=0&yposition=304&rw=768&rh=430',
            'The Three Corners Fayrouz Plaza' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0e/e3/fc/d8/swimming-pool.jpg?w=900&h=-1&s=1',
            'Aurora Bay Resort' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/27563583.jpg?k=a39fa2ec1e7371d3d633c706ee9a4f4ed7db0dbceb51dbab5e9d91bd2c9b4e3e&o=',
            'Gorgonia Beach Resort' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/18/89/3b/b1/gorgonia-beach-resort.jpg?w=900&h=-1&s=1',

            // Dahab
            'Le Meridien Dahab Resort' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1b/37/8a/16/le-meridien-dahab-resort.jpg?w=900&h=-1&s=1',
            'Swiss Inn Resort Dahab' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/193856860.jpg?k=41f6ca197d1fb7da55877c489abed66bf9b20d36cae8d1a3b11e2f9d863b15ad&o=',
            'Tropitel Dahab Oasis' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/23/e8/8b/5f/caption.jpg?w=900&h=-1&s=1',
            'Jaz Dahabeya' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/1b/3a/0b/ba/jaz-dahabeya.jpg?w=900&h=-1&s=1',
            'Tirana Dahab Resort' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/212959828.jpg?k=80509a2be7ed45778a4b4946bcff7fbac81f13b631d8e1c6b54199fcb605af5b&o=',
            'Acacia Dahab Hotel' => 'https://dynamic-media-cdn.tripadvisor.com/media/photo-o/0e/af/82/ef/acacia-dahab-hotel.jpg?w=900&h=-1&s=1',
        ];

        foreach ($locations as $city => $hotels) {
            foreach ($hotels as $index => $hotelName) {
                
                $hotelImage = $hotelImageMap[$hotelName] ?? $images[$index % count($images)];
                
                $hotel = Hotel::create([
                    'title' => $hotelName,
                    'description' => ($hotelName === 'Om Kolthoom Hotel') 
                        ? 'Experience the timeless elegance and classical Egyptian heritage at the iconic Om Kolthoom Hotel, dedicated to the legacy of the Star of the East.' 
                        : $hotelDescriptions[$index % count($hotelDescriptions)],
                    'location' => $city,
                    'address' => 'Downtown, ' . $city . ', Egypt',
                    'rating' => mt_rand(40, 50) / 10,
                    'reviews_count' => rand(100, 1500),
                    'price_starts_from' => rand(80, 500),
                    'image' => $hotelImage,
                    'gallery' => [
                        $images[($index + 1) % count($images)],
                        $hotelImage,
                        $images[($index + 3) % count($images)],
                    ],
                    'ar_url' => $arUrl
                ]);

                // Create default rooms for this hotel
                $roomsToCreate = [
                    [
                        'room_type' => 'Classic Single Room',
                        'capacity_adults' => 1,
                        'capacity_children' => 0,
                        'price_multiplier' => 1.0,
                    ],
                    [
                        'room_type' => 'Deluxe Double Room',
                        'capacity_adults' => 2,
                        'capacity_children' => 1,
                        'price_multiplier' => 1.5,
                    ],
                    [
                        'room_type' => 'Executive Suite',
                        'capacity_adults' => 2,
                        'capacity_children' => 2,
                        'price_multiplier' => 2.5,
                    ],
                    [
                        'room_type' => 'Presidential Suite',
                        'capacity_adults' => 4,
                        'capacity_children' => 3,
                        'price_multiplier' => 5.0,
                    ]
                ];

                foreach ($roomsToCreate as $rInfo) {
                    $featuresCount = rand(3, 6);
                    shuffle($roomFeaturesPool);
                    $features = array_slice($roomFeaturesPool, 0, $featuresCount);

                    Room::create([
                        'hotel_id' => $hotel->id,
                        'room_type' => $rInfo['room_type'],
                        'capacity_adults' => $rInfo['capacity_adults'],
                        'capacity_children' => $rInfo['capacity_children'],
                        'price_per_night' => $hotel->price_starts_from * $rInfo['price_multiplier'],
                        'available_count' => rand(2, 10),
                        'features' => $features,
                        'image' => $images[rand(0, count($images) - 1)],
                        'ar_url' => $arUrl
                    ]);
                }
            }
        }
    }
}
