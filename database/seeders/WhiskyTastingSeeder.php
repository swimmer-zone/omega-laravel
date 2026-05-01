<?php

namespace Database\Seeders;

use App\Models\WhiskyTasting;
use App\Models\WhiskyCaskType;
use App\Models\WhiskyCountry;
use App\Models\WhiskyRegion;
use App\Models\WhiskyType;
use App\Models\WhiskyFinish;
use App\Models\WhiskyColor;
use App\Models\WhiskyFlavour;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class WhiskyTastingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = File::get(database_path('data/tasting.json'));
        $data = json_decode($json, true);

        foreach ($data as $item) {
            $country = WhiskyCountry::firstOrCreate(['name' => $item['country']]);

            $region = !empty($item['region'])
                ? WhiskyRegion::firstOrCreate(['name' => $item['region']])
                : null;

            $type = !empty($item['type'])
                ? WhiskyType::firstOrCreate(['name' => $item['type']])
                : null;

            $cask_type = !empty($item['cask_type'])
                ? WhiskyCaskType::firstOrCreate(['name' => $item['cask_type']])
                : null;

            $finish = !empty($item['finish'])
                ? WhiskyFinish::firstOrCreate(['name' => $item['finish']])
                : null;

            $color = !empty($item['color'])
                ? WhiskyColor::firstOrCreate(['name' => $item['color']])
                : null;

            $tasting = WhiskyTasting::updateOrCreate([
                'brand' => $item['brand'],
                'name' => $item['name'],
                'age' => $item['age'],
                'strength' => $item['strength'],
                'whisky_country_id' => $country->id,
                'whisky_region_id' => $region?->id,
                'whisky_distillery_id' => $item['distillery_id'],
                'whisky_type_id' => $type?->id,
                'whisky_cask_type_id' => $cask_type?->id,
                'whisky_finish_id' => $finish?->id,
                'notes' => $item['notes'],
                'rating' => $item['rating'],
                'would_buy' => $item['tasting_would_buy'],
                'date_of_tasting' => $item['date_of_tasting'],
                'location' => $item['location'],
                'url' => $item['url'],
                'glance' => $item['glance'],
                'whisky_color_id' => $color?->id,
            ]);

            $flavourIds = collect(explode(',', $item['flavour'] ?? ''))
                ->map(fn (string $name) => trim($name))
                ->filter()
                ->map(function (string $name) {
                    return WhiskyFlavour::firstOrCreate([
                        'name' => $name,
                    ])->id;
                })
                ->all();

            $tasting->whisky_flavours()->sync($flavourIds);
        }
    }
}
