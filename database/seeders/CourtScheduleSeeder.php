<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\CourtSchedule;
use Illuminate\Database\Seeder;

class CourtScheduleSeeder extends Seeder
{
    public function run(): void
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

        foreach (Court::all() as $court) {
            foreach ($days as $day) {
                CourtSchedule::create([
                    'court_id' => $court->id,
                    'day' => $day,
                    'open_time' => '08:00',
                    'close_time' => '22:00',
                    'is_active' => true,
                ]);
            }
        }
    }
}
