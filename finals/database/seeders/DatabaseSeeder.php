<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
        
        // Create regular user
        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
        
        // Create services
        $services = [
            [
                'name' => 'Traditional Filipino Massage',
                'description' => 'Experience the authentic hilot massage, a traditional Filipino healing technique that relieves muscle pain and improves blood circulation.',
                'price' => 1500,
                'duration' => 60,
            ],
            [
                'name' => 'Aromatherapy Massage',
                'description' => 'A relaxing massage using essential oils to promote healing and enhance well-being.',
                'price' => 1800,
                'duration' => 75,
            ],
            [
                'name' => 'Hot Stone Therapy',
                'description' => 'Smooth, heated stones are placed on specific points on the body to warm and relax tight muscles.',
                'price' => 2000,
                'duration' => 90,
            ],
            [
                'name' => 'Foot Reflexology',
                'description' => 'Pressure is applied to specific points on the feet to relieve stress and promote healing throughout the body.',
                'price' => 1200,
                'duration' => 45,
            ],
            [
                'name' => 'Full Body Scrub',
                'description' => 'Exfoliate your skin with natural ingredients to remove dead skin cells and reveal glowing, healthy skin.',
                'price' => 1700,
                'duration' => 60,
            ],
        ];

        foreach ($services as $serviceData) {
            Service::create($serviceData);
        }
        
        // Create sample bookings for the regular user
        $bookings = [
            [
                'user_id' => $user->id,
                'service_id' => 1,
                'appointment_date' => now()->addDays(2)->toDateString(),
                'appointment_time' => '10:00:00',
                'status' => 'pending',
                'notes' => 'First-time customer, please be gentle',
            ],
            [
                'user_id' => $user->id,
                'service_id' => 3,
                'appointment_date' => now()->addDays(5)->toDateString(),
                'appointment_time' => '14:30:00',
                'status' => 'confirmed',
                'notes' => 'Prefer female therapist if possible',
            ],
        ];
        
        foreach ($bookings as $bookingData) {
            Booking::create($bookingData);
        }
    }
}
