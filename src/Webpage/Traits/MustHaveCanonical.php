<?php

namespace Maxfactor\Support\Webpage\Traits;

trait MustHaveCanonical
{
    public $canonicalUrl;

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

    /**
     * Specify the canonical url for this instance of the model
     *
     * @param string $url
     * @return self
     */
    public function canonical(string $url)
    {
        $this->canonicalUrl = $url;

        return $this;
    }

    /**
     * Return the canonical URL to be rendered in the browser
     *
     * @return string
     */
    public function getCanonicalAttribute()
    {
        if ($canonical = $this->canonicalUrl) {
            return $canonical;
        }

        if (method_exists($this, 'baseCanonical')) {
            return $this->baseCanonical();
        }

        return url()->current();
    }
}
