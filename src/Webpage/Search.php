<?php

namespace Maxfactor\Support\Webpage;

use Exception;
use Illuminate\Support\Arr;

class Search
{
    protected $models;
    protected $query;

    public function __construct(string $query = '')
    {
        $this->models = collect([]);
        $this->phrase = $query;
    }

    /**
     * Add one or more query builder instances to the search
     *
     * @param \Illuminate\Database\Eloquent\Builder|array $model
     * @return self
     */
    public function in($model)
    {
        $this->models = $this->models->merge(Arr::wrap($model));

        return $this;
    }

    /**
     * Define the search query / phrase
     *
     * @param string $query
     * @return self
     */
    public function for(string $query)
    {
        $this->phrase = $query;

        return $this;
    }

    /**
     * Execute the search
     *
     * @return \Illuminate\Support\Collection
     */
    public function get()
    {
        return $this->models->map(function ($model) {
            try {
                return $model->search($this->phrase)->get();
            } catch (Exception $e) {
                $class = get_class($model->getModel());
                throw new Exception("{$class} is not searchable");
            }
        })->collapse()->sortByDesc('relevance');
    }

    /**
     * Return a paginated set of results
     *
     * @param $perPage
     * @param $total
     * @param $page
     * @param string $pageName
     * @return void
     */
    public function paginate($perPage, $total = null, $page = null, $pageName = 'page')
    {
        return $this->get()->paginate($perPage, $total, $page, $pageName);
    }
}
