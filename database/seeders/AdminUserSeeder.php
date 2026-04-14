<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Make the first user an admin
        $user = User::first();
        if ($user) {
            $user->update(['is_admin' => true]);
            $this->command->info('First user is now an admin.');
        } else {
            // Create a new admin user if no users exist
            User::create([
                'name' => 'Admin User',
                'email' => 'info@tangerinefurniture.co.ke',
                'password' => bcrypt('Password@123'),
                'is_admin' => true,
            ]);
            $this->command->info('Admin user created: info@tangerinefurniture.co.ke / Password@123');
        }
    }
} 