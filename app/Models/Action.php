<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @method static where(string $string, mixed $name)
 * @method static create(array|string[] $array)
 * @method static get()
 * @method static find(string $id)
 * @property mixed $children
 */
class Action extends Model
{
    protected $guarded = [];


    public function orgs(): BelongsToMany
    {
        return $this->belongsToMany(Org::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Action::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Action::class, 'parent_id')->with('children');
    }

    public function allDescendants(): Collection
    {
        $descendants = collect();
        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->allDescendants());
        }
        return $descendants;
    }

    public function descendantOrgs()
    {
        $descendants = $this->allDescendants();
        return Org::whereHas('actions', function ($query) use ($descendants) {
            $query->whereIn('actions.id', $descendants->pluck('id'));
        })->get();
    }
}
