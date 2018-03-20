<?php

namespace Maxfactor\Support\Webpage\Traits;

trait MustHaveCanonical
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appendsCanonicalFields = [
        'canonical',
    ];

    /**
     * Called by constructor to load appends fields.
     */
    public function initMustHaveCanonical()
    {
        $this->appends = array_merge($this->appends, $this->appendsCanonicalFields);
    }
}
