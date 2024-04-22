+++
title = "Update Laravel Pagination With New Collection"
description = "Did you know you can update a Laravel pagination with a new collection?"
date = "2017-06-04"
category = "Web"
template = "post.html"
[taxonomies]
keywords = ["php", "laravel", "pagination", "db", "results", "database", "query", "model", "hydrate"]
+++

Have you even done a database search (using the `DB` facade) and got back an array of results that wasn't wrapped in lovely little Eloquent Models? After some googling, I am sure you probably found out about the [hydrate](http://commandz.io/create-models-from-query-builder/) method. Using `hydrate`, you can turn an array of results from the database into real models from your application. This works phenomenally.

But what if you want to return paginated results? How do you used the results after they are already paginated? Well there is a method called `setCollection` on the [LengthAwarePaginator](https://laravel.com/api/5.4/Illuminate/Pagination/LengthAwarePaginator.html) class. What it will let you do actually set the results of the pagination to a new collection.

Here is an example of how that works in practice:

```php
<?php
/**
 * Hydrates the paginated results for the query
 */
public function simpleSearchQuery()
{
    // contrived example of a "DB search"
    $results = DB::table('users')
        ->select('name')
        ->where('email', 'LIKE', '%@gmail.com%')
        ->orderBy('created_at')
        ->paginate(15);

    // we can hydrate a model with the results from a DB call
    $hydrated = User::hydrate($results->all());

    // updates the pagination with a new collection of models instead of raw DB array results
    return $results->setCollection($hydrated);
}
```

Now this is a pretty simple example of how this could be used. I used this feature to search across a couple tables that didn't have models. The results were for a specific model type, but I wanted the results to be real models so that I can use nice methods on them to get relationships, trigger mutations, etc.
