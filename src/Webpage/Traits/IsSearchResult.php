<?php

namespace Maxfactor\Support\Webpage\Traits;

trait IsSearchResult
{
    public function initializeIsSearchResult()
    {
        $this->appends = array_merge($this->appends, [
            'result_title',
            'result_sub_title',
            'result_summary',
            'result_url',
            'result_image',
        ]);
    }
}
