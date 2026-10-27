<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            ['client_name' => 'Jim Smith', 'rating' => 5, 'quote' => 'Our restaurant uses UU Express for local orders every week. Food reaches customers warm, and the rates fit our budget.', 'sort_order' => 1],
            ['client_name' => 'Nia Keith', 'rating' => 5, 'quote' => 'Our office ships documents to clients outside Albany. First Class is quick, affordable and more dependable than our old courier.', 'sort_order' => 2],
            ['client_name' => 'Tony Garret', 'rating' => 5, 'quote' => 'UU Express carried equipment for our business to Syracuse. The driver was professional, careful, and arrived right when we expected.', 'sort_order' => 3],
            ['client_name' => 'John Pablo', 'rating' => 5, 'quote' => 'Our boarding facility books UU Express for pet pickups regularly. Owners love the service, and the animals always arrive comfortable.', 'sort_order' => 4],
            ['client_name' => 'Harry Parker', 'rating' => 5, 'quote' => 'Our client needed an urgent package across state lines. UU Express made the trip without delay and handled it professionally.', 'sort_order' => 5],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(
                ['client_name' => $t['client_name'], 'sort_order' => $t['sort_order']],
                $t
            );
        }
    }
}
