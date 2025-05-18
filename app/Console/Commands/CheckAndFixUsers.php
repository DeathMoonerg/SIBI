<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CheckAndFixUsers extends Command
{
    protected $signature = 'users:check-fix';
    protected $description = 'Check and fix user accounts';

    public function handle()
    {
        $this->info('Checking user accounts...');

        // Check if users exist
        $admin = DB::table('users')->where('email', 'admin@bimbelalfarizqi.com')->first();
        $parent = DB::table('users')->where('email', 'ortu@bimbelalfarizqi.com')->first();
        $teacher = DB::table('users')->where('email', 'guru@bimbelalfarizqi.com')->first();

        // Delete existing users if they exist
        DB::table('users')->whereIn('email', [
            'admin@bimbelalfarizqi.com',
            'ortu@bimbelalfarizqi.com',
            'guru@bimbelalfarizqi.com'
        ])->delete();

        // Create users
        DB::table('users')->insert([
            [
                'name' => 'Admin SIBI',
                'email' => 'admin@bimbelalfarizqi.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
                'address' => 'Jl. Admin No. 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Orang Tua SIBI',
                'email' => 'ortu@bimbelalfarizqi.com',
                'password' => Hash::make('password123'),
                'role' => 'parent',
                'phone' => '081234567891',
                'address' => 'Jl. Orang Tua No. 1',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Guru SIBI',
                'email' => 'guru@bimbelalfarizqi.com',
                'password' => Hash::make('password123'),
                'role' => 'teacher',
                'phone' => '081234567892',
                'address' => 'Jl. Guru No. 1',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        $this->info('Users have been recreated with the following credentials:');
        $this->info('Admin: admin@bimbelalfarizqi.com / password123');
        $this->info('Parent: ortu@bimbelalfarizqi.com / password123');
        $this->info('Teacher: guru@bimbelalfarizqi.com / password123');
    }
} 
 
 
 
 
 
 