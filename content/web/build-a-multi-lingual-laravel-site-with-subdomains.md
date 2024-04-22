+++
title = "Build A Multi-lingual Laravel Site With Subdomains"
date = "2019-08-25"
category = "Web"
template = "post.html"
description = "Have you ever wanted to use subdomains in Laravel to control logic, locale, or other functionality? Well, this example might help."
[taxonomies]
keywords = ["laravel", "php", "locale", "subdomain", "routing", "switch", "multisite", "multilingual", "translation"]
+++

OK, so you want to make Laravel a multi-lingual (or just multi-functional) site based off the subdomain? Cool. Must be an interesting project.

In order to test this on local development, we are going to use [Valet](https://laravel.com/docs/5.8/valet). Let's say our Laravel project folder is in `~/Sites/multisite`. We can use that as our base path moving forward. With Valet, we can set up subdomains with `valet link`.

I'm going to pretend that we want to add support for a new subdomain for the French version of our site. I'm also going to assume that your valet TLD is `.localhost` and your project is called `multisite.localhost`. The domain we are adding in this case, it will be `fr.multisite.localhost`.

So in order to get that subdomain setup locally, we just go to our site folder and run `valet link fr.multisite`. This will allow `fr.multisite.localhost` to route to the same Laravel setup as `multisite.localhost`. Beauty!

Well, first things first. Let's make a helper to grab the subdomain from the request. This will come in handy for a lot of the future logic switching or setting application state on a per-request basis.

Let's use a `macro` to add a new method to the `Request`:

```diff
--- a/app/Providers/AppServiceProvider.php
+++ b/app/Providers/AppServiceProvider.php
@@ -3,6 +3,7 @@
 namespace App\Providers;

 use Illuminate\Support\ServiceProvider;
+use Illuminate\Http\Request;

 class AppServiceProvider extends ServiceProvider
 {
@@ -13,7 +14,14 @@ class AppServiceProvider extends ServiceProvider
      */
     public function register()
     {
-        //
+        // nice helper for getting the current subdomain
+        Request::macro('subdomain', function () {
+            $domain = request()->server->get('HTTP_HOST');
+            $split = explode('.', $domain, 3);
+
+            // get the subdomain or return null
+            return array_get($split, '0', '');
+        });
     }
```

Now any "request" instance will have a new `subdomain` method that we can call.

We need a way to organize the details of each domain. We can use a `config` for this. So we are going to make a new one and fill it with some details:

```diff
--- /dev/null
+++ b/config/multisite.php
@@ -0,0 +1,25 @@
+<?php
+
+return [
+    // we are going to set this in a future middleware
+    'active' => null,
+    'sites' => [
+        'en' => [
+            'default' => true,
+            'locale' => 'en',
+            'domain' => 'http://multisite.localhost',
+            'label' => 'English',
+        ],
+        'fr' => [
+            'locale' => 'fr',
+            'domain' => 'http://fr.multisite.localhost',
+            'label' => 'Français',
+        ],
+    ],
+];
```

Now, we need a way to map the requested domain to the correct locale. We take in our subdomain and then map it to the correct config item. In order to make this happen, we need to make a middleware. A middleware manipulates the request as it moves through our app. We aren't going to manipulate the request, we are just going to use the details in the request to set up more config settings.

Here we go:

```diff
--- /dev/null
+++ b/app/Http/Middleware/MultisiteMiddleware.php
@@ -0,0 +1,36 @@
+<?php
+
+namespace App\Http\Middleware;
+
+use Illuminate\Support\Facades\App;
+use Closure;
+
+class MultisiteMiddleware
+{
+    /**
+     * Handle an incoming request.
+     *
+     * @param  \Illuminate\Http\Request  $request
+     * @param  \Closure  $next
+     * @return mixed
+     */
+    public function handle($request, Closure $next)
+    {
+        $sites = collect(config('multisite.sites'));
+
+        $defaultSite = $sites->firstWhere('default', true);
+
+        $currentSite = $sites->get($request->subdomain(), $defaultSite);
+
+        // put this subdomain in the `env`
+        putenv('SUBDOMAIN=' . $currentSite['domain']);
+
+        // make it easier to access the current site config
+        config()->set('multisite.active', $currentSite);
+
+        // finally, set the app locale so translations load correctly
+        App::setLocale($currentSite['locale']);
+
+        return $next($request);
+    }
+}
```

We got our new middleware, so we can enable it in the HTTP kernel array:

```diff
--- a/app/Http/Kernel.php
+++ b/app/Http/Kernel.php
@@ -14,6 +14,7 @@ class Kernel extends HttpKernel
      * @var array
      */
     protected $middleware = [
+        \App\Http\Middleware\MultisiteMiddleware::class,
         \App\Http\Middleware\TrustProxies::class,
         \App\Http\Middleware\CheckForMaintenanceMode::class,
         \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
```

Great! When we make requests now, the `config('multisite.active')` is going to return a matched value from the multisite config. If the subdomain doesn't match, it will just return the default site config. In our case, the `en` one.

Since we are setting the locale, we are going to need to make sure there are translations available for all our text. We do this by adding new language files. These files are PHP files that just return plain arrays. These files go under `resources/lang/{locale}`. So for English (locale is `en`) we put our files under `resources/lang/en` and for French (or `fr`), we put the files under `resources/lang/fr`.

```diff
--- /dev/null
+++ b/resources/lang/en/multisite.php
@@ -0,0 +1,11 @@
+<?php
+
+return [
+    'site_title' => 'English Multisite',
+    'site_label' => 'English',
+    'welcome' => 'Welcome',
+    'welcome_message' => 'Welcome to the site. You can change the locale by changing to a supported subdomain.',
+    'switch_site' => 'Switch site',
+];
```

```diff
--- /dev/null
+++ b/resources/lang/fr/multisite.php
@@ -0,0 +1,11 @@
+<?php
+
+return [
+    'site_title' => 'Multisite Français',
+    'site_label' => 'Français',
+    'welcome' => 'Bienvenue',
+    'welcome_message' => 'Bienvenue sur le site. Vous pouvez changer les paramètres régionaux avec le sous-domaine.',
+    'switch_site' => 'Changer de site',
+];
```

We access these files in a similar way to a `config` value. We can use the `trans` function, or we can use the `@lang` blade directive. Either way, they take a string that represents the path to our array value that we want.

So, if I want to display the `site_title` from our `resources/lang/{locale}/multisite.php`, I would need to run `trans('multisite.site_title')`. Laravel will take care of the rest. If we are in a valid locale, great! We will get the correct language. If we are missing a translation for that key, it will fallback to whatever locale we have set in the `config/app.php` under the `fallback_locale` key. The default is `en`.

So how about the javascript side? How do we deal with JSON when working with this setup?

#### JavaScript and JSON

Well, if we set things up correctly, the domain should set the locale for us and as long as the URL is correct, we should be good to go!

We need to add an endpoint to get our JSON from. Let's just toss it into `routes/web.php` because we are animals like that:

```diff
--- a/routes/web.php
+++ b/routes/web.php
@@ -14,3 +14,7 @@
 Route::get('/', function () {
     return view('welcome');
 });
+
+Route::get('/locale', function () {
+    return response()->json(config('multisite.active'), 200);
+});
```

Here, you can see we are just returning whatever the active site is. This will be a JSON object of the active site config. Nice!

#### In Summation

Finally, let's update the `welcome.blade.php` just so we can see our changes in progress:

```html
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@lang('multisite.site_title')</title>
    </head>
    <body>
        <p>
            @foreach (config('multisite.sites') as $site)
                <a href="{{ $site['domain'] }}">{{ $site['label'] }}</a>
            @endforeach
        </p>
        <h1>@lang('multisite.welcome')</h1>
        <p>@lang('multisite.welcome_message')</p>

        <pre id="ajax"></pre>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // call that endpoint we created in our route
                fetch('/locale', {
                    credentials: 'include',
                    headers: {
                        accept: 'application/json',
                        // make sure we set the language explicitly
                        'accept-language': document.documentElement.lang
                    }
                })
                // do the fetch dance...
                .then((res) => res.json())
                .then((data) => {
                    const ajaxField = document.getElementById('ajax');

                    // prepend this to the output
                    ajaxField.innerHTML = '// loaded via ajax\n';
                    // put our JSON in but format it with 2 spaces
                    ajaxField.innerHTML += JSON.stringify(data, null, 2);
                });
            });
        </script>
    </body>
</html>
```

We should see something like this when we load up `multisite.localhost`:

<div class="center">
  <a href="/images/multisite-demo.gif" target="_blank" title="laravel multi-lingual site demo"><img alt="laravel multi-lingual site demo" src="/images/multisite-demo.gif"></a>
</div>

Wow! Amazing. So it works! Very nice. We now have the basis for a multilingual site based completely off subdomains and we didn't need to install any packages or do any weird magic!
