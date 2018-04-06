self.addEventListener('install', function(event) {
    event.waitUntil(
        caches.open(cacheName).then(function(cache) {
          return cache.addAll(
            [
              '/assets/css/main.css',
              '/assets/js/maps.js',
              '/index.html'
            ]
          );
        })
      );
});
self.addEventListener('fetch', function(event) {
    event.respondWith(caches.match(event.request));
  });