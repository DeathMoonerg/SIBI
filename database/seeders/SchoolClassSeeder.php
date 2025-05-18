<?php

namespace Database\Seeders;

use App\Models\SchoolClass;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classes = [
            [
                'name' => 'Art & Drawing',
                'image' => 'img/classes-1.jpg',
                'description' => 'Learn art and drawing fundamentals in a fun environment.',
                'price' => 99,
                'age_range' => '3-5 Years',
                'class_time' => '9-10 AM',
                'capacity' => 30,
                'teacher_id' => 2, // John Doe
                'is_popular' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Color Management',
                'image' => 'img/classes-2.jpg',
                'description' => 'Explore colors and learn about color theory through fun activities.',
                'price' => 99,
                'age_range' => '3-5 Years',
                'class_time' => '10-11 AM',
                'capacity' => 30,
                'teacher_id' => 2, // John Doe
                'is_popular' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Athletic & Dance',
                'image' => 'img/classes-3.jpg',
                'description' => 'Develop motor skills through dancing and athletic exercises.',
                'price' => 99,
                'age_range' => '4-6 Years',
                'class_time' => '1-2 PM',
                'capacity' => 30,
                'teacher_id' => 3, // Mollie Ross
                'is_popular' => true,
                'sort_order' => 3,
            ],
            [
                'name' => 'Music & Singing',
                'image' => 'img/classes-4.jpg',
                'description' => 'Introduction to music fundamentals and singing.',
                'price' => 99,
                'age_range' => '3-6 Years',
                'class_time' => '2-3 PM',
                'capacity' => 30,
                'teacher_id' => 1, // Julia Smith
                'is_popular' => false,
                'sort_order' => 4,
            ],
        ];

        foreach ($classes as $class) {
            SchoolClass::create($class);
        }
    }
}
