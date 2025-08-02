<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static create(array $array)
 * @method static get()
 * @method static where(string $string, mixed $name)
 * @method static find(string $id)
 * @method static whereHas(string $string, \Closure $param)
 */
class Org extends Model
{
    protected $guarded = [];

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function actions(): BelongsToMany
    {
        return $this->belongsToMany(Action::class);
    }
}
