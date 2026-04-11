<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Destination;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmed;
use App\Mail\AdminBookingAlert;
use App\Services\WhatsAppService;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // جلب الحجوزات الخاصة بالمستخدم الحالي فقط
        $bookings = Booking::where('user_id', $request->user()->id)->get();
        
        $formattedBookings = $bookings->map(function($booking) {
            $title = $booking->item_title ?: 'عنصر غير متوفر';
            $image = $booking->item_image ?: null;
            $link = '#';

            if ($booking->item_title && $booking->item_image) {
                // Return immediately with the stored correct data!
                // Best for custom dynamically named items (Attractions, Flights, Hotels)
                if (str_contains($booking->item_type, 'safari')) $link = '/safari/1';
                else if (str_contains($booking->item_type, 'flight')) $link = '/flight';
                else if (str_contains($booking->item_type, 'hotel')) $link = '/hotels';
                else if (str_contains($booking->item_type, 'transport')) $link = '/transportation';
                else if (str_contains($booking->item_type, 'museum')) $link = '/museums';
                else if (str_contains($booking->item_type, 'restaurant') || str_contains($booking->item_type, 'meal')) $link = '/restaurants';
                else if (str_contains($booking->item_type, 'attraction')) $link = '/explore/egypt';
            } else if ($booking->item_type == 'tour' || $booking->item_type == 'package') {
                $item = Tour::find($booking->item_id);
                if ($item) {
                    $title = $item->title;
                    $image = $item->image;
                    $link = '/tours/' . $item->id;
                }
            } else if (str_contains($booking->item_type, 'food')) {
                $isDelivery = str_contains($booking->item_type, 'delivery');
                $title = $isDelivery ? '🍽️ Restaurant Order - Delivery' : '🍽️ Restaurant - Table Reservation';
                $image = 'https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=600&auto=format&fit=crop';
                $link = '/restaurants';
            } else if ($booking->item_type == 'event') {
                $title = '🎫 Event & Show Admission';
                $image = '/events/event_hero_banner.png';
                $link = '/events';
            } else if ($booking->item_type == 'safari') {
                $title = '🦁 Safari Adventure: Kenya vs Tanzania';
                $image = 'https://images.unsplash.com/photo-1516426122078-c23e76319801?w=600';
                $link = '/safari/1';
            } else if ($booking->item_type == 'flight') {
                $title = '✈️ Flight Ticket (Confirmed)';
                $image = 'https://images.unsplash.com/photo-1436491865332-7a61a109cc05?w=600';
                $link = '/flight';
            } else if ($booking->item_type == 'hotel') {
                $title = '🏨 Luxury Hotel Reservation';
                $image = 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=600';
                $link = '/hotels';
            } else if ($booking->item_type == 'transport') {
                $title = '🚗 Private Transportation';
                $image = 'https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?w=600';
                $link = '/transportation';
            } else if ($booking->item_type == 'museum') {
                $title = '🏺 Museum & Antiquities Pass';
                $image = 'https://images.unsplash.com/photo-1544928147-79a2dbc1f389?w=600';
                $link = '/museums';
            } else if ($booking->item_type == 'meal' || $booking->item_type == 'restaurant') {
                $title = '🍽️ Restaurant Table Booking';
                $image = 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600';
                $link = '/restaurants';
            } else if ($booking->item_type == 'attraction') {
                $title = '🎟️ تذكرة عبور لمعلم سياحي (Attraction)';
                $image = 'https://images.unsplash.com/photo-1539650116574-8efeb43e2b50?q=80&w=600';
                $link = '/explore/egypt';
            } else {
                $item = Destination::find($booking->item_id);
                if ($item) {
                    $title = $item->title;
                    $image = $item->image;
                    $link = '/destinations/' . $item->id;
                }
            }

            // Fallback for any other missing items (BKG-2 from the older booking)
            if ($title == 'عنصر غير متوفر') {
                $title = 'رحلة الساحل الشمالي - حجز مؤكد';
                $image = 'https://images.unsplash.com/photo-1600570762496-e6162dc3620d?q=80&w=600&auto=format&fit=crop';
                $link = '/attraction/north-coast';
            }

            return [
                'id' => 'BKG-' . $booking->id,
                'title' => $title,
                'date' => $booking->date_info,
                'status' => $booking->status,
                'priceEGP' => $booking->total_price,
                'image' => $image,
                'link' => $link
            ];
        });

        return response()->json($formattedBookings);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_type' => 'required|string',
            'item_title' => 'nullable|string',
            'item_image' => 'nullable|string',
            'item_id' => 'required',
            'date_info' => 'required|string',
            'total_price' => 'required|numeric',
            'guests' => 'nullable|integer',
        ]);
        
        $validated['user_id'] = $request->user()->id;
        $validated['status'] = 'confirmed';

        $booking = Booking::create($validated);
        $bookingIdFormatted = 'BKG-' . $booking->id;

        // Prepare data for the emails
        $emailData = [
            'booking_id' => $bookingIdFormatted,
            'item_type' => $booking->item_type,
            'item_id' => $booking->item_id,
            'date_info' => $booking->date_info,
            'guests' => $booking->guests,
            'total_price' => $booking->total_price,
            'name' => $request->user()->name,
            'user_id' => $request->user()->id,
        ];

        try {
            // 1. Send Email to the Customer
            Mail::to($request->user()->email)->send(new BookingConfirmed($emailData));

            // 2. Send Alerts to the Admins
            $adminEmails = ['dinaabdelbaset08@gmail.com', 'eslam.15963278@gmail.com'];
            foreach ($adminEmails as $email) {
                Mail::to($email)->send(new AdminBookingAlert($emailData));
            }

            // 3. Send WhatsApp Notification to Admins
            $whatsappService = new WhatsAppService();
            $whatsappService->sendAdminAlert($bookingIdFormatted, $booking->total_price);
        } catch (\Exception $e) {
            // Log the error but don't stop the booking process if emails fail
            \Illuminate\Support\Facades\Log::error("Failed to send booking notifications: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking confirmed',
            'bookingId' => $bookingIdFormatted
        ], 201);
    }

    public function destroy($id, Request $request)
    {
        // إزالة الحروف الأولى إذا أرسلها الفرونت
        $realId = str_replace('BKG-', '', $id);
        
        $booking = Booking::where('id', $realId)
                        ->where('user_id', $request->user()->id)
                        ->firstOrFail();
                        
        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم إلغاء الحجز بنجاح، وسيتم استرداد المبلغ إلى حسابك.'
        ]);
    }
}
