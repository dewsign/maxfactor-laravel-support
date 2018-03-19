<?php

namespace Maxfactor\Support\Webpage\Contracts;

interface Webpage
{
    /**
     * Return the breacrumbs for this Web Page.
     *
     * @return Array
     */
    public function seed();

    /**
     * Ensure all Webpages have a canonical URL to avoid SEO problems
     *
     * @return string
     */
    public function getCanonicalAttribute();
}
