<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static get()
 * @method static where(string $string, mixed $name)
 */
class Org extends Model
{
    protected $guarded = [];

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }
}
