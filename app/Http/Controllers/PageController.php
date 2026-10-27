<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;

class PageController extends Controller
{
    public function home()
    {
        $services = Service::where('is_active', true)->orderBy('sort_order')->take(4)->get();
        $testimonials = Testimonial::orderBy('sort_order')->get();

        return view('pages.home', compact('services', 'testimonials'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function cart()
    {
        return view('pages.cart');
    }

    public function subscriptions()
    {
        return view('pages.subscriptions');
    }

    public function thankYou()
    {
        return view('pages.thankyou');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function terms()
    {
        return view('pages.terms');
    }
}
