<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['slug' => 'local-delivery-kit', 'name' => 'Local Delivery Kit', 'description' => 'Boxes, tape and handling labels sized for same-day runs inside the 10-mile radius.', 'price' => 24.00, 'unit' => 'starter kit', 'image' => 'assets/img/services/card-local.png', 'tag' => 'Best seller', 'sort_order' => 1],
            ['slug' => 'first-class-mailer-pack', 'name' => 'First Class Mailer Pack', 'description' => 'Padded mailers and tape for the small, quick shipments we run under 30 miles.', 'price' => 19.50, 'unit' => 'pack of 25', 'image' => 'assets/img/services/card-firstclass.png', 'tag' => '', 'sort_order' => 2],
            ['slug' => 'long-distance-moving-kit', 'name' => 'Long Distance Moving Kit', 'description' => 'Double-walled boxes, bubble wrap and blankets that hold up over long hauls.', 'price' => 89.00, 'unit' => 'full kit', 'image' => 'assets/img/services/card-longdistance.png', 'tag' => '', 'sort_order' => 3],
            ['slug' => 'pet-travel-crate', 'name' => 'Pet Travel Crate', 'description' => 'The ventilated, airline-style crate our drivers use on every pet delivery.', 'price' => 65.00, 'unit' => 'medium', 'image' => 'assets/img/services/card-pet.png', 'tag' => '', 'sort_order' => 4],
            ['slug' => 'heavy-haul-strap-set', 'name' => 'Heavy Haul Strap Set', 'description' => 'Ratchet straps and corner protectors rated for oversized, high-weight loads.', 'price' => 52.00, 'unit' => 'set of 4', 'image' => 'assets/img/services/card-heavyhaul.png', 'tag' => 'For freight', 'sort_order' => 5],
            ['slug' => 'pallet-wrap-bundle', 'name' => 'Pallet Wrap & Load Bars', 'description' => 'Stretch wrap and adjustable bars that keep consolidated partial loads from shifting.', 'price' => 46.00, 'unit' => 'bundle', 'image' => 'assets/img/services/card-consolidating.png', 'tag' => 'For freight', 'sort_order' => 6],
            ['slug' => 'power-only-trailer-kit', 'name' => 'Power Only Trailer Kit', 'description' => 'Kingpin lock, glad-hand seals and light cords for hooking up to your trailer.', 'price' => 38.00, 'unit' => 'kit', 'image' => 'assets/img/services/card-poweronly.png', 'tag' => 'For freight', 'sort_order' => 7],
            ['slug' => 'drop-trailer-security-kit', 'name' => 'Drop-Trailer Security Kit', 'description' => 'Bolt seals, a hardened padlock and wheel chocks for trailers left on site.', 'price' => 34.00, 'unit' => 'kit', 'image' => 'assets/img/services/card-droptrailer.png', 'tag' => 'For freight', 'sort_order' => 8],
        ];

        foreach ($products as $p) {
            Product::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}
