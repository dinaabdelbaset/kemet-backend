<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        if (Event::count() === 0) {
            $this->seedEvents();
        }

        return response()->json(Event::all());
    }

    public function show($id)
    {
        $event = Event::find($id);
        if (!$event) {
            return response()->json(['message' => 'Event not found'], 404);
        }
        return response()->json($event);
    }

    private function seedEvents()
    {
        $data = [
            // 1. Cairo
            [
                'title' => 'Whirling Dervishes at Al-Ghouri',
                'description' => 'Free weekly performance of the traditional Sufi Tanoura dance at the historic Al-Ghouri complex in Islamic Cairo.',
                'location' => 'Cairo',
                'venue' => 'Al-Ghouri Complex',
                'date' => '2026-05-20',
                'time' => '8:00 PM',
                'price' => 0,
                'category' => 'Cultural',
                'image' => '/images/events/whirling-dervishes.jpg',
                'rating' => 4.9,
            ],
            [
                'title' => 'Cairo Jazz Festival',
                'description' => 'Annual music festival featuring local and international jazz, blues, and world music artists performing across multiple stages.',
                'location' => 'Cairo',
                'venue' => 'Cairo Opera House',
                'date' => '2026-06-10',
                'time' => '6:00 PM',
                'price' => 500,
                'category' => 'Music',
                'image' => '/images/events/cairo-jazz-festival.jpg',
                'rating' => 4.7,
            ],
            [
                'title' => 'Cairo International Book Fair',
                'description' => 'The largest book fair in the Arab world featuring thousands of publishers, author signings, and cultural events.',
                'location' => 'Cairo',
                'venue' => 'Egypt International Exhibition Center',
                'date' => '2026-08-15',
                'time' => '10:00 AM',
                'price' => 50,
                'category' => 'Cultural',
                'image' => '/images/events/cairo-book-fair.jpg',
                'rating' => 4.3,
            ],

            // 2. Giza
            [
                'title' => 'Pyramids Sound & Light Show',
                'description' => 'Experience the magic of the Pyramids illuminated at night with a spectacular sound and light show narrating 7000 years of Egyptian history.',
                'location' => 'Giza',
                'venue' => 'Giza Pyramids Plateau',
                'date' => '2026-05-15',
                'time' => '7:30 PM',
                'price' => 350,
                'category' => 'Show',
                'image' => '/images/events/pyramids-sound-light.jpg',
                'rating' => 4.8,
            ],
            [
                'title' => 'Opera Aida at the Pyramids',
                'description' => 'A stunning outdoor performance of Verdi\'s Aida opera set against the backdrop of the Great Pyramids.',
                'location' => 'Giza',
                'venue' => 'Pyramids Plateau',
                'date' => '2026-07-01',
                'time' => '8:00 PM',
                'price' => 1200,
                'category' => 'Opera',
                'image' => '/images/events/opera-aida.jpg',
                'rating' => 4.9,
            ],
            [
                'title' => 'Giza Pyramids Marathon & Concert',
                'description' => 'Run among the ancient Pyramids of Giza followed by an evening celebration concert with top Egyptian pop artists.',
                'location' => 'Giza',
                'venue' => 'Giza Pyramids Plateau',
                'date' => '2026-10-22',
                'time' => '6:00 AM',
                'price' => 600,
                'category' => 'Sports',
                'image' => '/images/events/pyramids-sound-light.jpg',
                'rating' => 4.8,
            ],

            // 3. Alexandria
            [
                'title' => 'Alexandria International Film Festival',
                'description' => 'Annual cinema event highlighting Mediterranean cinema, featuring film screenings, discussions, and celebrity galas at the Bibliotheca.',
                'location' => 'Alexandria',
                'venue' => 'Bibliotheca Alexandrina',
                'date' => '2026-09-05',
                'time' => '5:00 PM',
                'price' => 150,
                'category' => 'Cultural',
                'image' => '/images/events/whirling-dervishes.jpg',
                'rating' => 4.6,
            ],
            [
                'title' => 'Roman Theatre Summer Concerts',
                'description' => 'Traditional live orchestra and modern indie bands performing under the stars in the historic Roman Amphitheatre of Kom El Deka.',
                'location' => 'Alexandria',
                'venue' => 'Roman Amphitheatre',
                'date' => '2026-07-15',
                'time' => '8:00 PM',
                'price' => 250,
                'category' => 'Music',
                'image' => '/images/events/cairo-jazz-festival.jpg',
                'rating' => 4.7,
            ],
            [
                'title' => 'Alexandria Yacht Club Regatta & Gala',
                'description' => 'Watch the annual sailing yacht race in the Eastern Harbour followed by an elegant seafood banquet dinner and firework show.',
                'location' => 'Alexandria',
                'venue' => 'Eastern Harbour Yacht Club',
                'date' => '2026-08-20',
                'time' => '3:00 PM',
                'price' => 400,
                'category' => 'Gala',
                'image' => '/images/events/opera-aida.jpg',
                'rating' => 4.5,
            ],

            // 4. Luxor
            [
                'title' => 'Luxor African Film Festival',
                'description' => 'Discover the best of African cinema during this week-long festival featuring screenings in front of the illuminated Luxor Temple.',
                'location' => 'Luxor',
                'venue' => 'Luxor Temple Plateau',
                'date' => '2026-11-12',
                'time' => '7:00 PM',
                'price' => 100,
                'category' => 'Cultural',
                'image' => '/images/events/whirling-dervishes.jpg',
                'rating' => 4.7,
            ],
            [
                'title' => 'Valley of the Kings Light Show',
                'description' => 'A breathtaking light and projection-mapping show illuminating the Valley of the Kings, explaining ancient Egyptian afterlife beliefs.',
                'location' => 'Luxor',
                'venue' => 'Valley of the Kings Temple',
                'date' => '2026-10-05',
                'time' => '8:00 PM',
                'price' => 300,
                'category' => 'Show',
                'image' => '/images/events/pyramids-sound-light.jpg',
                'rating' => 4.8,
            ],
            [
                'title' => 'Luxor Balloon Festival & Concert',
                'description' => 'Dozens of hot air balloons lighting up the West Bank sky at dawn followed by an evening folklore music concert.',
                'location' => 'Luxor',
                'venue' => 'West Bank Desert Field',
                'date' => '2026-12-01',
                'time' => '5:00 AM',
                'price' => 800,
                'category' => 'Festival',
                'image' => '/images/events/cairo-jazz-festival.jpg',
                'rating' => 4.9,
            ],

            // 5. Aswan
            [
                'title' => 'Abu Simbel Sun Festival',
                'description' => 'Gather at Abu Simbel to witness the sun align perfectly to illuminate the inner sanctuary of King Ramses II temple.',
                'location' => 'Aswan',
                'venue' => 'Abu Simbel Temple',
                'date' => '2026-10-22',
                'time' => '5:30 AM',
                'price' => 400,
                'category' => 'Cultural',
                'image' => '/images/events/pyramids-sound-light.jpg',
                'rating' => 4.9,
            ],
            [
                'title' => 'Nubian Folk Art & Music Festival',
                'description' => 'A lively festival celebrating Nubian heritage with traditional song, dance, handmade crafts, and local culinary delicacies.',
                'location' => 'Aswan',
                'venue' => 'Nubian Village Amphitheatre',
                'date' => '2026-11-20',
                'time' => '6:00 PM',
                'price' => 150,
                'category' => 'Music',
                'image' => '/images/events/whirling-dervishes.jpg',
                'rating' => 4.8,
            ],
            [
                'title' => 'Aswan Sculpture Symposium Exhibition',
                'description' => 'Open-air exhibition featuring incredible stone sculptures created by local and international artists using Aswan granite.',
                'location' => 'Aswan',
                'venue' => 'Basma Sculpture Park',
                'date' => '2026-09-30',
                'time' => '10:00 AM',
                'price' => 100,
                'category' => 'Art',
                'image' => '/images/events/cairo-book-fair.jpg',
                'rating' => 4.6,
            ],

            // 6. Sharm El-Sheikh
            [
                'title' => 'Sharm El-Sheikh International Theater Festival',
                'description' => 'A vibrant youth theater festival hosting experimental acts and workshops from Europe, Africa, and the Middle East.',
                'location' => 'Sharm El-Sheikh',
                'venue' => 'Sharm El-Sheikh Congress Center',
                'date' => '2026-11-05',
                'time' => '6:00 PM',
                'price' => 200,
                'category' => 'Cultural',
                'image' => '/images/events/whirling-dervishes.jpg',
                'rating' => 4.6,
            ],
            [
                'title' => 'Soho Square Live Concert',
                'description' => 'Join the weekend crowd at Soho Square for an open-air concert featuring live pop singers and a dancing fountain show.',
                'location' => 'Sharm El-Sheikh',
                'venue' => 'Soho Square Stage',
                'date' => '2026-07-28',
                'time' => '9:00 PM',
                'price' => 350,
                'category' => 'Music',
                'image' => '/images/events/cairo-jazz-festival.jpg',
                'rating' => 4.7,
            ],
            [
                'title' => 'Red Sea Coral Reef Conservation Gala',
                'description' => 'An educational gala and underwater photography exhibition dedicated to protecting the fragile marine ecosystem of Sharm El-Sheikh.',
                'location' => 'Sharm El-Sheikh',
                'venue' => 'Naama Bay Beach',
                'date' => '2026-08-10',
                'time' => '7:00 PM',
                'price' => 500,
                'category' => 'Gala',
                'image' => '/images/events/red-sea-edm.jpg',
                'rating' => 4.8,
            ],

            // 7. Hurghada
            [
                'title' => 'Red Sea EDM Beach Party',
                'description' => 'Dance the night away on the shores of the Red Sea with top international DJs and stunning visual effects.',
                'location' => 'Hurghada',
                'venue' => 'Soma Bay Beach',
                'date' => '2026-06-25',
                'time' => '9:00 PM',
                'price' => 800,
                'category' => 'Music',
                'image' => '/images/events/red-sea-edm.jpg',
                'rating' => 4.5,
            ],
            [
                'title' => 'Hurghada International Yacht Show',
                'description' => 'View luxury yachts and marine sports equipment at the Marina Boulevard, accompanied by live music and seafood catering.',
                'location' => 'Hurghada',
                'venue' => 'Marina Boulevard',
                'date' => '2026-09-18',
                'time' => '11:00 AM',
                'price' => 200,
                'category' => 'Festival',
                'image' => '/images/events/whirling-dervishes.jpg',
                'rating' => 4.6,
            ],
            [
                'title' => 'El Gouna Film Festival Afterparty & Concert',
                'description' => 'Experience the glamour of El Gouna Film Festival at the official afterparty featuring live music, stars, and Red Sea views.',
                'location' => 'Hurghada',
                'venue' => 'El Gouna Marina',
                'date' => '2026-10-18',
                'time' => '10:00 PM',
                'price' => 1500,
                'category' => 'Music',
                'image' => '/images/events/cairo-jazz-festival.jpg',
                'rating' => 4.9,
            ],

            // 8. Marsa Alam
            [
                'title' => 'Marsa Alam Eco-Music Festival',
                'description' => 'An intimate eco-friendly acoustic music festival under the stars at Wadi Lahami eco-camp, focusing on natural vibes.',
                'location' => 'Marsa Alam',
                'venue' => 'Wadi Lahami Eco-Camp',
                'date' => '2026-11-15',
                'time' => '6:00 PM',
                'price' => 300,
                'category' => 'Music',
                'image' => '/images/events/cairo-jazz-festival.jpg',
                'rating' => 4.7,
            ],
            [
                'title' => 'Bedouin Heritage Festival',
                'description' => 'Learn about the traditions of the Ababda and Bishari tribes of Marsa Alam with camel shows, poetry, and herbal tea.',
                'location' => 'Marsa Alam',
                'venue' => 'Wadi El Gemal Protectorate',
                'date' => '2026-10-10',
                'time' => '4:00 PM',
                'price' => 150,
                'category' => 'Cultural',
                'image' => '/images/events/whirling-dervishes.jpg',
                'rating' => 4.6,
            ],
            [
                'title' => 'Red Sea Marine Carnival',
                'description' => 'A beach festival featuring water sports competitions, local musical acts, and fresh fish barbecue dining.',
                'location' => 'Marsa Alam',
                'venue' => 'Abu Dabbab Beach',
                'date' => '2026-08-05',
                'time' => '12:00 PM',
                'price' => 250,
                'category' => 'Festival',
                'image' => '/images/events/red-sea-edm.jpg',
                'rating' => 4.8,
            ],

            // 9. Marsa Matrouh
            [
                'title' => 'Matrouh Summer Carnival & Folk Show',
                'description' => 'Summer folklore performance featuring Bedouin dancers and live local music at the beachfront Rommel theater.',
                'location' => 'Marsa Matrouh',
                'venue' => 'Rommel Beach Stage',
                'date' => '2026-07-20',
                'time' => '8:00 PM',
                'price' => 50,
                'category' => 'Festival',
                'image' => '/images/events/whirling-dervishes.jpg',
                'rating' => 4.4,
            ],
            [
                'title' => 'Cleopatra Beach Sunset Concert',
                'description' => 'Listen to calming acoustic guitar and ambient melodies overlooking the historical rock pools of Cleopatra Beach.',
                'location' => 'Marsa Matrouh',
                'venue' => 'Cleopatra Beach Dunes',
                'date' => '2026-08-12',
                'time' => '6:30 PM',
                'price' => 200,
                'category' => 'Music',
                'image' => '/images/events/cairo-jazz-festival.jpg',
                'rating' => 4.6,
            ],
            [
                'title' => 'Matrouh Mint Tea & Bedouin Poetry Night',
                'description' => 'Gather around a crackling campfire in a traditional desert tent to listen to epic poems and sample Matrouh mint tea.',
                'location' => 'Marsa Matrouh',
                'venue' => 'Bedouin Desert Tents',
                'date' => '2026-09-02',
                'time' => '8:00 PM',
                'price' => 100,
                'category' => 'Cultural',
                'image' => '/images/events/pyramids-sound-light.jpg',
                'rating' => 4.7,
            ],

            // 10. Port Said
            [
                'title' => 'Port Said Salt Mountain Winter Festival',
                'description' => 'Take photos in Port Fouad\'s famous snow-like salt mountains and enjoy a local folklore Tanoura dance show.',
                'location' => 'Port Said',
                'venue' => 'Port Fouad Salt Mountains',
                'date' => '2026-12-15',
                'time' => '10:00 AM',
                'price' => 80,
                'category' => 'Festival',
                'image' => '/images/events/whirling-dervishes.jpg',
                'rating' => 4.5,
            ],
            [
                'title' => 'Suez Canal Yacht Parade & Fireworks',
                'description' => 'Watch a magnificent flotilla of yachts pass through the Suez Canal accompanied by a brilliant laser and fireworks display.',
                'location' => 'Port Said',
                'venue' => 'Port Said Marina',
                'date' => '2026-08-25',
                'time' => '7:00 PM',
                'price' => 150,
                'category' => 'Show',
                'image' => '/images/events/pyramids-sound-light.jpg',
                'rating' => 4.7,
            ],
            [
                'title' => 'Port Said Port Carnival',
                'description' => 'Celebrate the maritime history of Port Said with street parades, seafood cooking stalls, and live concerts at Center Plaza.',
                'location' => 'Port Said',
                'venue' => 'Port Said Center Plaza',
                'date' => '2026-10-30',
                'time' => '4:00 PM',
                'price' => 50,
                'category' => 'Cultural',
                'image' => '/images/events/cairo-jazz-festival.jpg',
                'rating' => 4.6,
            ],

            // 11. Fayoum
            [
                'title' => 'Tunis Village Pottery Festival',
                'description' => 'Celebrate handmade pottery and local crafts at the beautiful Tunis Village, with workshops and folklore shows.',
                'location' => 'Fayoum',
                'venue' => 'Tunis Village Fayoum',
                'date' => '2026-11-01',
                'time' => '10:00 AM',
                'price' => 100,
                'category' => 'Festival',
                'image' => '/images/events/cairo-book-fair.jpg',
                'rating' => 4.8,
            ],
            [
                'title' => 'Wadi El Rayan Desert Campfire Concert',
                'description' => 'A cozy campfire evening on the shores of Wadi El Rayan Lake, featuring live acoustic music and Bedouin dinner.',
                'location' => 'Fayoum',
                'venue' => 'Wadi El Rayan Lake-side',
                'date' => '2026-10-15',
                'time' => '6:00 PM',
                'price' => 250,
                'category' => 'Music',
                'image' => '/images/events/cairo-jazz-festival.jpg',
                'rating' => 4.7,
            ],
            [
                'title' => 'Fayoum Magic Lake Sandboarding Competition',
                'description' => 'Watch Egypt\'s top sandboarders compete on the golden dunes of Magic Lake, complete with live DJ beats.',
                'location' => 'Fayoum',
                'venue' => 'Magic Lake Dunes',
                'date' => '2026-09-22',
                'time' => '9:00 AM',
                'price' => 150,
                'category' => 'Sports',
                'image' => '/images/events/red-sea-edm.jpg',
                'rating' => 4.8,
            ],
        ];

        foreach ($data as $item) {
            Event::create($item);
        }
    }
}
