<?php

namespace Maxfactor\Support\Webpage\Traits;

use Illuminate\Support\Arr;

trait HasMetaAttributes
{
    private $hasMetaAttributesStorageFields = [
        'meta_attributes',
    ];

    private $hasMetaAttributesFillableFields = [
        'browser_title',
        'h1',
        'meta_description',
        'nav_title',
    ];

    private $metaAttributesDefaults = [
        'browser_title' => 'name',
        'h1' => 'name',
        'nav_title' => 'name',
    ];

    public function initHasMetaAttributes()
    {
        $this->casts = array_merge($this->casts, collect($this->hasMetaAttributesStorageFields)->map(function ($field) {
            return [$field => 'array'];
        })->collapse()->all());

        $this->hidden = array_merge($this->hidden, $this->hasMetaAttributesStorageFields);

        $this->fillable = array_merge(
            $this->fillable,
            $this->hasMetaAttributesFillableFields,
            $this->hasMetaAttributesStorageFields
        );

        $this->appends = array_merge($this->appends, $this->hasMetaAttributesFillableFields);
    }

    public function setBrowserTitleAttribute($value)
    {
        $this->setMetaAttributesField('browser_title', $value);
    }

    public function getBrowserTitleAttribute()
    {
        return $this->getMetaAttributesField('browser_title');
    }

    public function setH1Attribute($value)
    {
        $this->setMetaAttributesField('h1', $value);
    }

    public function getH1Attribute()
    {
        return $this->getMetaAttributesField('h1');
    }

    public function setMetaDescriptionAttribute($value)
    {
        $this->setMetaAttributesField('meta_description', $value);
    }

    public function getMetaDescriptionAttribute()
    {
        return $this->getMetaAttributesField('meta_description');
    }

    public function setNavTitleAttribute($value)
    {
        $this->setMetaAttributesField('nav_title', $value);
    }

    public function getNavTitleAttribute()
    {
        return $this->getMetaAttributesField('nav_title');
    }

    protected function setMetaAttributesField($field, $value)
    {
        // the more obvious solution of
        // $this->metaAttributes[$field] = $value
        // doesn't work due to eloquent's behind the scenes magic

        $metaAttributes = $this->meta_attributes;
        $metaAttributes[$field] = $value;
        $this->meta_attributes = $metaAttributes;
    }

    protected function getMetaAttributesField($field, $default = null)
    {
        if (is_array($this->meta_attributes) && !array_key_exists($field, $this->meta_attributes)) {
            return $this->getFinalValue($field, $default);
        }

        if ($value = Arr::get($this->meta_attributes, $field) === null) {
            return $this->getFinalValue($field, $default);
        }

        return Arr::get($this->meta_attributes, $field);
    }

    private function getFinalValue($field, $default = null)
    {
        /**
         * You can define a $metaDefaults array on the class implementing the trait to overwrite
         * trait defaults.
         */
        $metaDefaults = array_merge($this->metaAttributesDefaults, $this->metaDefaults ? : []);

        if (!array_key_exists($field, $metaDefaults)) {
            return $default;
        }

        $defaultField = $metaDefaults[$field];

        if (!array_key_exists($defaultField, $this->attributes)) {
            return $default;
        }

        if ($this->{$defaultField} === null) {
            return $default;
        }

        return $this->{$defaultField};
    }
}
