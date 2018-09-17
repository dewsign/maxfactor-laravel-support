<?php

namespace Maxfactor\Support\Webpage\Nova;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;

class MetaAttributes
{
    public static function make()
    {
        return new Panel(__('Meta Attributes'), self::fields());
    }

    protected static function fields()
    {
        return [
            Text::make('H1')->hideFromIndex(),
            Text::make('Browser Title')->hideFromIndex(),
            Text::make('Nav Title')->hideFromIndex(),
            Textarea::make('Meta Description'),
        ];
    }
}
