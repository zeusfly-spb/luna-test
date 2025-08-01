<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $array)
 * @method static where(string $string, mixed $number)
 */
class Phone extends Model
{
    protected $guarded = [];

    public function org(): BelongsTo
    {
        return $this->belongsTo(Org::class);
    }
}
