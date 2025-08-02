<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static where(string $string, mixed $name)
 * @method static create(array|string[] $array)
 * @method static get()
 * @method static find(string $id)
 */
class Action extends Model
{
    protected $guarded = [];

    public function orgs(): BelongsTo
    {
        return $this->belongsTo(Org::class, 'org_id');
    }
}
