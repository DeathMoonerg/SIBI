<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Julia Smith',
                'position' => 'Music Teacher',
                'image' => 'img/team-1.jpg',
                'facebook_url' => 'https://facebook.com',
                'twitter_url' => 'https://twitter.com',
                'instagram_url' => 'https://instagram.com',
                'description' => 'Music teacher with over 10 years of experience.',
                'is_popular' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'John Doe',
                'position' => 'Art Teacher',
                'image' => 'img/team-2.jpg',
                'facebook_url' => 'https://facebook.com',
                'twitter_url' => 'https://twitter.com',
                'instagram_url' => 'https://instagram.com',
                'description' => 'Specializes in teaching art to young children.',
                'is_popular' => true,
                'sort_order' => 2,
            ],
            [
                'name' => 'Mollie Ross',
                'position' => 'Dance Teacher',
                'image' => 'img/team-3.jpg',
                'facebook_url' => 'https://facebook.com',
                'twitter_url' => 'https://twitter.com',
                'instagram_url' => 'https://instagram.com',
                'description' => 'Professional dancer who loves teaching kids.',
                'is_popular' => true,
                'sort_order' => 3,
            ],
        ];

        foreach ($teachers as $teacher) {
            Teacher::create($teacher);
        }

        User::create([
            'name' => 'Guru Bimbel',
            'email' => 'guru@bimbelalfarizqi.com',
            'password' => Hash::make('guru123'),
            'role' => 'teacher',
            'email_verified_at' => now(),
        ]);
    }
}