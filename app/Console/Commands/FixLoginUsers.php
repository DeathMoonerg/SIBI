<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FixLoginUsers extends Command
{
    protected $signature = 'users:fix-login';
    protected $description = 'Fix login users by resetting their passwords';

    public function handle()
    {
        $this->info('Checking and fixing login users...');

        // The default password hash that works
        $password = Hash::make('password123');

        // Update all three users with the working password
        DB::table('users')
            ->whereIn('email', [
                'admin@bimbelalfarizqi.com',
                'ortu@bimbelalfarizqi.com',
                'guru@bimbelalfarizqi.com'
            ])
            ->update([
                'password' => $password,
                'updated_at' => now()
            ]);

        $this->info('Users have been updated with the following credentials:');
        $this->info('Admin: admin@bimbelalfarizqi.com / password123');
        $this->info('Parent: ortu@bimbelalfarizqi.com / password123');
        $this->info('Teacher: guru@bimbelalfarizqi.com / password123');
    }
} 
 
 
 
 
 
 