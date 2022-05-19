# Wordpress Framework

Wordpress library that contains several classes (components, helpers and mu-plugins) to simplify development on Worpdress. Part of the library is based on Symfony.

[![Latest Stable Version](https://img.shields.io/packagist/v/dbout/wp-framework?style=flat-square)](https://packagist.org/packages/dbout/wp-framework)

## Requirements

The server requirements are basically the same as for WordPress with the addition of a few ones :

- PHP >= 7.4
- [Composer](https://getcomposer.org/) ❤️

> To simplify the integration of this library, we recommend using Wordpress with one of the following tools: [Bedrock](https://roots.io/bedrock/), [Themosis](https://framework.themosis.com/) or [Wordplate](https://github.com/wordplate/wordplate#readme).

## Installation

Install with composer, in the root of the Wordpress project run:

```bash
composer require dbout/wp-framework
```

## Components

- API
- [Form](doc/components/form.md)
- [Logger](doc/components/logger.md)
- [Notice](doc/components/notice.md)
- [Page](doc/components/page.md)
- [PostType](doc/components/postype.md)
- [Provider](doc/components/provider.md)
- [Router & Controller](doc/components/router-controller.md)
- [Validator](doc/components/validator.md)

## Helpers

- [File](src/Helper/File.php)
- [Format](src/Helper/Format.php)
- [Url](src/Helper/Url.php)
- [UploadDir](src/Helper/UploadDir.php)

## MU Plugins

- Clean head
- Disable comment
- Disable Rest API
- Remove emoji support
- Remove generator metas