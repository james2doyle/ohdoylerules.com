---
Title: "Using Sqlite As A Cache In Laravel"
Date: "2018-10-04"
Category: "Web"
Template: "post"
Description: "How to use Sqlite as a cache in Laravel"
Keywords: ["cache", "laravel", "sqlite", "store"]
---

I was playing with a new project using [Laravel 5.7](https://laravel.com/docs/5.7) and I wanted to use [sqlite](https://www.sqlite.org/index.html) for the [cache feature](https://laravel.com/docs/5.7/cache) that comes with the framework. If you didn't know, Laravel allows you to choose a cache "driver" and Laravel will handle writes, reads, and even locks, using that cache.

By default, Laravel includes drivers for "database", "redis", "memcached", "file", and "array". In typical Laravel fashion, you can even [write your own drivers](https://laravel.com/docs/5.7/cache#adding-custom-cache-drivers). All you need to do is implement the `Illuminate\Contracts\Cache\Store` interface using the technology you wish to turn into a cache driver.

To my surprise, the "database" cache driver does not support multiple database connections. Which means whatever `DB_CONNECTION` you are using is also going to be used for the cache database driver when it is selected. I took a look to see how the "database" driver was implemented (it's in the `Illuminate\Cache\DatabaseStore` class) to see if there is any way I can make the database driver use a different connection than the one set in `DB_CONNECTION`. Looking deeper, it turns out that by extending `Illuminate\Cache\DatabaseStore`, I was able to put together a "sqlite" cache driver really quickly.

Before you set this all up, make sure you create the empty database. From the root of your project run: `touch database/cache.sqlite`. This creates an empty file that sqlite will mount as the database. To learn more about sqlite and how the file works, check out the page at the sqlite site about the [Single-file Cross-platform Database](https://www.sqlite.org/onefile.html).

For the next step, you will need to make sure that the `sqlite3` command line tool is installed. If you need help getting that going, [check out the download page for the tool](https://www.sqlite.org/download.html). Once that is installed, or if you already have it, you can then connect to the database file via the sqlite cli: `sqlite3 database/cache.sqlite`. If you want more info about the CLI tool, [check out the sqlite docs](https://www.sqlite.org/cli.html).

Finally, you need to setup that sqlite database by executing the following SQL statement:

```sql
CREATE TABLE `cache` (
   `key` STRING PRIMARY KEY,
   `value` TEXT NOT NULL,
   `expiration` INT DEFAULT 0
);
```

This statement will update the sqlite database with the required table and columns. This SQL is the same statement that runs when the cache migrations are created via the `artisan` command. To see that the SQL statement worked, you can run the `.tables` command. You should see `cache` in the list. To close out of the sqlite cli, run `.exit`.

Now that everything is all setup, here is the class that implements the `SqliteStore` that allows for a sqlite driver:

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

You may need to run `composer dumpautoload` in order for the new class to be picked up if you are creating the `app/Extensions` folder for the first time.

Then, add the following to your `AppServiceProvider@boot`:

```php
// AppServiceProvider@boot
\Cache::extend('sqlite', function ($app) {
    return \Cache::repository(new \App\Extensions\SqliteStore);
});
```

That's it for the code side. But we still need to setup the config so the driver details exist. Open up the `config/cache.php` file. Add these details so the config can be properly loaded:

```php
// ... the rest of config/cache.php
'sqlite' => [
    'driver' => 'sqlite',
    'table' => 'cache',
    'database' => env('CACHE_DATABASE', database_path('cache.sqlite')),
    'prefix' => '',
],
```

You can then update your `.env` to have `CACHE_DRIVER=sqlite` and everything should be good!
