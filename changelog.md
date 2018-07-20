# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [UNRELEASED]

### Added

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
