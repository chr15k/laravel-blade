# Standalone Laravel Blade templating component

This package allows you to use Laravel's simple yet powerful Blade templating engine as a standalone component.

### Installation

```bash
composer require chr15k/laravel-blade
```

### Usage

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

Documentation:
https://laravel.com/docs/7.x/blade
