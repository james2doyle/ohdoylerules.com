+++
title = "How To Use LC_MONETARY In Laravel"
description = "How to use setlocale with LC_MONETARY in Laravel"
date = "2017-02-24"
category = "Tricks"
template = "post.html"
[taxonomies]
keywords = ["php", "laravel", "setlocale", "lc_monetary", "money_format"]
+++

If you are using the awesome `money_format` function in PHP, you may have noticed a difference between servers or environments regarding the output.

Sometimes you do get the trailing zeros. Sometimes not.

If you are ever trying to figure out what is going on here, it usually has to do with the current locale of the application. In Laravel, you can make this change in the `AppServiceProvider`:

```php
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // set the money locale for money_format to work nicely
        setlocale(LC_MONETARY, 'en_US.UTF-8');
    }

    // ... rest of the provider
```

And that should be it. Now when using `money_format`, the output should be normalized.
