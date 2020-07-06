# Standalone Blade templating

Love Blade templating?
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

$views = __DIR__ . '/views'; // Directory containing your views
$cache = __DIR__ . '/cache'; // Directory for caching

$blade = new Blade($views, $cache);

echo $blade->view()->make('test'); // (~/views/test.blade.php)
```

You can use all blade features as described in the Laravel documentation:
https://laravel.com/docs/7.x/blade
