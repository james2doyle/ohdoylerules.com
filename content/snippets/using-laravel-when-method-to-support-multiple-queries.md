+++
title = "Using Laravel `when` Method To Support Multiple Queries"
date = "2022-08-14"
category = "Web"
template = "post.html"
description = "How to use the `when` method on database collections in Laravel to create more flexible and readable code"
[taxonomies]
keywords = ["query", "laravel", "sqlite", "postgres", "sql", "builder", "search", "when", "switch", "case"]
+++

There is a method on Laravel collections called [`when`](https://laravel.com/docs/8.x/collections#method-when) that allows you to create a condition on your code without using an `if` statement. This can be really handy given we often have conditions on queries to deal with missing or present data, the session-specific environment, or even information in the config.

Let's look at the common pattern I was using in the past to put conditions on my queries:

```php
<?php
/** @var \Illuminate\Database\Eloquent\Builder|\App\Models\User */
$query = User::query();

// get the filter from the request
$filter = $request->input('role');

if (blank($filter)) {
    $query->where('role', 'basic');
} else {
    $query->where('role', $filter);
}
```

This is a contrived example but it should remind you of code you have seen or written in the past. Now we can rewrite it using the `when` method:

```php
<?php
/** @var \Illuminate\Database\Eloquent\Builder|\App\Models\User */
$query = User::query();

// get the filter from the request
$filter = $request->input('role');

$query->when(
    blank($filter),
    // case when the condition is true (the filter is blank)
    function ($q): void {
        $q->where('role', 'basic');
    },
    // case when condition is false (the filter is NOT blank)
    function ($q) use($filter): void {
        $q->where('role', $filter);
    });
```

This is a lot nicer in my mind. It will allow us to encapsulate code under the closure and not pollute the top level workspace. Sweet!

How about a more complicated example?

```php
<?php
/** @var \Illuminate\Database\Eloquent\Builder|\App\Models\User */
$query = User::query();

// get the search query from the request
$search = $request->input('query');

// when the database is not postgresql, use "like"
if (config('database.default') !== 'pgsql') {
    // replace any spaces with the SQL wildcard `%` character
    $likeReady = Str::of($search)->replace(' ', '%')->append('%')->prepend('%');
    $query->where('name', 'like', $likeReady);
}

// use advanced postgresql features for searching text
if (config('database.default') === 'pgsql') {
    // use the function from the pg_trgm extension that adds special text search features
    $query->whereRaw('SIMILARITY("name"::text, ?) > 0.07', [$search]);
}
```

This is actual code a wrote for an app that uses `sqlite` when testing but uses `postgresql` when running locally. This means some features just don't work unless the right code is running.

Let's rewrite this one as well to clean-up the top level:

```php
<?php
/** @var \Illuminate\Database\Eloquent\Builder|\App\Models\User */
$query = User::query();

// get the search query from the request
$search = $request->input('query');

// nicer way without using if statements
$query->when(
    config('database.default') === 'pgsql',
    function ($q) use ($search): void {
        // use the function from the pg_trgm extension that adds special text search features
        $q->whereRaw('SIMILARITY("name"::text, ?) > 0.07', [$search]);
    },
    function ($q) use ($search): void {
        // replace any spaces with the SQL wildcard `%` character
        $likeReady = Str::of($search)->replace(' ', '%')->append('%')->prepend('%');
        $q->where('name', 'like', $likeReady);
    });
```

Great! Now we have the `pgsql` query nicely wrapped up.

This pattern is not just great for controllers. It works well in scoped queries too. I've used this in a scoped query to change the conditions based on the data in the model. Very handy!

If we use chaining, we can make a very nice flow:

```php
<?php
/** @var \Illuminate\Database\Eloquent\Builder|\App\Models\User */
$query = User::query();

$search = $request->input('query');
$filter = $request->input('role', 'basic');
$ordering = [$request->input('order_by'), $request->input('direction')];

$query->where('role', $filter)
    ->when(
        config('database.default') === 'pgsql',
        function ($q) use ($search): void {
            // use the function from the pg_trgm extension that adds special text search features
            $q->whereRaw('SIMILARITY("name"::text, ?) > 0.07', [$search]);
        },
        function ($q) use ($search): void {
            // replace any spaces with the SQL wildcard `%` character
            $likeReady = Str::of($search)->replace(' ', '%')->append('%')->prepend('%');
            $q->where('name', 'like', $likeReady);
        }
    )->when(
        empty($ordering),
        function ($q): void {
            $q->orderBy('name');
        },
        function ($q) use ($ordering): void {
            $q->orderBy($ordering[0], $ordering[1]);
        }
    );
```

Hopefully this inspires you to find some code and wrap it up to be a little clearer or cleaner.
