<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ArabCountry;
use App\Models\ArabLandmark;
use App\Models\Hotel;
use App\Models\Restaurant;

class ArabWorldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            [
                'name_en' => 'Saudi Arabia',
                'name_ar' => 'المملكة العربية السعودية',
                'code' => 'SA',
                'flag' => '🇸🇦',
                'image' => 'https://images.unsplash.com/photo-1586724237569-f38559db835c?auto=format&fit=crop&q=80&w=800',
                'description_en' => 'Discover the land of ancient heritage, mystical deserts, and futuristic developments.',
                'description_ar' => 'اكتشف أرض التراث العريق، الصحاري الغامضة، والمشاريع المستقبلية الرائعة.',
                'landmarks' => [
                    [
                        'name_en' => 'Al-Ula & Madain Saleh',
                        'name_ar' => 'العلا ومدائن صالح',
                        'location_en' => 'Medina Region',
                        'location_ar' => 'منطقة المدينة المنورة',
                        'category' => 'historical',
                        'image' => 'https://images.unsplash.com/photo-1629814249584-bb4d324e246f?auto=format&fit=crop&q=80&w=800',
                        'description_en' => 'Saudi Arabia’s first UNESCO World Heritage site, featuring majestic carved sandstone tombs dating back to the Nabataean Kingdom.',
                        'description_ar' => 'أول موقع مسجل للتراث العالمي لليونسكو في السعودية، ويضم مقابر صخرية مهيبة منحوتة في الجبال الرملية تعود للعهد النبطي.',
                        'latitude' => 26.8052,
                        'longitude' => 37.9563,
                        'rating' => 4.90,
                    ],
                ],
                'hotels' => [
                    [
                        'title' => 'Fairmont Makkah Clock Royal Tower',
                        'description' => 'A luxury hotel overlooking the Holy Kaaba and Al Masjid Al Haram, located inside the Clock Tower complex.',
                        'location' => 'Makkah, Saudi Arabia',
                        'address' => 'King Abdul Aziz Endowment, Makkah',
                        'rating' => 4.85,
                        'reviews_count' => 920,
                        'price_starts_from' => 1200.00,
                        'image' => 'https://images.unsplash.com/photo-1591604021695-0c69b7c05981?auto=format&fit=crop&q=80&w=800',
                        'gallery' => [
                            'https://images.unsplash.com/photo-1591604021695-0c69b7c05981?auto=format&fit=crop&q=80&w=800'
                        ],
                    ]
                ],
                'restaurants' => [
                    [
                        'name' => 'Suhail Traditional Restaurant',
                        'cuisine' => 'Saudi & Arabian Cuisine',
                        'location' => 'Riyadh, Saudi Arabia',
                        'address' => 'Northern Ring Road, Riyadh',
                        'description' => 'A high-end restaurant serving authentic Saudi Arabian cuisine in a beautiful modern design inspired by Najdi culture.',
                        'image' => 'https://images.unsplash.com/photo-1590001155093-a3c66ab0c3ff?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1590001155093-a3c66ab0c3ff?auto=format&fit=crop&q=80&w=800'],
                        'price_range_min' => 150,
                        'price_range_max' => 500,
                        'rating' => 4.7,
                        'reviews_count' => 340,
                        'opening_hours' => '1:00 PM - 12:00 AM',
                        'features' => ['Traditional Seating', 'Live Cooking', 'Family Sections']
                    ]
                ]
            ],
            [
                'name_en' => 'United Arab Emirates',
                'name_ar' => 'الإمارات العربية المتحدة',
                'code' => 'AE',
                'flag' => '🇦🇪',
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?auto=format&fit=crop&q=80&w=800',
                'description_en' => 'Experience a perfect blend of futuristic architectural marvels, luxury, and traditional Arabian hospitality.',
                'description_ar' => 'عش تجربة مثالية تجمع بين عجائب الهندسة المعمارية المستقبلية، الفخامة، والضيافة العربية الأصيلة.',
                'landmarks' => [
                    [
                        'name_en' => 'Burj Khalifa',
                        'name_ar' => 'برج خليفة',
                        'location_en' => 'Dubai',
                        'location_ar' => 'دبي',
                        'category' => 'modern',
                        'image' => 'https://images.unsplash.com/photo-1597655601841-214a4cfe8b2c?auto=format&fit=crop&q=80&w=800',
                        'description_en' => 'The tallest man-made structure in the world, standing at a magnificent height of 828 meters with stunning observation decks.',
                        'description_ar' => 'أطول برج من صنع الإنسان في العالم، يصل ارتفاعه إلى 828 متراً، ويتميز بإطلالات بانورامية خلابة من منصات المشاهدة.',
                        'latitude' => 25.1972,
                        'longitude' => 55.2744,
                        'rating' => 4.95,
                    ],
                ],
                'hotels' => [
                    [
                        'title' => 'Burj Al Arab Jumeirah',
                        'description' => 'The global icon of Arabian luxury. The famous sail-shaped hotel features ultra-luxurious duplex suites and premium dining.',
                        'location' => 'Dubai, UAE',
                        'address' => 'Jumeirah Beach Road, Dubai',
                        'rating' => 4.98,
                        'reviews_count' => 1520,
                        'price_starts_from' => 5500.00,
                        'image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&q=80&w=800'],
                    ]
                ],
                'restaurants' => [
                    [
                        'name' => 'Zuma Dubai',
                        'cuisine' => 'Contemporary Japanese (Izakaya)',
                        'location' => 'Dubai, UAE',
                        'address' => 'Gate Village, DIFC, Dubai',
                        'description' => 'Award-winning restaurant offering a sophisticated Japanese dining experience in the heart of DIFC.',
                        'image' => 'https://images.unsplash.com/photo-1579027989536-b7b1f375659b?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1579027989536-b7b1f375659b?auto=format&fit=crop&q=80&w=800'],
                        'price_range_min' => 250,
                        'price_range_max' => 900,
                        'rating' => 4.8,
                        'reviews_count' => 1250,
                        'opening_hours' => '12:00 PM - 12:00 AM',
                        'features' => ['Valet Parking', 'Luxury Dining', 'Bar & Lounge']
                    ]
                ]
            ],
            [
                'name_en' => 'Jordan',
                'name_ar' => 'الأردن',
                'code' => 'JO',
                'flag' => '🇯🇴',
                'image' => 'https://images.unsplash.com/photo-1541432901042-2d8bd64b4a9b?auto=format&fit=crop&q=80&w=800',
                'description_en' => 'A treasure trove of history, home to ancient ruins, therapeutic seas, and majestic red desertscapes.',
                'description_ar' => 'كنز تاريخي دفين، وموطن للآثار القديمة، والبحار العلاجية، والصحاري الحمراء المهيبة.',
                'landmarks' => [
                    [
                        'name_en' => 'Petra (The Rose City)',
                        'name_ar' => 'البتراء (المدينة الوردية)',
                        'location_en' => 'Ma\'an Governorate',
                        'location_ar' => 'محافظة معان',
                        'category' => 'historical',
                        'image' => 'https://images.unsplash.com/photo-1541432901042-2d8bd64b4a9b?auto=format&fit=crop&q=80&w=800',
                        'description_en' => 'One of the New Seven Wonders of the World, featuring beautiful temples and tombs carved directly into pink sandstone cliffs.',
                        'description_ar' => 'إحدى عجائب الدنيا السبع الجديدة، تتميز بجمال معابدها ومقابرها المنحوتة مباشرة في الصخور الوردية.',
                        'latitude' => 30.3285,
                        'longitude' => 35.4444,
                        'rating' => 4.95,
                    ],
                ],
                'hotels' => [
                    [
                        'title' => 'Mövenpick Resort & Spa Dead Sea',
                        'description' => 'A traditional village-style spa resort positioned directly on the shores of the therapeutic Dead Sea.',
                        'location' => 'Dead Sea, Jordan',
                        'address' => 'Sweimeh, Dead Sea',
                        'rating' => 4.75,
                        'reviews_count' => 520,
                        'price_starts_from' => 1100.00,
                        'image' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&q=80&w=800'],
                    ]
                ],
                'restaurants' => [
                    [
                        'name' => 'Hashem Restaurant Amman',
                        'cuisine' => 'Traditional Jordan Food',
                        'location' => 'Amman, Jordan',
                        'address' => 'King Faisal Street, Amman',
                        'description' => 'One of the oldest and most legendary street-food restaurants in Amman, famous for fresh falafel, hummus, and fuul.',
                        'image' => 'https://images.unsplash.com/photo-1565557623262-b51c2513a641?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1565557623262-b51c2513a641?auto=format&fit=crop&q=80&w=800'],
                        'price_range_min' => 10,
                        'price_range_max' => 50,
                        'rating' => 4.9,
                        'reviews_count' => 3200,
                        'opening_hours' => '24/7 Open',
                        'features' => ['Casual Dining', 'Outdoor Seating', 'Cheap Eats']
                    ]
                ]
            ],
            [
                'name_en' => 'Morocco',
                'name_ar' => 'المغرب',
                'code' => 'MA',
                'flag' => '🇲🇦',
                'image' => 'https://images.unsplash.com/photo-1489749798305-4fea3ae63d43?auto=format&fit=crop&q=80&w=800',
                'description_en' => 'A vibrant gateway to North Africa, full of bustling souqs, stunning Islamic art, and rich multicultural history.',
                'description_ar' => 'بوابة شمال أفريقيا النابضة بالحياة، المليئة بالأسواق الملونة، الفن الإسلامي المبهر، والتاريخ الثقافي الغني.',
                'landmarks' => [
                    [
                        'name_en' => 'Hassan II Mosque',
                        'name_ar' => 'مسجد الحسن الثاني',
                        'location_en' => 'Casablanca',
                        'location_ar' => 'الدار البيضاء',
                        'category' => 'historical',
                        'image' => 'https://images.unsplash.com/photo-1564507592333-c60657eea523?auto=format&fit=crop&q=80&w=800',
                        'description_en' => 'A colossal mosque boasting a 210-meter minaret, built partially over the waters of the Atlantic Ocean.',
                        'description_ar' => 'من أروع الصروح الدينية في العالم، يتميز بمئذنته البالغ ارتفاعها 210 أمتار، وتم بناؤه جزئياً فوق مياه المحيط الأطلسي.',
                        'latitude' => 33.6083,
                        'longitude' => -7.6325,
                        'rating' => 4.90,
                    ],
                ],
                'hotels' => [
                    [
                        'title' => 'La Mamounia Marrakech',
                        'description' => 'A legendary historical palace hotel set within 18 acres of royal gardens in the heart of Marrakech.',
                        'location' => 'Marrakech, Morocco',
                        'address' => 'Avenue Bab Jdid, Marrakech',
                        'rating' => 4.92,
                        'reviews_count' => 840,
                        'price_starts_from' => 3200.00,
                        'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&q=80&w=800'],
                    ]
                ],
                'restaurants' => [
                    [
                        'name' => 'Al Fassia Marrakech',
                        'cuisine' => 'Traditional Moroccan Food',
                        'location' => 'Marrakech, Morocco',
                        'address' => '55 Boulevard Mohamed Zerktouni, Marrakech',
                        'description' => 'World-famous restaurant run entirely by women, serving the finest traditional tagines and couscous.',
                        'image' => 'https://images.unsplash.com/photo-1541532713592-79a0317b6b77?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1541532713592-79a0317b6b77?auto=format&fit=crop&q=80&w=800'],
                        'price_range_min' => 120,
                        'price_range_max' => 450,
                        'rating' => 4.8,
                        'reviews_count' => 670,
                        'opening_hours' => '7:00 PM - 11:00 PM',
                        'features' => ['Cozy Dining', 'Vegetarian Options', 'Reservations Required']
                    ]
                ]
            ],
            [
                'name_en' => 'Lebanon',
                'name_ar' => 'لبنان',
                'code' => 'LB',
                'flag' => '🇱🇧',
                'image' => 'https://images.unsplash.com/photo-1544161513-0179fe746fd5?auto=format&fit=crop&q=80&w=800',
                'description_en' => 'Discover Mediterranean coastline, delicious culinary history, and ancient Phoenician and Roman civilizations.',
                'description_ar' => 'اكتشف سواحل البحر الأبيض المتوسط، تاريخ المطبخ اللبناني الشهير، والحضارات الفينيقية والرومانية العريقة.',
                'landmarks' => [
                    [
                        'name_en' => 'Jeita Grotto',
                        'name_ar' => 'مغارة جعيتا',
                        'location_en' => 'Nahr al-Kalb valley, Keserwan',
                        'location_ar' => 'وادي نهر الكلب، كسروان',
                        'category' => 'nature',
                        'image' => 'https://images.unsplash.com/photo-1629812495396-d2427a1ef24c?auto=format&fit=crop&q=80&w=800',
                        'description_en' => 'A system of two separate but interconnected limestone caves boasting some of the world’s most magnificent stalactite formations.',
                        'description_ar' => 'مغارة طبيعية تتكون من كهوف مائية وجيرية علوية وسفلية، تحتوي على أروع الهوابط والصواعد الصخرية عالمياً.',
                        'latitude' => 33.9439,
                        'longitude' => 35.6425,
                        'rating' => 4.90,
                    ],
                ],
                'hotels' => [
                    [
                        'title' => 'InterContinental Phoenicia Beirut',
                        'description' => 'Overlooking the Mediterranean Sea, this landmark hotel is a symbol of luxury and sophistication in Beirut.',
                        'location' => 'Beirut, Lebanon',
                        'address' => 'Minet El Hosn, Beirut',
                        'rating' => 4.80,
                        'reviews_count' => 1120,
                        'price_starts_from' => 1500.00,
                        'image' => 'https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?auto=format&fit=crop&q=80&w=800'],
                    ]
                ],
                'restaurants' => [
                    [
                        'name' => 'Em Sherif Beirut',
                        'cuisine' => 'Traditional Lebanese Cuisine',
                        'location' => 'Beirut, Lebanon',
                        'address' => 'Rue Victor Hugo, Beirut',
                        'description' => 'A luxury mansion-style restaurant serving a multi-course, authentic Lebanese banquet in an elegant oriental atmosphere.',
                        'image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&q=80&w=800'],
                        'price_range_min' => 200,
                        'price_range_max' => 800,
                        'rating' => 4.9,
                        'reviews_count' => 950,
                        'opening_hours' => '1:00 PM - 11:30 PM',
                        'features' => ['Luxury Banquet', 'Live Oriental Music', 'Valet Parking']
                    ]
                ]
            ],
            [
                'name_en' => 'Oman',
                'name_ar' => 'سلطنة عُمان',
                'code' => 'OM',
                'flag' => '🇴🇲',
                'image' => 'https://images.unsplash.com/photo-1605276374104-dee2a0ed3cd6?auto=format&fit=crop&q=80&w=800',
                'description_en' => 'Explore the hidden gem of Arabia, full of crystal wadis, mountain forts, and ancient marine history.',
                'description_ar' => 'استكشف درة شبه الجزيرة العربية، المليئة بالوديان المائية الفيروزية، الحصون الجبلية، والتاريخ البحري القديم.',
                'landmarks' => [
                    [
                        'name_en' => 'Sultan Qaboos Grand Mosque',
                        'name_ar' => 'جامع السلطان قابوس الأكبر',
                        'location_en' => 'Muscat',
                        'location_ar' => 'مسقط',
                        'category' => 'historical',
                        'image' => 'https://images.unsplash.com/photo-1598449356475-b9f71bc7d847?auto=format&fit=crop&q=80&w=800',
                        'description_en' => 'A stunning work of modern Islamic architecture, housing a single-piece hand-woven Persian carpet and a colossal chandelier.',
                        'description_ar' => 'صرح إسلامي فني فريد يتميز بمعماره الحديث، ويحتوي على سجادة عجمية منسوجة كقطعة واحدة وثريا كريستالية ضخمة.',
                        'latitude' => 23.5836,
                        'longitude' => 58.3889,
                        'rating' => 4.90,
                    ],
                ],
                'hotels' => [
                    [
                        'title' => 'Al Bustan Palace, a Ritz-Carlton Hotel',
                        'description' => 'A landmark palace hotel set against Al Hajar Mountains range and overlooking the beautiful Sea of Oman.',
                        'location' => 'Muscat, Oman',
                        'address' => 'Al Bustan Street, Muscat',
                        'rating' => 4.88,
                        'reviews_count' => 610,
                        'price_starts_from' => 1400.00,
                        'image' => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&q=80&w=800'],
                    ]
                ],
                'restaurants' => [
                    [
                        'name' => 'Kargeen Caffe Muscat',
                        'cuisine' => 'Traditional Omani & Levantine',
                        'location' => 'Muscat, Oman',
                        'address' => 'Al Bashair Street, Muscat',
                        'description' => 'A beautiful open-air Omani style garden cafe serving traditional Omani shuwa, grills, and fresh juice.',
                        'image' => 'https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&q=80&w=800',
                        'gallery' => ['https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&q=80&w=800'],
                        'price_range_min' => 40,
                        'price_range_max' => 180,
                        'rating' => 4.7,
                        'reviews_count' => 840,
                        'opening_hours' => '11:00 AM - 1:00 AM',
                        'features' => ['Garden Seating', 'Omani Shuwa', 'Casual Vibe']
                    ]
                ]
            ]
        ];

        foreach ($countries as $countryData) {
            $landmarks = $countryData['landmarks'];
            $hotels = $countryData['hotels'] ?? [];
            $restaurants = $countryData['restaurants'] ?? [];

            unset($countryData['landmarks']);
            unset($countryData['hotels']);
            unset($countryData['restaurants']);

            $country = ArabCountry::create($countryData);

            foreach ($landmarks as $landmark) {
                $landmark['country_id'] = $country->id;
                ArabLandmark::create($landmark);
            }

            foreach ($hotels as $hotel) {
                $hotel['arab_country_id'] = $country->id;
                $hotel['status'] = 'approved';
                Hotel::create($hotel);
            }

            foreach ($restaurants as $restaurant) {
                $restaurant['arab_country_id'] = $country->id;
                $restaurant['status'] = 'approved';
                Restaurant::create($restaurant);
            }
        }
    }
}
