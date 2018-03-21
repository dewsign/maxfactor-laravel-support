<?php

namespace Maxfactor\Support\Webpage\Traits;

use Illuminate\Database\Eloquent\Builder;

/**
 * Allow any model to have nested Parents. This will handle the validating and generating of
 * full nested slug paths.
 *
 * The model must have a `parent()` method.
 *
 * To filter specific folders to be removed when working with sub-domains, populate a protected
 * array attribute on the model named `$domainMappedFolders`.
 */
trait HasParent
{
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appendsParentFields = [
        'full_path',
    ];

    /**
     * Called by constructor to load appends fields.
     */
    public function initHasParent()
    {
        $this->appends = array_merge($this->appends, $this->appendsParentFields);
    }

    /**
     * Impose requirements upon the exhibiting class.
     */
    abstract public function parent();
    abstract public function children();

    /**
     * Get full path.
     *
     * @return string Full path
     */
    protected function getFullPath($item = null)
    {
        if (!$item) {
            $item = $this;
        }

        if (!$parent = $item->parent) {
            return str_start($item->slug, '/');
        }

        return str_start(sprintf('%s%s', $this->getFullPath($parent), str_start($item->slug, '/')), '/');
    }

    /**
     * Get root slug.
     *
     * @return string Root slug
     */
    public function getRootSlug()
    {
        $pathSections = explode('/', $this->getFullPath());

        return collect($pathSections)->filter()->first();
    }

    /**
     * Add full path attribute.
     *
     * @return string Full path
     */
    public function getFullPathAttribute()
    {
        $pathSections = explode('/', $this->getFullPath());

        $slugsToExclude = array_wrap($this->domainMappedFolders);

        $finalSlug = collect($pathSections)
            ->filter()
            ->reject(function ($slug) use ($slugsToExclude) {
                return in_array($slug, $slugsToExclude);
            })
            ->implode('/');

        return str_start($finalSlug, '/');
    }

    /**
     * Lazy-load parent items
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeWithParent(Builder $query)
    {
        return $query->with('parent');
    }

    /**
     * Scope a query to eager load `children`
     * relationship to reduce database queries.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithChildren(Builder $query)
    {
        return $query->with('children');
    }

    /**
     * Filter the model to only show items which match the full path
     *
     * @param Builder $query
     * @param string $path
     * @return Builder
     */
    public function scopeWhereFullPath(Builder $query, string $path)
    {
        $itemSlugs = explode('/', $path);

        return $query->where('slug', '=', end($itemSlugs))
            ->get()
            ->filter(function ($item) use ($path) {
                return $item->full_path === str_start($path, '/');
            });
    }
}
