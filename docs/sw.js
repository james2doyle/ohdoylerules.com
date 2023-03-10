const CACHE_NAME = 'ODR-2023-03-09';
const expectedCaches = [CACHE_NAME];

// the list of files that need to be cached
const staticFiles = [
  './',
  './css/new.light.css',
  './css/new.dark.css',
  './icons/logo.svg',
  './icons/logo-light.svg',
  './icons/logo-dark.svg',
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
