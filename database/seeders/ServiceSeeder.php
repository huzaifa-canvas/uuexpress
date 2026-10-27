<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Local Delivery',
                'slug' => 'local-delivery',
                'image' => 'assets/img/services/card-local.png',
                'desc' => 'Parcels, groceries and meals carried within ten miles.',
                'price' => 15.00,
                'tint' => 'green',
                'intro' => "Our local delivery services cover destinations within 10 miles of pickup across Albany. We carry parcels, groceries, and restaurant orders for households and businesses alike. A vetted driver who knows the neighborhood collects your item and brings it to the door, so your day keeps moving without an extra trip.",
                'detail_heading' => 'Your Errand, Handled Close to Home',
                'detail_body' => "Short trips deserve the same care as long ones. Our local delivery service moves parcels, groceries, and meals anywhere within 10 miles of pickup. A driver who knows Albany's streets takes the task off your hands.",
                'features' => [
                    'Deliveries within a 10-mile radius',
                    'Parcels, groceries, and restaurant orders',
                    'Vetted local drivers',
                ],
                'cta_heading' => 'Need It Nearby?',
                'sort_order' => 1,
            ],
            [
                'name' => 'First Class',
                'slug' => 'first-class',
                'image' => 'assets/img/services/card-firstclass.png',
                'desc' => 'Dependable runs beyond town, up to thirty miles.',
                'price' => 25.00,
                'tint' => 'green',
                'intro' => "First Class covers deliveries that travel beyond town, reaching up to 30 miles from pickup. It suits items that need to cross the Capital District on a set schedule, such as supplies for a business or a package for family nearby. Your driver carries the order from pickup to its destination with care.",
                'detail_heading' => 'Beyond Town, Still Within Reach',
                'detail_body' => "When your delivery needs to travel a little farther, First Class covers the distance. We carry items up to 30 miles from pickup across the Capital District with the same attention as a local run.",
                'features' => [
                    'Deliveries up to 30 miles',
                    'Suited to personal and business orders',
                    'Careful handling from start to finish',
                ],
                'cta_heading' => 'Ready to Send It Farther?',
                'sort_order' => 2,
            ],
            [
                'name' => 'Long Distance',
                'slug' => 'long-distance',
                'image' => 'assets/img/services/card-longdistance.png',
                'desc' => 'Careful handling on every journey of 100-plus miles.',
                'price' => 75.00,
                'tint' => 'green',
                'intro' => "Some deliveries need to travel farther. Our long-distance service handles trips of 100 miles and beyond, linking Albany with destinations well outside the region. We plan each route ahead of time and handle your item carefully throughout the journey, so it reaches the other end in good condition.",
                'detail_heading' => 'The Long Road, Covered with Care',
                'detail_body' => "Distance should never slow down what matters to you. Our long-distance service takes your items 100 miles and beyond, with a planned route and a driver who stays focused on a safe arrival.",
                'features' => [
                    'Trips of 100 miles and more',
                    'Routes planned in advance',
                    'Ideal for larger or time-sensitive orders',
                ],
                'cta_heading' => 'Going the Distance?',
                'sort_order' => 3,
            ],
            [
                'name' => 'Pet Delivery',
                'slug' => 'pet-delivery',
                'image' => 'assets/img/services/card-pet.png',
                'desc' => 'Gentle, attentive rides for the pets you love.',
                'price' => 45.00,
                'tint' => 'green',
                'intro' => "Pet delivery from UU Express gives animals a calm, attentive ride to wherever they need to be. We transport pets to new homes, groomers, boarding facilities, and veterinary appointments. Owners share care details at booking, and our drivers follow them closely from pickup to drop-off, treating every passenger with patience.",
                'detail_heading' => 'A Gentle Ride for Your Companion',
                'detail_body' => "Your pet deserves a calm and comfortable trip. Our drivers follow your care notes closely and treat every animal with patience, whether the destination is a new home or a grooming appointment.",
                'features' => [
                    'Rides to homes, groomers, boarding, and vet visits',
                    'Care instructions followed at every step',
                    'Patient, attentive drivers',
                ],
                'cta_heading' => 'Is Your Pet Ready to Travel?',
                'sort_order' => 4,
            ],
        ];

        foreach ($services as $s) {
            Service::updateOrCreate(['slug' => $s['slug']], $s);
        }
    }
}
