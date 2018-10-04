<?php

namespace Maxfactor\Support\Model\Traits;

use Spatie\EloquentSortable\SortableTrait;

trait HasSortOrder
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'sort_order',
        'sort_when_creating' => true,
    ];

    private $hasSortOrderFillableFields = [
        'sort_order',
    ];

    private $hasSortOrderCastFields = [
        'sort_order' => 'integer',
    ];

    /**
     * Called by constructor
     * Load fillable and casts fields
     */
    public function initHasSortOrder()
    {
        $this->fillable = array_merge($this->fillable, $this->hasSortOrderFillableFields);
        $this->casts = array_merge($this->casts, $this->hasSortOrderCastFields);
    }
}
