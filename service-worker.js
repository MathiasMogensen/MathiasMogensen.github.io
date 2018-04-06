self.addEventListener('fetch', function(e){
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