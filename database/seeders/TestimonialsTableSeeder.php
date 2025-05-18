<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestimonialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('testimonials')->insert([
            [
                'name' => 'Ahmad Fauzi',
                'role' => 'Orang Tua Murid',
                'content' => 'Anak saya sangat senang belajar di sini. Gurunya sangat sabar dan metode pembelajarannya menyenangkan.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Siti Aminah',
                'role' => 'Orang Tua Murid',
                'content' => 'Perkembangan anak saya sangat pesat sejak bergabung dengan Bimbel SIBI. Terima kasih!',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Budi Santoso',
                'role' => 'Orang Tua Murid',
                'content' => 'Program bimbingan yang sangat bagus dan terstruktur. Anak saya jadi lebih percaya diri.',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
