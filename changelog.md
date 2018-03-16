# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- HasParent Trait. Allow any model to have nested Parents. This will handle the validating and generating of full nested slug paths. The model must have a `parent()` method. To filter specific folders to be removed when working with sub-domains, populate a protected array attribute on the model named `$domainMappedFolders`.
- HasBreadcrumbs Trait. Now includes appended `breadcrumbs` attribute through trait constructor. Also published a working breadcrumb blade view `maxfactor::components.breadcrumb`.

## [1.0.1] - 2018-02-21

### Added

- This CHANGELOG file to hopefully serve as an evolving example of a
  standardized open source project CHANGELOG.
- Added version numbering

### Fixed

- Added better version restraints to composer requires to improve compatibility
