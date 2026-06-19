const CACHE_NAME = 'velora-vms-v2';

const STATIC_ASSETS = [
    '/assets/vendor/css/core.css',
    '/assets/css/demo.css',
    '/assets/vendor/js/bootstrap.js',
    '/assets/vendor/js/helpers.js',
    '/assets/vendor/js/menu.js',
    '/assets/js/main.js',
    '/assets/js/config.js',
    '/assets/vendor/libs/jquery/jquery.js',
    '/assets/vendor/libs/popper/popper.js',
    '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css',
    '/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js',
];

// Install
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => {
            return cache.addAll(STATIC_ASSETS);
        })
    );
    self.skipWaiting();
});

// Activate
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) => {
            return Promise.all(
                keys.filter(k => k !== CACHE_NAME).map(k => caches.delete(k))
            );
        })
    );
    self.clients.claim();
});

// Fetch
self.addEventListener('fetch', (event) => {
    if (event.request.method !== 'GET') return;

    const url = new URL(event.request.url);

    // CSS/JS/Images — Cache First
    if (
        url.pathname.startsWith('/assets/') ||
        url.pathname.startsWith('/fonts/') ||
        url.hostname === 'cdn.jsdelivr.net' ||
        url.hostname === 'fonts.googleapis.com' ||
        url.hostname === 'fonts.gstatic.com'
    ) {
        event.respondWith(
            caches.match(event.request).then(cached => {
                return cached || fetch(event.request).then(response => {
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => cache.put(event.request, clone));
                    return response;
                });
            })
        );
        return;
    }

    // HTML Pages — Network First, Cache Fallback
    if (event.request.destination === 'document') {
        event.respondWith(
            fetch(event.request)
                .then(response => {
                    // Cache every visited page
                    const clone = response.clone();
                    caches.open(CACHE_NAME).then(cache => {
                        cache.put(event.request, clone);
                    });
                    return response;
                })
                .catch(() => {
                    // Offline — serve from cache
                    return caches.match(event.request).then(cached => {
                        return cached || caches.match('/offline');
                    });
                })
        );
        return;
    }
});

// Background sync
self.addEventListener('sync', (event) => {
    if (event.tag === 'sync-vehicles') {
        event.waitUntil(
            self.clients.matchAll().then(clients => {
                clients.forEach(client => {
                    client.postMessage({ type: 'SYNC_REQUIRED' });
                });
            })
        );
    }
});