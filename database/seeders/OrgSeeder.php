<?php

namespace Database\Seeders;

use App\Models\Building;
use App\Models\Org;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrgSeeder extends Seeder
{
    protected array $names = [
        'Рога и копыта',
        'Золотые ворота',
        'Спецоблтранс',
        'Молочные берега',
        'Мясо и хлеб',
        'Химзавод им. Луначарского',
        'СпецАгроПром',
        'Завод Москвич',
        'Завод ЗИЛ',
        'Автосалон Заря',
        'Хлебзавод Вкуснятина',
        'Совхоз Банановый',
        'Молкомбинат Буренка',
        'Автосалон Скорость',
    ];
    protected array $building_ids;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->building_ids = Building::get()->pluck('id')->toArray();
        foreach ($this->names as $name) {
            if (!Org::where('name', $name)->exists()) {
                Org::create([
                    'name' => $name,
                    'building_id' => $this->building_ids[array_rand($this->building_ids)],
                ]);
            }
        }
    }
}
