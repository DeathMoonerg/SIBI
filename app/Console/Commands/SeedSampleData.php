<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeedSampleData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:seed-sample';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed sample data for the application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🌱 Seeding Sample Data');
        $this->info('====================');
        
        // Seed school classes
        $this->info('Seeding school classes...');
        $this->seedSchoolClasses();
        
        // Seed teachers
        $this->info('Seeding teachers...');
        $this->seedTeachers();
        
        // Seed testimonials
        $this->info('Seeding testimonials...');
        $this->seedTestimonials();
        
        $this->info('');
        $this->info('✅ Sample data seeded successfully!');
        
        return 0;
    }
    
    /**
     * Seed school classes data.
     */
    private function seedSchoolClasses()
    {
        $classes = [
            [
                'name' => 'Program PAUD',
                'slug' => 'program-paud',
                'description' => 'Program pembelajaran untuk anak usia PAUD dengan fokus pada pengembangan motorik dan kognitif dasar.',
                'age_range' => '3-4 tahun',
                'capacity' => 15,
                'fee' => 300000,
                'schedule' => 'Senin & Rabu, 08:00 - 10:00',
                'image' => 'img/class-1.jpg',
                'is_popular' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Program TK A',
                'slug' => 'program-tk-a',
                'description' => 'Program untuk anak usia TK A dengan fokus pada pengenalan huruf dan angka.',
                'age_range' => '4-5 tahun',
                'capacity' => 15,
                'fee' => 350000,
                'schedule' => 'Senin & Rabu, 10:00 - 12:00',
                'image' => 'img/class-2.jpg',
                'is_popular' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Program TK B',
                'slug' => 'program-tk-b',
                'description' => 'Program untuk anak usia TK B dengan fokus pada persiapan masuk SD.',
                'age_range' => '5-6 tahun',
                'capacity' => 15,
                'fee' => 400000,
                'schedule' => 'Selasa & Kamis, 08:00 - 10:00',
                'image' => 'img/class-3.jpg',
                'is_popular' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'SD Kelas 1-3',
                'slug' => 'sd-kelas-1-3',
                'description' => 'Program bimbingan untuk anak SD kelas 1-3 dengan fokus pada matematika dan bahasa.',
                'age_range' => '6-9 tahun',
                'capacity' => 12,
                'fee' => 450000,
                'schedule' => 'Senin & Rabu, 13:00 - 15:00',
                'image' => 'img/class-4.jpg',
                'is_popular' => false,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'SD Kelas 4-6',
                'slug' => 'sd-kelas-4-6',
                'description' => 'Program bimbingan untuk anak SD kelas 4-6 dengan persiapan ujian dan materi lanjutan.',
                'age_range' => '9-12 tahun',
                'capacity' => 12,
                'fee' => 500000,
                'schedule' => 'Selasa & Kamis, 13:00 - 15:00',
                'image' => 'img/class-5.jpg',
                'is_popular' => false,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        
        foreach ($classes as $class) {
            DB::table('school_classes')->insertOrIgnore($class);
        }
        
        $this->info('Added ' . count($classes) . ' school classes');
    }
    
    /**
     * Seed teachers data.
     */
    private function seedTeachers()
    {
        $teachers = [
            [
                'name' => 'Anisa Rahmawati',
                'position' => 'Guru PAUD & TK',
                'bio' => 'Berpengalaman mengajar anak usia dini selama 5 tahun dengan pendekatan belajar sambil bermain.',
                'image' => 'img/teacher-1.jpg',
                'facebook' => 'https://facebook.com/',
                'twitter' => 'https://twitter.com/',
                'instagram' => 'https://instagram.com/',
                'linkedin' => null,
                'is_popular' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Budi Santoso',
                'position' => 'Guru Matematika SD',
                'bio' => 'Lulusan pendidikan matematika dengan pendekatan mengajar yang menyenangkan untuk anak SD.',
                'image' => 'img/teacher-2.jpg',
                'facebook' => 'https://facebook.com/',
                'twitter' => 'https://twitter.com/',
                'instagram' => 'https://instagram.com/',
                'linkedin' => null,
                'is_popular' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Citra Dewi',
                'position' => 'Guru Bahasa Inggris',
                'bio' => 'Berpengalaman mengajar bahasa Inggris untuk anak-anak dengan metode komunikatif.',
                'image' => 'img/teacher-3.jpg',
                'facebook' => 'https://facebook.com/',
                'twitter' => 'https://twitter.com/',
                'instagram' => 'https://instagram.com/',
                'linkedin' => null,
                'is_popular' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        
        foreach ($teachers as $teacher) {
            DB::table('teachers')->insertOrIgnore($teacher);
        }
        
        $this->info('Added ' . count($teachers) . ' teachers');
        
        // Buat user untuk guru-guru tersebut
        foreach ($teachers as $index => $teacher) {
            $email = strtolower(str_replace(' ', '.', $teacher['name'])) . '@example.com';
            
            DB::table('users')->insertOrIgnore([
                'name' => $teacher['name'],
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'teacher',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        $this->info('Added ' . count($teachers) . ' teacher users');
    }
    
    /**
     * Seed testimonials data.
     */
    private function seedTestimonials()
    {
        $testimonials = [
            [
                'name' => 'Ibu Siti Rahmah',
                'role' => 'Orang Tua dari Faiz (TK B)',
                'content' => 'Sejak belajar di Bimbel Alfarizqi, anak saya mengalami kemajuan yang luar biasa dalam membaca dan berhitung. Guru yang datang ke rumah sangat sabar dan profesional. Saya sangat merekomendasikan untuk anak usia TK dan SD awal.',
                'avatar' => 'img/testimonial-1.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Bapak Andi',
                'role' => 'Orang Tua dari Dimas (SD Kelas 3)',
                'content' => 'Nilai matematika anak saya naik drastis setelah belajar dengan tutor dari Bimbel Alfarizqi. Metode mengajarnya sangat menyesuaikan dengan kebutuhan anak saya. Selain itu, bisa memantau perkembangan belajar melalui SIBI sangat membantu.',
                'avatar' => 'img/testimonial-2.jpg',
                'rating' => 5,
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Ibu Maya',
                'role' => 'Orang Tua dari Nayla (TK A)',
                'content' => 'Anak saya yang tadinya tidak bisa membaca sama sekali, sekarang sudah mulai lancar membaca setelah 3 bulan belajar di Bimbel Alfarizqi. Guru-gurunya sangat sabar dan punya teknik mengajar yang membuat anak saya senang belajar.',
                'avatar' => 'img/testimonial-3.jpg',
                'rating' => 4,
                'is_active' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];
        
        foreach ($testimonials as $testimonial) {
            DB::table('testimonials')->insertOrIgnore($testimonial);
        }
        
        $this->info('Added ' . count($testimonials) . ' testimonials');
        
        // Buat user untuk orang tua
        foreach ($testimonials as $index => $testimonial) {
            $name = explode(' ', $testimonial['name'])[1]; // Ambil nama kedua saja (tanpa Ibu/Bapak)
            $email = strtolower($name) . '@example.com';
            
            DB::table('users')->insertOrIgnore([
                'name' => $testimonial['name'],
                'email' => $email,
                'password' => bcrypt('password'),
                'role' => 'parent',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        $this->info('Added ' . count($testimonials) . ' parent users');
    }
} 