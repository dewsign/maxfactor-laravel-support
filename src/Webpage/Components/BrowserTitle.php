<?php

namespace Maxfactor\Support\Webpage\Components;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Htmlable;

class BrowserTitle implements Htmlable
{
    private $request;
    private $title;

    public function __construct(Request $request, string $title)
    {
        $this->request = $request;
        $this->title = $title;
    }

    public function toHtml(): string
    {
        return view('maxfactor::components.browsertitle', [
            'title' => $this->title,
        ]);
    }
}
