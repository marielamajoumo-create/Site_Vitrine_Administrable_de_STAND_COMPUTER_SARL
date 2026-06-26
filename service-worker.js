const CACHE_NAME = "standcomputer-v1";
const urlsToCache = [
  "/StandComputer/",
  "/StandComputer/services",
  "/StandComputer/realisations",
  "/StandComputer/formations",
  "/StandComputer/blog",
  "/StandComputer/a-propos",
  "/StandComputer/contact",

  /*
"/StandComputer/deconnexion",
"/StandComputer/connexion",
  "/StandComputer/tableau-de-bord",
"/StandComputer/ajouter-un-service",
"/StandComputer/gerer-les-services",
"/StandComputer/modifier-ce-service",
"/StandComputer/supprimer-service",

"/StandComputer/ajouter-une-realisation",
"/StandComputer/gerer-les-realisations",
"/StandComputer/modifier-cette-realisation",
"/StandComputer/modifier-les-images-de-cette-realisation",
"/StandComputer/modifier-les-videos-de-cette-realisation",
"/StandComputer/ajouter-une-formation",
"/StandComputer/gerer-les-formations",
"/StandComputer/modifier-cette-formation",
"/StandComputer/supprimer-formation",

"/StandComputer/ajouter-un-article",
"/StandComputer/gerer-les-articles",
"/StandComputer/modifier-cet-article",
"/StandComputer/supprimer-article",

"/StandComputer/ajouter-une-categorie",
"/StandComputer/gerer-les-categories",
"/StandComputer/modifier-cette-categorie",
"/StandComputer/supprimer-categorie",

"/StandComputer/ajouter-un-contact",
"/StandComputer/gerer-les-contacts",
"/StandComputer/modifier-ce-contact",
"/StandComputer/supprimer-contact",

"/StandComputer/ajouter-une-horaire",
"/StandComputer/gerer-les-horaires",
"/StandComputer/modifier-cet-horaire",
"/StandComputer/supprimer-horaire",

"/StandComputer/gerer-les-formulaires-de-contact",
"/StandComputer/messages",

"/StandComputer/modifier-les-statistiques", */


  
  "/StandComputer/logo.jpeg",
  "/StandComputer/assets/icons/icon-192.png",
  "/StandComputer/assets/icons/icon-512.png"


];

self.addEventListener("install", event => {

    event.waitUntil(

        caches.open(CACHE_NAME)
        .then(async cache => {

            for (const url of urlsToCache) {

                try {

                    await cache.add(
                        new Request(url, {
                            cache: "reload"
                        })
                    );

                    console.log("✅", url);

                } catch (err) {

                    console.error("❌", url, err);

                }

            }

        })

    );

});


self.addEventListener("activate", event => {

    event.waitUntil(

        caches.keys().then(keys => {

            return Promise.all(

                keys.map(key => {

                    if (key !== CACHE_NAME) {

                        return caches.delete(key);

                    }

                })

            );

        })

    );

});




self.addEventListener("fetch", event => {

    event.respondWith(

        caches.match(event.request)
        .then(response => {

            if (response) {

                return response;

            }

            return fetch(event.request);

        })

    );

});