<?php

namespace Maxfactor\Support\Webpage;

use Maxfactor\Support\Webpage\Contracts\Webpage;
use Maxfactor\Support\Webpage\Traits\HasBreadcrumbs;
use Illuminate\Database\Eloquent\Model as EloquentModel;

class Model extends EloquentModel implements Webpage
{
    use HasBreadcrumbs;

    public function __construct(array $attributes = [])
    {
        $this->initTraits();

        parent::__construct($attributes);
    }

    protected function initTraits()
    {
        foreach (class_uses($this) as $trait) {
            $reflection = new \ReflectionClass($trait);
            $shortName = $reflection->getShortName();
            $initMethodName = "init$shortName";

            if ($reflection->hasMethod($initMethodName)) {
                $this->$initMethodName();
            }
        }
    }

    public function seed()
    {
        return collect([[
            'name' => config('app.name'),
            'url' => config('app.url'),
        ]]);
    }

    public function getCanonicalAttribute()
    {
        return url()->current();
    }
}
