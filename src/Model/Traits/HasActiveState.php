<?php

namespace Maxfactor\Support\Model\Traits;

use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

trait HasActiveState
{
    private $hasActiveStateFillableFields = [
        'active',
    ];

    private $hasActiveStateCastFields = [
        'active' => 'boolean',
    ];

    /**
     * Called by constructor
     * Load fillable and casts fields
     */
    public function initHasActiveState()
    {
        $this->fillable = array_merge($this->fillable, $this->hasActiveStateFillableFields);
        $this->casts = array_merge($this->casts, $this->hasActiveStateCastFields);
        View::macro('whenActive', function ($model) {
            abort_if(Gate::denies('viewInactive', $model), 503);
            return $this;
        });
    }

    /**
     * Get only active items
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('active', '=', 1);
    }


    /**
     * Get all items which are not active (as a result, inactive)
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInactive($query)
    {
        return $query->where('active', '!=', 1);
    }
}
