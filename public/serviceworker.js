var CACHE_NAME = 'my-site-cache-v1';
var urlsToCache = [
  'https://usis.mangoads.com.vn/amp/gioi-thieu/gioi-thieu-usis',
];

self.addEventListener('install', function(event) {
  // Perform install steps
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(function(cache) {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});