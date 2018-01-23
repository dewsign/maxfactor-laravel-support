<?php

namespace Maxfactor\Support\Webpage\Traits;

trait HasContent
{
    protected $content;

        /**
     * Filter one or more keys of the items collection for a given value.
     * Setting the exclude flag will reverse the filter condition
     *
     * @param string|array $keys
     * @param string $value
     * @param bool $exclude
     * @return Model
     */
    protected function filter($keys, string $value, bool $exclude = false)
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        $this->content['items'] = collect($this->content['items'])
            ->filter(function ($item) use ($keys, $value, $exclude) {
                return (bool)collect($keys)->filter(function ($key) use ($item, $value, $exclude) {
                    if (array_key_exists($key, $item)) {
                        $itemContainsValue = collect($item[$key])->contains($value);

                        if ($exclude) {
                            return !$itemContainsValue;
                        }

                        return $itemContainsValue;
                    }
                })->count();
            });

        return $this;
    }

    /**
     * Allows for filtering of related arrays by supplying an additional filter
     * key so check if that key contains a specific value.
     *
     * @param string|array $keys
     * @param string $filterKey
     * @param string $value
     * @param bool $exclude
     * @return Model
     */
    protected function filterWith($keys, string $filterKey, string $value, bool $exclude = false)
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        $this->content['items'] = collect($this->content['items'])
            ->filter(function ($item) use ($keys, $filterKey, $value, $exclude) {
                return (bool)collect($keys)->filter(function ($key) use ($item, $filterKey, $value, $exclude) {
                    if (array_key_exists($key, $item)) {
                        $itemContainsValue = collect($item[$key])->contains($filterKey, $value);

                        if ($exclude) {
                            return !$itemContainsValue;
                        }

                        return $itemContainsValue;
                    }
                })->count();
            });

        return $this;
    }

    /**
     * Filter one or more keys of the items collection for a given value.
     * Setting the exclude flag will reverse the filter condition
     *
     * @param string|array $keys
     * @param string|array $value
     * @param bool $exclude
     * @return Model
     */
    protected function search($keys, $value, bool $exclude = false)
    {
        if (!is_array($keys)) {
            $keys = [$keys];
        }

        $this->content['items'] = collect($this->content['items'])
            ->filter(function ($item) use ($keys, $value, $exclude) {
                return (bool)collect($keys)->filter(function ($key) use ($item, $value, $exclude) {
                    if (array_key_exists($key, $item)) {
                        $itemContainsValue = str_contains(strtolower($item[$key]), strtolower($value));

                        if ($exclude) {
                            return !$itemContainsValue;
                        }

                        return $itemContainsValue;
                    }
                })->count();
            });

        return $this;
    }

    /**
     * Filter to only return items tagged archived
     *
     * @param bool $archived
     * @return Model
     */
    public function archived(bool $archived = true)
    {
        return $this->filter('archived', $archived);
    }

    /**
     * Filter to only return items tagged featured
     *
     * @param bool $featured
     * @return Model
     */
    public function featured(bool $featured = true)
    {
        return $this->filter('featured', $featured);
    }

    /**
     * Filter to only return items tagged sticky
     *
     * @param bool $sticky
     * @return Model
     */
    public function sticky(bool $sticky = true)
    {
        return $this->filter('sticky', $sticky);
    }

    /**
     * Filter to only return items tagged home
     *
     * @param bool $home
     * @return Model
     */
    public function home(bool $home = true)
    {
        return $this->filter('home', $home);
    }

    /**
     * Shortcut helper to reverse filter / exclude items based on a matching value
     *
     * @param string|array $keys
     * @param string $value
     * @return Model
     */
    protected function exclude($keys, string $value)
    {
        return $this->filter($keys, $value, true);
    }

    /**
     * Get the content of a top level content item by key
     *
     * @param string $key
     * @param mixed $default
     * @return Collection
     */
    protected function get(string $key, $default = null)
    {
        return collect($this->content->get($key));
    }

    /**
     * Helper to get the first item within a collection
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    protected function getFirst(string $key, $default = null)
    {
        return collect($this->content->get($key))->first();
    }

    /**
     * Moves the first X elements into a separate collection item
     *
     * @param int $count
     * @return Model
     */
    public function withFeatured(int $count = 1)
    {
        if (!$items = $this->get('items')) {
            $this->append('featured', []);

            return $this;
        }

        $featured = $items->shift();

        $this->content['items'] = $items;
        $this->append('featured', [$featured]);

        return $this;
    }

    /**
     * Pick a random selection of items to be returned in the model
     *
     * @param int $max
     * @return Model
     */
    public function random(int $max = null)
    {
        $items = $this->get('items');

        if (!isset($max)) {
            $max = $items->count();
        }

        if ($items->count() >= $max) {
            $items = $items->random($max);
        }

        $this->content['items'] = $items;

        return $this;
    }

    /**
     * Limit the number of items returned
     *
     * @param int $max
     * @return Model
     */
    public function take(int $max = null)
    {
        $items = $this->get('items');

        if (!isset($max)) {
            $max = $items->count();
        }
        if ($items->count() >= $max) {
            $items = $items->take($max);
        }

        $this->content['items'] = $items;

        return $this;
    }

    /**
     * Add new fields to the content
     *
     * @param string $key
     * @param mixed $value
     * @return Model
     */
    public function append(string $key, $value)
    {
        $this->content->put($key, $value);

        return $this;
    }

    /*
     * Sorts the items collection by a specified key. Chainable. Ascending.
     *
     * @param string $key
     * @param bool $reverse
     * @return Model
     */
    protected function sortItemsBy(string $key, bool $reverse = false)
    {
        if (is_array($this->content) && !array_key_exists('items', $this->content)) {
            return $this;
        }

        if (!$this->content->has('items')) {
            return $this;
        }

        $sortDirection = $reverse ? 'sortByDesc' : 'sortBy';

        $this->content['items'] = collect($this->content['items'])->$sortDirection($key);

        return $this;
    }

    /**
     * Helper method for soting items by descending order
     *
     * @param string $key
     * @return void
     */
    protected function sortItemsByDesc(string $key)
    {
        return $this->sortItemsBy($key, true);
    }
}
