<?php

namespace Maxfactor\Support\Webpage\Nova;

use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\TextArea;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Field;

class MetaAttributes
{
    public static function render()
    {
        return new Panel('Meta Attributes', [
            Text::make('H1'),
            Text::make('Browser Title'),
            Text::make('Nav Title'),
            TextArea::make('Meta Description'),
        ]);
    }
}
