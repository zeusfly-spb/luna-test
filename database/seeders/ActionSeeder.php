<?php

namespace Database\Seeders;

use App\Models\Action;
use App\Models\Org;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    protected array $primary_actions = [
        ['name' => 'Еда'],
        ['name' => 'Автомобили'],
        ['name' => 'Химия'],
        ['name' => 'Мебель'],
    ];
    protected array $secondary_actions = [
        ['name' => 'Мясная продукция', 'parent' => 'Еда'],
        ['name' => 'Молочная продукция', 'parent' => 'Еда'],
        ['name' => 'Сельскохозяйственная продукция', 'parent' => 'Еда'],
        ['name' => 'Легковые автомобили', 'parent' => 'Автомобили'],
        ['name' => 'Грузовые автомобили', 'parent' => 'Автомобили'],
        ['name' => 'Спецтехника', 'parent' => 'Автомобили'],
        ['name' => 'Удобрения', 'parent' => 'Химия'],
        ['name' => 'Бытовая химия', 'parent' => 'Химия'],
        ['name' => 'Пиротехника', 'parent' => 'Химия'],
        ['name' => 'Шкафы', 'parent' => 'Мебель'],
        ['name' => 'Кухни', 'parent' => 'Мебель'],
        ['name' => 'Гарнитуры', 'parent' => 'Мебель'],
    ];
    protected array $tertiary_actions = [
        ['name' => 'Мясные консервы', 'parent' => 'Мясная продукция'],
        ['name' => 'Колбасы', 'parent' => 'Мясная продукция'],
        ['name' => 'Паштеты', 'parent' => 'Мясная продукция'],
        ['name' => 'Молоко', 'parent' => 'Молочная продукция'],
        ['name' => 'Кефиры', 'parent' => 'Молочная продукция'],
        ['name' => 'Сметана', 'parent' => 'Молочная продукция'],
        ['name' => 'Запчасти', 'parent' => 'Легковые автомобили'],
        ['name' => 'Аксессуары', 'parent' => 'Легковые автомобили'],
        ['name' => 'Шины', 'parent' => 'Легковые автомобили'],
        ['name' => 'Кузовные детали', 'parent' => 'Грузовые автомобили'],
        ['name' => 'Тенты', 'parent' => 'Грузовые автомобили'],
        ['name' => 'Компрессоры', 'parent' => 'Грузовые автомобили'],
        ['name' => 'Эвакуаторы', 'parent' => 'Спецтехника'],
        ['name' => 'Снегоуборщики', 'parent' => 'Спецтехника'],
        ['name' => 'Пестициды', 'parent' => 'Удобрения'],
        ['name' => 'Азотные удобрения', 'parent' => 'Удобрения'],
        ['name' => 'Калийные удобрения', 'parent' => 'Удобрения'],
        ['name' => 'Шампуни', 'parent' => 'Бытовая химия'],
        ['name' => 'Лаки', 'parent' => 'Бытовая химия'],
        ['name' => 'Освежители воздуха', 'parent' => 'Бытовая химия'],
        ['name' => 'Петарды', 'parent' => 'Пиротехника'],
        ['name' => 'Бомбочки', 'parent' => 'Пиротехника'],
        ['name' => 'Шутихи', 'parent' => 'Пиротехника'],
        ['name' => 'Кухонные шкафы', 'parent' => 'Шкафы'],
        ['name' => 'Шкафы для спальни', 'parent' => 'Шкафы'],
        ['name' => 'Аскетичные кухни', 'parent' => 'Кухни'],
        ['name' => 'Изысканные кухни', 'parent' => 'Кухни'],
        ['name' => 'Спальные гарнитуры', 'parent' => 'Гарнитуры'],
        ['name' => 'Детские гарнитуры', 'parent' => 'Гарнитуры'],
    ];
    protected $org_ids;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->org_ids = Org::get()->pluck('id');
        foreach ($this->primary_actions as $action) {
            if (!Action::where('name', $action['name'])->exists()) {
                $action = Action::create([
                    'name' => $action['name'],
                ]);
                $action->orgs()->attach($this->org_ids->random(rand(1, 3)));
            }
        }
        foreach ($this->secondary_actions as $action) {
            if (!Action::where('name', $action['name'])->exists()) {
                $action = Action::create([
                    'name' => $action['name'],
                    'parent_id' => Action::where('name', $action['parent'])->first()->id,
                ]);
                $action->orgs()->attach($this->org_ids->random(rand(1, 3)));
            }
        }
        foreach ($this->tertiary_actions as $action) {
            if (!Action::where('name', $action['name'])->exists()) {
                $action = Action::create([
                    'name' => $action['name'],
                    'parent_id' => Action::where('name', $action['parent'])->first()->id,
                ]);
                $action->orgs()->attach($this->org_ids->random(rand(1, 3)));
            }
        }
    }
}
