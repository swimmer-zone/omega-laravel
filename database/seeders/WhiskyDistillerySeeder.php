<?php

namespace Database\Seeders;

use App\Models\WhiskyDistillery;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WhiskyDistillerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/distillery.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            $latitude = 0;
            $longitude = 0;

            if (!empty($item['coordinates']) && count($item['coordinates']) === 2) {
                $latitude = $item['coordinates'][0];
                $longitude = $item['coordinates'][1];
            }

            WhiskyDistillery::firstOrCreate([
                'name' => $item['name'],
            ], [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'marker_offset' => $item['markerOffset'],
            ]);
        }
    }
}
