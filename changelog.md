# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [2.6.5] - 2019-10-18

### Changed

– Laravel 6 compatibility

## [2.6.4] - 2019-09-03

### Fixed

– Updated location helpers to swap unstable package

## [2.6.3] - 2019-07-11

### Removed

- Removed the `elevate-digital/nova-charcounted-fields` as this was causing issues when trying to require this package in a non `Laravel Nova` repo.

## [2.6.2] - 2019-07-10

### Changed

- Removed abandoned package `dannyvankooten/vat.php` and replaces with `dannyvankooten/laravel-vat`

## [2.2.4] – 2019-03-11

### Fixed

- Correct case on character count import for meta attributes

## [2.2.3] – 2019-02-13

### Changed

- Character count fields on meta attributes

## [2.2.2] – 2019-01-29

### Changed

- Use full URL path including parameters when comparing for breadcrumb active state.

## [2.2.1] – 2019-01-21

### Removed

- Do not require nova field package to ensure this package doesn't rely on Laravel Nova to be included.

## [2.2.0] – 2019-01-15

### Added

- rootParent attribute to return the top root page object. Can use useful when wanting to always list sub-navigation items from the root for aside etc.

## [2.1.0] – 2019-01-03

### Added

- New alternative, simplified list view to use instead of reusing the breadcrumb view

## [2.0.6] – 2018-12-12

### Changes

- Removed the index url (/) from being included by default when generating the sitemap

## [1.4.0] - 2018-09-12

### Added

- Various improvements and additions to Webpage related modules and traits
- Improved documentation

## [1.3.0] - 2018-07-20

### Added

- Video helper facade to generate embed codes from video URLs of popular video hosting services like YouTube & Vimeo.
- Traits to assist with common functionality
- - Meta Attributes
- - Active state
- - Prioritisation

## [1.2.2] - 2018-07-12

### Added

- Canonical blade view component to use in page headers to show the canonical link

## [1.2.1] - 2018-04-20

### Changed

- Fixes error when using response caching in Canonical middleware

## [1.2.0] - 2018-03-21

### Added

- `parent` and `children` abstract methods to the HasParent Trait to impose requirements upon the exhibiting class.
- `withChildren` local scope to eager load `children` relationship to reduce database queries.

### Changed

- Improved HasParent Trait method docblocks.

## [1.1.0] - 2018-03-16

### Added

- HasParent Trait. Allow any model to have nested Parents. This will handle the validating and generating of full nested slug paths. The model must have a `parent()` method. To filter specific folders to be removed when working with sub-domains, populate a protected array attribute on the model named `$domainMappedFolders`.
- HasBreadcrumbs Trait. Now includes appended `breadcrumbs` attribute through trait constructor. Also published a working breadcrumb blade view `maxfactor::components.breadcrumb`.
- MustHaveCanonical Trait and Middleware. Includes a Link rel canonical header to SEO duplication.

## [1.0.1] - 2018-02-21

### Added

- This CHANGELOG file to hopefully serve as an evolving example of a
  standardized open source project CHANGELOG.
- Added version numbering

### Fixed

- Added better version restraints to composer requires to improve compatibility
