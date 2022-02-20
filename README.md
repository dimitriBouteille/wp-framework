# Wordpress Framework

Wordpress library that contains several classes to simplify development on Worpdress. Part of the library is based on Symfony.

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

- [Form](doc/components/form.md)
- [Logger](doc/components/logger.md)
- [Notice](doc/components/notice.md)
- [PostType](doc/components/postype.md)
- [Provider](doc/components/provider.md)
- [Router & Controller](doc/components/router-controller.md)

## Helpers

- [File](src/Helper/File.php)
- [Format](src/Helper/Format.php)
- [Url](src/Helper/Url.php)
- [UploadDir](src/Helper/UploadDir.php)
