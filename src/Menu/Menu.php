<?php

namespace CubeAgency\ArboryMenu\Menu;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Menu extends Model
{
    /**
     * @var string
     */
    protected $table = 'menus';

    /**
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->name;
    }

    /**
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class)->orderBy("position");
    }

    /**
     * @return Collection
     */
    public function getPreparedItems(): Collection
    {
        return app()->makeWith(MenuFactory::class, ['menu' => $this])->build();
    }
}
