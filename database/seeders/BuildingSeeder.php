<?php

namespace Database\Seeders;

use App\Models\Building;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    protected array $buildings = [
        ['name' => 'Башня Федерация', 'address' => 'г. Москва, Пресненская наб., 12', 'lat' => 55.7498, 'lng' => 37.5377],
        ['name' => 'БЦ "Белая Площадь"', 'address' => 'г. Москва, ул. Лесная, 7', 'lat' => 55.7779, 'lng' => 37.5831],
        ['name' => 'БЦ "Омега Плаза"', 'address' => 'г. Москва, ул. Ленинская Слобода, 19', 'lat' => 55.7085, 'lng' => 37.6548],
        ['name' => 'БЦ "Сенатор"', 'address' => 'г. Санкт-Петербург, ул. Чапыгина, 6А', 'lat' => 59.9726, 'lng' => 30.3052],
        ['name' => 'БЦ "Лето"', 'address' => 'г. Санкт-Петербург, Пулковское шоссе, 30', 'lat' => 59.8122, 'lng' => 30.3090],
        ['name' => 'БЦ "Петровский"', 'address' => 'г. Санкт-Петербург, Петровская коса, 1', 'lat' => 59.9568, 'lng' => 30.2711],
        ['name' => 'БЦ "Атлантик Сити"', 'address' => 'г. Санкт-Петербург, ул. Савушкина, 126', 'lat' => 59.9852, 'lng' => 30.1951],

    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->buildings as $data) {
            if (!Building::where('name', $data['name'])->exists()) {
                $lat = $data['lat'] ?? 0;
                $lng = $data['lng'] ?? 0;
                $building = Building::create([
                    'name' => $data['name'],
                    'address' => $data['address'],
                    'location' => DB::raw("ST_GeomFromText('POINT(0 0)')"),
                ]);
                DB::statement("UPDATE buildings SET location = ST_GeomFromText('POINT($lng $lat)') WHERE id = ?", [$building->id]);
            }
        }
    }
}
