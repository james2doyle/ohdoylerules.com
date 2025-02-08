+++
title = "Lodash memoize with a timeout"
description = "Use lodash memoize with a TTL/timeout. Allows calls to be cached by time as well as argument values"
date = "2021-10-20"
category = "Snippets"
template = "post.html"
[taxonomies]
keywords = ["lodash", "memo", "ttl", "timeout", "cache", "function", "memoize"]
+++

If you are familiar with [lodash](https://lodash.com/docs/4.17.15) you may also be familiar with one of the very handy functions called [memoize](https://lodash.com/docs/4.17.15#memoize).

The definition of `memoize` on the lodash site is quite verbose. So I will use the [definition on wikipedia](https://en.wikipedia.org/wiki/Memoization):

> In computing, "memoization" or "memoisation" is an optimization technique used primarily to speed up computer programs by storing the results of expensive function calls and returning the cached result when the same inputs occur again.

The default `memo` function in lodash uses a local Map to cache the results of each call. This means the results of the calls to `memo` will be cached for the entire browser session. The way you would clear the cache is to refresh or trigger a full navigation.

A function that returns the same result given the same input, is called a [pure function](https://en.wikipedia.org/wiki/Pure_function). So if you have a "pure function" that gets called a lot with the same arguments, and should have the same output given the same arguments, then this is a perfect candidate for memoization. Of course, it is perfectly fine to reach for memoization in order to keep things like expensive HTTP requests from being repeated.

But is a "session" based cache really the best cache for `memo`? Personally, I think that a time-based caching mechanism is better. What I mean is that the cache will only live for a specific amount of time and then expire.

Imagine a case where you just fetched a users account from your API. If for some reason your code calls that endpoint again just a few seconds later, is it worth redoing the request or should you return cached results given you just called that endpoint earlier?

If you are using the default cache, the request will never be run again unless you refresh. But there may have been changes to the results of the call but you can't rerun it. This is where a TTL cache comes in.

TTL (time to live) is the amount of time that needs to elapse before the cache needs to be refreshed. If you are familiar with the HTTP protocol, you may have come across this term when learning about cache headers.

So how do you implement a custom cache backend for lodash `memoize`? Easy! The `memoize` function allows you to write your own resolver function that lets you decide when to fetch from the cache or run the function again.

I've done the work for you and made a simple version in TypeScript that uses the current minute as a tracker for when the last call was:

{{ gist(src="https://gist.github.com/james2doyle/2a7428e6e740279f8cc7fbd2dd7b4f75.js") }}

You can see in this function that we take in the arguments and add a time to the end. We then serialize that object as JSON and use that as our cache key. When lodash runs our new `memo` function, it will first compare the cached keys and see if they are different. If they are, then the function will actually run and the cached results will not be used and instead our original function will run, and the result of that run, will be cached. Subsequent calls repeat the whole process.

In this case, we only cache the results for one minute. So any calls to our new `memo` function that are over a minute old will run. This will allow some inefficient code that calls an endpoint too often to only make those calls if at least a minute has passed.

In this case, our new `memo` is almost like the `throttle` function in lodash except we get the results back when we call our `memo`. But if you need to control the mechanism of caching (maybe you want to use localstorage, the URL, or global state) then you can write your own `memoize`.
