<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Traditional Filipino Massage',
                'description' => 'Experience the authentic hilot massage, a traditional Filipino healing technique that relieves muscle pain and improves blood circulation.',
                'price' => 1500,
                'duration_minutes' => 60,
                'is_available' => true,
            ],
            [
                'name' => 'Aromatherapy Massage',
                'description' => 'A relaxing massage using essential oils to promote healing and enhance well-being.',
                'price' => 1800,
                'duration_minutes' => 75,
                'is_available' => true,
            ],
            [
                'name' => 'Hot Stone Therapy',
                'description' => 'Smooth, heated stones are placed on specific points on the body to warm and relax tight muscles.',
                'price' => 2000,
                'duration_minutes' => 90,
                'is_available' => true,
            ],
            [
                'name' => 'Foot Reflexology',
                'description' => 'Pressure is applied to specific points on the feet to relieve stress and promote healing throughout the body.',
                'price' => 1200,
                'duration_minutes' => 45,
                'is_available' => true,
            ],
            [
                'name' => 'Full Body Scrub',
                'description' => 'Exfoliate your skin with natural ingredients to remove dead skin cells and reveal glowing, healthy skin.',
                'price' => 1700,
                'duration_minutes' => 60,
                'is_available' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
