<?php

namespace Database\Seeders;

use App\Models\VisitedCountry;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class VisitedCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/visited-countries.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            VisitedCountry::firstOrCreate([
                'name' => $item,
            ]);
        }
    }
}
