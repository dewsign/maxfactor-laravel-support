# Maxfactor Laravel Support

[![Packagist](https://img.shields.io/packagist/v/maxfactor/support.svg?style=for-the-badge)](https://packagist.org/packages/maxfactor/support)

Authors:

* [Marco Mark](mailto:marco.mark@dewsign.co.uk)
* [Jacob Walters](mailto:jacob.walters@dewsign.co.uk)
* [Tristan Ward](mailto:tristan.ward@dewsign.co.uk)
* [Sam Wrigley](mailto:sam.wrigley@dewsign.co.uk)
* [Daniel Crewdson](mailto:daniel.crewdson@dewsign.co.uk)

## Overview

A set of helper methods and classes commonly used in Web projects

## Models

More generic helpers which apply to more than just front-end facing web pages.

### Active State

Ensure records can be active or inactive (e.g. Draft like state). Add the trait to your model and the fields to your migration.

```php
use Maxfactor\Support\Model\Traits\HasActiveState;
```

```php
$table->active();
```

### Featured State

Allow records to be featured.

```php
use Maxfactor\Support\Model\Traits\CanBeFeatured;
```

```php
$table->featured();
```

### Sorting Order

Allow records to be ordered/sorted (sequentially). Add the trait and sortable contract to your model.

```php
use Spatie\EloquentSortable\Sortable;
use Maxfactor\Support\Model\Traits\HasSortOrder;

class Category extends Model implements Sortable
{
    use HasSortOrder;
    ...
}
```

Migration helper ...

```php
$table->sortable();
```

A query scope is included so you can access sorted results without manually defining the `orderBy`.

```php
$results = Model::sorted()->get();
```

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
@render('maxfactor:webpage::browserTitle', ['title' => Arr::get($page ?? [], 'browserTitle', config('app.name'))])
```

And this is a pre-made component to render the meta description

```php
@render('maxfactor:webpage::metaDescription', ['description' => Arr::get($page ?? [], 'metaDescription')])
```

#### Additional Meta Fields in Nova

You can pass in additional meta fields into the `MetaAttributes::make()` function, to display your own fields in the 'Meta Attributes' panel that this package creates.

```php
// Define our additional fields in the resource.
protected function additionalMetaFields()
{
    return [
        Text::make('Example Meta Content'),
    ];
}

// Inside the resources fields() function we can pass in our additional fields as a parameter.
MetaAttributes::make($this->additionalMetaFields()),
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

#### Setting a default 'Home' breadcrumb

To change the default Home breadcrumb, you can set the `homeBreadcrumb` config value.

```php
// config/maxfactor-support.php
'homeBreadcrumb' => 'Home',
```

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

The Maxfactor facade also includes an additional helper method which can be used to deal with Querystring parameters in the canonical url. The `urlWithQuerystring` method accepts the desired url and a string or regular expression to filter which parameters to include in the output. The query values are taken from the current request query, even though the destination url doesn't have to match this. Here's an example of how this could be used to include pagination.

```php
// Assuming the current url is https://example.com/journal?page=2&tag=news

Maxfactor::urlWithQuerystring('https://example.com/blog', $allowedParameters = 'page=[^1]');

// returns https://example.com/blog?page=2
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

### Enforce Domain Names and SSL

Search engines should only index content at a single URL, as such your website should only be served on it's primary domain. We provide a middleware to handle this as well as allowing for mutliple domains (if you are running domain specific routes).

Add the `Maxfactor\Support\Webpage\Middleware\ForceDomain::class` to your web middleware group in the Kernel.

By default it will use the Scheme (HTTP/HTTPS) and domain name form your `app.url` config value. You can specify additional domains in your `.env`.

```env
ALLOWED_DOMAINS="sub1.mydomain.com,sub2.mydomain.com"
```

Furthermore you can specifcy which response codes should be run through the domain validator in the `maxfactor-support` config.

```php
'enforceDomainsStatusCodes' => [
    \Symfony\Component\HttpFoundation\Response::HTTP_OK,
    \Symfony\Component\HttpFoundation\Response::HTTP_MOVED_PERMANENTLY,
    \Symfony\Component\HttpFoundation\Response::HTTP_TEMPORARY_REDIRECT,
    \Symfony\Component\HttpFoundation\Response::HTTP_PERMANENTLY_REDIRECT,
],
```

### Password protection

If you want to protected access to your application, or certain routes, on specific environments (e.g. staging) you can include the `Maxfactor\Support\Webpage\Middleware\EnvironmentAuth::class` middleware, either on entire groups or specific routes as required by naming the middleware in the Kernel.

```php
protected $routeMiddleware = [
    ...
    'auth.environment' => \Maxfactor\Support\Webpage\Middleware\EnvironmentAuth::class,
];
```

This will require the visitor to login with a valid user account on environments specified in the `auth.php` config (Defaults to `staging`).

```php
    // config/auth.php

    ...
    /*
    |--------------------------------------------------------------------------
    | Environments
    |--------------------------------------------------------------------------
    |
    | Determine which environments should be password protected.
    |
    */

    'environments' => [
        'staging',
    ],
```
