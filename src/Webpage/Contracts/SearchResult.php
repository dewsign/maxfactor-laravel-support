<?php

namespace Maxfactor\Support\Webpage\Contracts;

interface SearchResult
{
    public function getResultTitleAttribute();
    public function getResultSubTitleAttribute();

    public function getResultSummaryAttribute();

    public function getResultUrlAttribute();

    public function getResultImageAttribute();
}
