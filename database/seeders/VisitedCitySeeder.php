<?php

namespace Database\Seeders;

use App\Models\VisitedCity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class VisitedCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $files = [
            'assorted',
            'aurora',
            'boom',
            'cape-verde',
            'europe',
            'georgia',
            'iceland',
            'italy',
            'scandinavia',
            'thailand',
            'uk',
            'vietnam'
        ];

        foreach ($files as $file) {
        	$data = json_decode(File::get(database_path('data/' . $file . '.json')), true);

        	foreach ($data as $item) {
                $latitude = 0;
                $longitude = 0;

                if (!empty($item['coordinates']) && count($item['coordinates']) === 2) {
                    $latitude = $item['coordinates'][1];
                    $longitude = $item['coordinates'][0];
                }

                VisitedCity::firstOrCreate([
                    'name' => $item['name'],
                ], [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'annotation' => $item['annotation'],
                ]);
        	}
        }
    }
}
