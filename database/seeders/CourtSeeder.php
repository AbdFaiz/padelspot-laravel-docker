<?php

namespace Database\Seeders;

use App\Models\Court;
use Illuminate\Database\Seeder;

class CourtSeeder extends Seeder
{
    public function run(): void
    {
        Court::create(['name' => 'Lapangan A', 'description' => 'Lapangan indoor standar nasional', 'price_per_hour' => 150000, 'status' => 'available']);
        Court::create(['name' => 'Lapangan B', 'description' => 'Lapangan indoor dengan pencahayaan premium', 'price_per_hour' => 200000, 'status' => 'available']);
        Court::create(['name' => 'Lapangan C', 'description' => 'Lapangan outdoor dengan pemandangan alam', 'price_per_hour' => 250000, 'status' => 'available']);
    }
}
