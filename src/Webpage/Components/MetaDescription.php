<?php

namespace Maxfactor\Support\Webpage\Components;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Htmlable;

class MetaDescription implements Htmlable
{
    private $request;
    private $description;

    public function __construct(Request $request, string $description)
    {
        $this->request = $request;
        $this->description = $description;
    }

    public function toHtml(): string
    {
        return view('maxfactor::components.metadescription', [
            'description' => $this->description,
        ]);
    }
}
