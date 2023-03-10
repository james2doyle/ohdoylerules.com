---
Title: "Versioning Service Workers In Hugo"
Date: "2022-08-21"
Category: "Snippets"
Template: "post"
Description: "How to use Hugo pipes and resources to version your service worker scripts"
Keywords: ["hugo", "sw", "service worker", "version", "bust", "clear", "script", "resources", "pipes"]
---

I have been running this blog on [Hugo](https://gohugo.io/) for quite some time. It is fast, well supported, and full of features. Until recently, one of the features I was not taking advantage of was the [pipes feature](https://gohugo.io/hugo-pipes/introduction/).

For all intents and purposes, pipes are used for processing strings and templates. They are "assets" that are used on your site. They live outside your theme at the top level `/assets` folder in your Hugo project. But you can also pull in remote assets via a URL and Hugo will pull that in when you build your site.

From the day I switched to Hugo, I was always [using a service worker to cache my sites static assets](https://developer.chrome.com/docs/workbox/caching-strategies-overview/#cache-only). The challenge I had was how to bust the cache. The old way I was doing this was to add a query string on the end of my `sw.js` URL. Something like this:

```js
navigator.serviceWorker.register('sw.js?{{ now.Format "2006-01-02" }}');
```

This seemed to work _just OK_. I think maybe in the last couple years the browser's changed and they would still cache this file even when the URL was different. It would not reload the service worker and therefore update the cache with new articles making my site seem stale even though there was new content.

I can't say for sure but it used to work in the past and then one day it did not...

Now that this is a known issue in my site, I need a way to bust the cache in the service worker file itself instead of relying on the file's URL.

What I need to do is treat the `sw.js` file as a template so I can pass in a variable and tell the file it is new each time I deploy.

In this case, it is pipes to the rescue! Here is the code that runs in my `footer.html` file:

```handlebars
<!-- Get the file in "assets/service-worker.js" -->
{{ $jsTemplate := resources.Get "service-worker.js" }}
<!-- We are making a new file called "sw.js" -->
{{ $js := $jsTemplate | resources.ExecuteAsTemplate "sw.js" . }}
<script defer>
  // register the service worker only when not in development
{{ if eq (printf "%v" $.Site.BaseURL) "http://localhost:1313/" }}
  console.info('on localhost - not loading service worker. Query: {{ $js.Permalink }} {{ now.Format "2006-01-02" }}');
{{ else }}
  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('{{ $js.Permalink }}');
  }
{{ end }}
</script>
```

That is all you need to read that asset file and create a URL so a "compiled" version. If you want to see this file, you can just visit the URL it creates: `http://localhost:1313/sw.js`

And here is the code in `assets/service-worker.js` that gets parsed as a go html template:

```handlebars
// cache name will change to the date of my last deploy
const CACHE_NAME = 'ODR-{{ now.Format "2006-01-02" }}';
const expectedCaches = [CACHE_NAME];

// the list of files that need to be cached
const staticFiles = [
  './',
  './css/site.css',
  './icons/logo.svg',
  './manifest.json',
  './favicon.ico',
];

/**
 * Performs install steps.
 */
addEventListener('install', (event) => {
  // install this service worker as soon as a new one is available
  skipWaiting();
  event.waitUntil(caches.open(CACHE_NAME).then(cache => cache.addAll(staticFiles)));
});

/**
 * Handles requests: responds with cache or else network.
 */
addEventListener('fetch', (event) => {
  event.respondWith(caches.match(event.request).then(response => response || fetch(event.request)));
});

/**
 * Cleans up static cache and activates the Service Worker.
 */
addEventListener('activate', (event) => {
  event.waitUntil(caches.keys().then(keys => Promise.all(keys.map((key) => {
    if (!expectedCaches.includes(key)) {
      return caches.delete(key);
    }
  }))).then(() => {
    console.log(`${CACHE_NAME} now ready to handle fetches!`);
    return clients.claim();
  }));
});
```

As you will be able to see if you visited the file that gets generated at `http://localhost:1313/sw.js`, the `CACHE_NAME` is now being defined with a value that includes todays date!

Something like this:

```js
// you should see a real string being assigned now and not a go template interpolation
const CACHE_NAME = 'ODR-2022-08-21';
const expectedCaches = [CACHE_NAME];

//... the rest of the file...
```

Now when you build the site, this new piped/resource file will generated too and properly linked in your templates.

Once I got this all setup, I can now deploy my site and know for sure that my service worker cache will be busted since it will be created with a key that includes the date of my deploy.
