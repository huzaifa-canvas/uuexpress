<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\Product;
use App\Models\Service;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'orders' => Order::count(),
            'revenue' => Order::where('payment_status', 'paid')->sum('total'),
            'bookings' => Booking::count(),
            'new_bookings' => Booking::where('status', 'new')->count(),
            'messages' => ContactMessage::count(),
            'unread_messages' => ContactMessage::whereNull('read_at')->count(),
            'services' => Service::count(),
            'products' => Product::count(),
        ];

        $recentOrders = Order::latest()->take(5)->get();
        $recentBookings = Booking::latest()->take(5)->get();
        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentBookings', 'recentMessages'));
    }
}
