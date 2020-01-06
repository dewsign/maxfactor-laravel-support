<?php

namespace Maxfactor\Support\Webpage\Traits;

use Illuminate\Support\Arr;

trait IsWebpage
{
    protected $template = 'default';
    protected $namespace = '';
    protected $params;

    /**
     * Sets or gets the name of the template file to render this Blog with.
     *
     * @param string $template
     * @return self
     */
    public function template(string $template)
    {
        $this->template = $template;

        return $this;
    }

    /**
     * Render the page content into the relevant template. Can pass in optional
     * replacement content to render instead of the default.
     *
     * @param $content
     * @return View/Redirect
     */
    public function render($content = null)
    {
        if (method_exists($this, 'seed')) {
            $this->append('seed', $this->seed()->all());
        }

        return view("{$this->namespace}{$this->template}", $content ? : $this->content);
    }

    /**
     * Return the raw content retrieved from the api for out-of-class processing.
     *
     * @param bool $collapsed
     * @return \Illuminate\Support\Collection
     */
    public function raw(bool $collapsed = false): \Illuminate\Support\Collection
    {
        if ($collapsed) {
            return $this->content->collapse();
        }

        return $this->content;
    }

    /**
     * Return the items collection from the content
     *
     * @return Array/Collection
     */
    public function items()
    {
        return Arr::get($this->content, 'items', []);
    }
}
