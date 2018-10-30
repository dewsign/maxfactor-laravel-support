<?php

namespace Maxfactor\Support\Model\Traits;

trait CanBeFeatured
{
    private $canBeFeaturedFillableFields = [
        'featured',
    ];

    private $canBeFeaturedCastFields = [
        'featured' => 'boolean',
    ];

    /**
     * Called by constructor
     * Load fillable and casts fields
     */
    public function initCanBeFeatured()
    {
        $this->fillable = array_merge($this->fillable, $this->canBeFeaturedFillableFields);
        $this->casts = array_merge($this->casts, $this->canBeFeaturedCastFields);
    }

    /**
     * Get only featured items
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->whereFeatured(true);
    }


    /**
     * Get all items which are not featured
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNotFeatured($query)
    {
        return $query->whereFeatured(false);
    }
}
