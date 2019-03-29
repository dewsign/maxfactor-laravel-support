<?php

namespace Maxfactor\Support\Webpage\Traits;

trait HasBreadcrumbs
{
    public $crumbs;

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
     * Overload this method to provide specific breadcrumb seeds. Merge with parent is required.
     *
     * @return array
     */
    public function seeds()
    {
        return [[
            'name' => config('maxfactor-support.defaultBreadcrumb', config('app.url')),
            'url' => config('app.url'),
        ]];
    }

    /**
     * Push additional breadcrumbs atop of those specified in the seeds() method
     *
     * @return self
     */
    public function seed($name = null, $url = null, $status = null)
    {
        if (!$this->crumbs) {
            $this->crumbs = collect([]);
        }

        if ($name && $url) {
            $this->crumbs->push([
                'name' => $name,
                'url' => $url,
                'status' => $status,
            ]);
        }

        return $this;
    }

    /**
     * Return the merged breadcrumbs from the seeds() and any additional crumbs pushed in.
     *
     * @return array
     */
    public function getBreadcrumbsAttribute()
    {
        return collect($this->seeds())->merge($this->crumbs)->all();
    }
}
