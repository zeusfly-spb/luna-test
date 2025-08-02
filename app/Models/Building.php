<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static where(string $string, mixed $name)
 * @method static create(array $array)
 * @method static select(string $string, string $string1, string $string2)
 */
class Building extends Model
{
    protected $guarded = [];
    protected $casts = [
        'location' => 'string',
    ];

    public function orgs(): HasMany
    {
        return $this->hasMany(Org::class);
    }
}
