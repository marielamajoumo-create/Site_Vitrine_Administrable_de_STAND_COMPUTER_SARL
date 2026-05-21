const CACHE_NAME = "standcomputer-v1";

const urlsToCache = [
  "/StandComputer/",
  "/StandComputer/services",
  "/StandComputer/realisations",
  "/StandComputer/formations",
  "/StandComputer/blog",
  
  "/StandComputer/logo.jpeg",
  "/StandComputer/assets/icons/icon-192.jpeg",
  "/StandComputer/assets/icons/icon-512.jpeg"


];

self.addEventListener("install", event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(urlsToCache))
  );
});

self.addEventListener("fetch", event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => response || fetch(event.request))
  );
});