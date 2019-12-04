<?php

namespace Maxfactor\Support\Macros;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CollectionPaginate extends Macro
{
    public function registerMacro()
    {
        /**
         * Paginate a standard Laravel Collection.
         * Credit: https://gist.github.com/simonhamp/549e8821946e2c40a617c85d2cf5af5e
         *
         * @param int $perPage
         * @param int $total
         * @param int $page
         * @param string $pageName
         * @return array
         */
        Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);
            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });
    }
}
