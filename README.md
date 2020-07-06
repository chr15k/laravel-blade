# Standalone Laravel Blade templating component

[![Latest Stable Version](https://poser.pugx.org/chr15k/laravel-blade/v)](//packagist.org/packages/chr15k/laravel-blade) [![Latest Unstable Version](https://poser.pugx.org/chr15k/laravel-blade/v/unstable)](//packagist.org/packages/chr15k/laravel-blade) [![Total Downloads](https://poser.pugx.org/chr15k/laravel-blade/downloads)](//packagist.org/packages/chr15k/laravel-blade) [![License](https://poser.pugx.org/chr15k/laravel-blade/license)](//packagist.org/packages/chr15k/laravel-blade)

This package allows you to use Laravel's simple yet powerful Blade templating engine as a standalone component.

## Installation

```bash
composer require chr15k/laravel-blade
```

## Usage

```php
<?php

// Register The Auto Loader
require __DIR__ . '/vendor/autoload.php';


use Chr15k\Blade\Blade;

$views = __DIR__ . '/views'; // Directory containing your blade files
$cache = __DIR__ . '/cache'; // Directory for cached views

$blade = new Blade($views, $cache);

echo $blade->view()->make('test'); // (~/views/test.blade.php)
```

## Documentation
https://laravel.com/docs/7.x/blade

## License
The MIT License (MIT). Please see [License File](https://github.com/chr15k/laravel-blade/blob/master/LICENSE.md) for more information.
