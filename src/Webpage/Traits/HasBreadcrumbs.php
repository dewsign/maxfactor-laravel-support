<?php

namespace Maxfactor\Support\Webpage\Traits;

trait HasBreadcrumbs
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appendsBreadcrumbFields = [
        'breadcrumbs',
    ];

    /**
     * Called by constructor to load appends fields.
     */
    public function initHasBreadcrumbs()
    {
        $this->appends = array_merge($this->appends, $this->appendsBreadcrumbFields);
    }

    /**
     * Provides the breadcrumb for the front-end to render
     *
     * @return void
     */
    public function seed()
    {
        return collect([
            [
                'name' => 'Home',
                'url' => '/'
            ],
        ]);
    }

    public function getBreadcrumbsAttribute()
    {
        return $this->seed()->all();
    }
}
