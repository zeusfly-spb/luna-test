<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $name)
 * @method static create(array $array)
 */
class Building extends Model
{
    protected $guarded = [];
    protected $casts = [
        'location' => 'string',
    ];
}
