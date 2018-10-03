# Maxfactor Laravel Support

[![Packagist](https://img.shields.io/packagist/v/maxfactor/support.svg?style=for-the-badge)](https://packagist.org/packages/maxfactor/support)

Authors:

* [Marco Mark](mailto:marco.mark@dewsign.co.uk)
* [Jacob Walters](mailto:jacob.walters@dewsign.co.uk)
* [Tristan Ward](mailto:tristan.ward@dewsign.co.uk)
* [Sam Wrigley](mailto:sam.wrigley@dewsign.co.uk)

## Overview

A set of helper methods and classes commonly used in Web projects

## Webpage

A set of helpers and traits relating to public facing web pages.

Typically any model which interfaces with the front-end views should extend the `Maxfactor\Support\Webpage\Model` instead of the default Eloquent Model. This will ensure other Traits can be correctly initialised.

INPORTANT: In order to try and create some consistancy, the main Model passed into a view should always be called `$page`. This makes it much easier to include default behaviour inside layouts and other shared components without explicitly passing in values.

```php
return view('my.view')->with('page', $model)
```

### Meta (incl. Browser Title)

Add the `Maxfactor\Support\Webpage\Traits\HasMetaAttributes` trait to your model and include the  migrations by adding the meta field(s). This will include the correct database column and default to cover:

* h1
* browserTitle
* metaDescription
* navTitle

```php
$table->meta();
```

Include this in your layout to render the browser title

```php
@render('maxfactor:webpage::browserTitle', ['title' => array_get($page ?? [], 'browserTitle', config('app.name'))])
```

And this is a pre-made component to render the meta description

```php
@render('maxfactor:webpage::metaDescription', ['description' => array_get($page ?? [], 'metaDescription')])
```

### Slugs

Add the `Maxfactor\Support\Webpage\Traits\HasSlug` trait to your model if you want the route helper to use the `slug` column in your database to identify records. (E.g. `/blog/article/foo` instead of `/blog/article/1`).

Within your migrations you can simply use the slug helper to add the correct column to your tables. `$table->slug()`.

### Breadcrumbs

Use the `Maxfactor\Support\Webpage\Traits\HasBreadcrumbs` trait (already included if you are using the Webpage Model). Overload the `seeds()` method to return custom breadcrumbs and/or use the `seed()` method to push any breadcrumbs you require into the parent seed to add additional breadcrumbs.

```php
public function seeds()
{
    return array_merge(parent::seeds(), [[
        'name' => __('Branch finder'),
        'url' => route('branch.index'),
    ], [
        'name' => $this->navTitle,
        'url' => route('branch.show', $this),
    ]]);
}
```

```php
// Branch Controller
$branch->seed($name = __('Audiologists'), $url = route('branch.audiologists', $branch), $status = null);
```

Inside your blade view, render the breadcrumbs `@include('maxfactor::components.breadcrumb', ['seed' => $page->breadcrumbs])`. Replace the view with your own if required.

### Canonicals

Include the `MustHaveCanonical` trait which by default will return the current url but you typically would specify your own.

This can be done on the Model ...

```php
public function baseCanonical()
{
    return route('branch.show', $this);
}
```

Or inline (e.g. in the controller). This will take precedence over the `baseCanonical`.

```php
$branch->canonical($url);
```

Inside the head of your blade layout (or view) render the canonical meta field.

```php
@include('maxfactor::components.canonical')
```

### Sitemap

To generate a sitemap simply create a new Command and Extend the `MakeSitemap` command in this package. Then add it to your console kernel and schedule as required. Here is the template to use as starting point.

```php
<?php
namespace App\Console;

use Maxfactor\Support\Webpage\Commands\MakeSitemap;

class Sitemap extends MakeSitemap
{
    /**
     * Populate the sitemap. This method should be overloaded to add content.
     *
     * @param Sitemap $sitemap
     * @return void
     */
    public function populate($sitemap)
    {
        // $sitemap->add('/url');
    }
}
```
