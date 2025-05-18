<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('teachers')->insert([
            [
                'name' => 'Dewi Kusuma',
                'email' => 'dewi.kusuma@bimbelsibi.com',
                'phone' => '081234567890',
                'position' => 'Guru Matematika',
                'bio' => 'Berpengalaman mengajar matematika selama 5 tahun dengan metode yang menyenangkan.',
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Rudi Hartono',
                'email' => 'rudi.hartono@bimbelsibi.com',
                'phone' => '081234567891',
                'position' => 'Guru Bahasa Inggris',
                'bio' => 'Lulusan S2 Pendidikan Bahasa Inggris dengan pengalaman mengajar 7 tahun.',
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Rahayu',
                'email' => 'siti.rahayu@bimbelsibi.com',
                'phone' => '081234567892',
                'position' => 'Guru IPA',
                'bio' => 'Spesialis dalam mengajar IPA dengan metode praktik dan eksperimen yang menarik.',
                'is_active' => true,
                'is_popular' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
