<?php

namespace Database\Seeders;

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
    ];
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->names as $name) {
            Org::create(['name' => $name, 'building_id' => 1]);
        }
    }
}
