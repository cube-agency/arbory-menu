<?php

namespace CubeAgency\ArboryMenu\Menu;

use Arbory\Base\Content\Relation;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    /**
     * @var string
     */
    protected $table = 'menu_items';

    /**
     * @var array
     */
    protected $fillable = [
        'menu_id',
        'position'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function owner()
    {
        return $this->morphTo();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\morphOne
     */
    public function relation()
    {
        return $this->morphOne(Relation::class, 'owner');
    }
}