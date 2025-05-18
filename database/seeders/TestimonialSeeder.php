<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'John Parker',
                'client_profession' => 'Engineer',
                'testimonial_text' => 'Tempor stet labore dolor clita stet diam amet ipsum dolor duo ipsum rebum stet dolor amet diam stet. Est stet ea lorem amet est kasd kasd erat eos.',
                'client_image' => 'img/testimonial-1.jpg',
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Sarah Johnson',
                'client_profession' => 'Designer',
                'testimonial_text' => 'Tempor stet labore dolor clita stet diam amet ipsum dolor duo ipsum rebum stet dolor amet diam stet. Est stet ea lorem amet est kasd kasd erat eos.',
                'client_image' => 'img/testimonial-2.jpg',
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Michael Clark',
                'client_profession' => 'Manager',
                'testimonial_text' => 'Tempor stet labore dolor clita stet diam amet ipsum dolor duo ipsum rebum stet dolor amet diam stet. Est stet ea lorem amet est kasd kasd erat eos.',
                'client_image' => 'img/testimonial-3.jpg',
                'is_active' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
