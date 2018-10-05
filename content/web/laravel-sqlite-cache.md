---
Title: "Laravel Sqlite Cache"
Date: "2018-10-04"
Category: "Web"
Template: "post"
Description: "How to use Sqlite as a cache in Laravel"
Keywords: ["cache", "laravel", "sqlite", "store"]
---

I was playing with a new project using Laravel 5.7 and I wanted to use sqlite for the cache feature that comes with the framework.

To my surprise, the "database" cache driver does not support changing the database connection. So, by extending `Illuminate\Cache\DatabaseStore`, I was able to put together a sqlite cache driver really quickly.

Before you set this all up, make sure you create the empty database. From the root of your project run: `touch database/cache.sqlite`.

Then, you will need to connect to that new database via the sqlite cli: `sqlite3 database/cache.sqlite`.

Finally, you then need to setup that sqlite database with the following SQL statement:

```sql
CREATE TABLE cache (
   `key` STRING PRIMARY KEY,
   `value` TEXT NOT NULL,
   `expiration` INT DEFAULT 0
)
```

This statement will update the sqlite database with the required table and columns.

Now that everything is all setup, here is the setup:

```php
<?php
// put in app\Extensions
namespace App\Extensions;

use Illuminate\Cache\DatabaseStore;
use Illuminate\Support\Facades\Config;

/**
 * SqliteStore delegates to DatabaseStore but with an sqlite connection instead
 */
class SqliteStore extends DatabaseStore
{
    public function __construct()
    {
        // load the config or use the default
        $config = config('cache.stores.sqlite', [
            'driver' => 'sqlite',
            'table' => 'cache',
            'database' => env('CACHE_DATABASE', database_path('cache.sqlite')),
            'prefix' => '',
        ]);

        // Set the temporary configuration
        Config::set('database.connections.sqlite_cache', [
            'driver' => 'sqlite',
            'database' => $config['database'],
            'prefix' => $config['prefix'],
        ]);

        $connection = app('db')->connection('sqlite_cache');
        parent::__construct($connection, $config['table'], $config['prefix']);
    }
}
```

Then, add the following to your `AppServiceProvider@boot`:

```php
// AppServiceProvider@boot
\Cache::extend('sqlite', function ($app) {
    return \Cache::repository(new \App\Extensions\SqliteStore);
});
```

You can then update your `.env` to have `CACHE_DRIVER=sqlite` and everything should be good!
