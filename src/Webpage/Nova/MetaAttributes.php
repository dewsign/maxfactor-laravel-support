<?php

namespace Maxfactor\Support\Webpage\Nova;

use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use ElevateDigital\CharcountedFields\TextCounted;
use ElevateDigital\CharcountedFields\TextareaCounted;

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
            TextCounted::make('Browser Title')
                ->hideFromIndex()
                ->maxChars(60)
                ->warningAt(50),
            Text::make('Nav Title')->hideFromIndex(),
            TextareaCounted::make('Meta Description')
                ->maxChars(300)
                ->warningAt(250),
        ];
    }
}
