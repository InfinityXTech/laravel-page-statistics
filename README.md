# This is my package laravel-page-statistics

[![Latest Version on Packagist](https://img.shields.io/packagist/v/infinityxtech/laravel-page-statistics.svg?style=flat-square)](https://packagist.org/packages/infinityxtech/laravel-page-statistics)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/infinityxtech/laravel-page-statistics/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/infinityxtech/laravel-page-statistics/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/infinityxtech/laravel-page-statistics/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/infinityxtech/laravel-page-statistics/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/infinityxtech/laravel-page-statistics.svg?style=flat-square)](https://packagist.org/packages/infinityxtech/laravel-page-statistics)

Simple package for collection visited page statistic.

## Installation

You can install the package via composer:

```bash
composer require infinityxtech/laravel-page-statistics
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="page-statistics-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="page-statistics-config"
```

This is the contents of the published config file:

```php
return [
    'geoip_db_path' => null
];
```

In case you need to update config of packages used here, check docs for:

- [cyrildewit/eloquent-viewable](https://github.com/cyrildewit/eloquent-viewable)
- [geoip2/geoip2](https://github.com/maxmind/GeoIP2-php)
- [matomo/device-detector](https://github.com/matomo-org/device-detector)

## Usage

First it is same as for eloquent-viewable you need to add these to your model:

```php
use Illuminate\Database\Eloquent\Model;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Post extends Model implements Viewable
{
    use InteractsWithViews;

    // ...
}
```

Then, you can use this code to save stats to database:

```php
// Route model binding example

Route::get('/post/{slug}', function (Post $post) {

    $pageStatistics = new InfinityXTech\PageStatistics();

    $view = $pageStatistics->record($post);

});

```

There is also a method to get details that are stored.

```php

    $pageStatistics = new InfinityXTech\PageStatistics();

    $details = $pageStatistics->getDetails();

    // do whatever with $details

    $view = $pageStatistics->record($post, $details);

```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [InfinityXTech](https://github.com/InfinityXTech)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
