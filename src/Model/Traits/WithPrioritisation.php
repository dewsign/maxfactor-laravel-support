<?php

namespace Maxfactor\Support\Model\Traits;

trait WithPrioritisation
{
    private $withPrioritisationFields = [
        'priority',
    ];

    /**
     * Called by constructor
     * Load fillable fields
     */
    public function initWithPrioritisation()
    {
        $this->fillable = array_merge($this->fillable, $this->withPrioritisationFields);
    }

    /**
     * Order by highest priority first
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHighToLow($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    /**
     * Order by lowest priority first
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLowToHigh($query)
    {
        return $query->orderBy('priority', 'asc');
    }
}
