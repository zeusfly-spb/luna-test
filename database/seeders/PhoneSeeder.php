<?php

namespace Database\Seeders;

use App\Models\Org;
use App\Models\Phone;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhoneSeeder extends Seeder
{
    protected array $numbers = [
        '1111111',
        '2222222',
        '3333333',
        '4444444',
        '9991112233',
        '9552223344',
        '9773334455',
        '9224347088',
        '9334047788',
        '9444447708',
        '9554407788',
        '9664447780',
        '9774440788',
        '9884417788',
        '9004007700',
    ];
    protected array $org_ids;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->org_ids = Org::get()->pluck('id')->toArray();
        foreach ($this->numbers as $number) {
            if (!Phone::where('number', $number)->exists()) {
                Phone::create([
                    'number' => $number,
                    'org_id' => $this->org_ids[array_rand($this->org_ids)],
                ]);
            }
        }
    }
}
