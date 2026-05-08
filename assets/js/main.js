// ===========================
// MENU MOBILE
// ===========================
const menuToggle = document.querySelector(".menu-toggle");
const navMenu = document.querySelector("nav ul");

if (menuToggle) {
    menuToggle.addEventListener("click", () => {
        navMenu.classList.toggle("active");
    });
}


// ===========================
// SLIDER RÉALISATIONS
// ===========================
const slider = document.querySelector(".slider");
const slides = document.querySelectorAll(".slide");
const nextBtn = document.querySelector(".next");
const prevBtn = document.querySelector(".prev");

let currentIndex = 0;
let slideWidth = slides.length > 0 ? slides[0].offsetWidth + 20 : 0;

function updateSlider() {
    if (slider) {
        slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
    }
}

if (nextBtn) {
    nextBtn.addEventListener("click", () => {
        if (currentIndex < slides.length - 1) {
            currentIndex++;
        } else {
            currentIndex = 0;
        }
        updateSlider();
    });
}

if (prevBtn) {
    prevBtn.addEventListener("click", () => {
        if (currentIndex > 0) {
            currentIndex--;
        } else {
            currentIndex = slides.length - 1;
        }
        updateSlider();
    });
}

// AUTO SLIDE
setInterval(() => {
    if (slides.length > 1) {
        currentIndex = (currentIndex + 1) % slides.length;
        updateSlider();
    }
}, 5000);


// ===========================
// FILTRE PAR CATÉGORIE RÉALISATIONS
// ===========================
const filterButtons = document.querySelectorAll(".filter-btn");
const realisationCards = document.querySelectorAll(".realisation-card");

filterButtons.forEach(button => {
    button.addEventListener("click", () => {
        const category = button.dataset.category;

        realisationCards.forEach(card => {
            if (category === "all" || card.dataset.category === category) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });
    });
});


// ===========================
// LIGHTBOX GALERIE
// ===========================
const galleryImages = document.querySelectorAll(".gallery img");

galleryImages.forEach(img => {
    img.addEventListener("click", () => {
        const lightbox = document.createElement("div");
        lightbox.id = "lightbox";
        lightbox.style.position = "fixed";
        lightbox.style.top = "0";
        lightbox.style.left = "0";
        lightbox.style.width = "100%";
        lightbox.style.height = "100%";
        lightbox.style.background = "rgba(0,0,0,0.9)";
        lightbox.style.display = "flex";
        lightbox.style.alignItems = "center";
        lightbox.style.justifyContent = "center";
        lightbox.style.zIndex = "9999";

        const image = document.createElement("img");
        image.src = img.src;
        image.style.maxWidth = "90%";
        image.style.maxHeight = "90%";
        image.style.borderRadius = "10px";

        lightbox.appendChild(image);

        lightbox.addEventListener("click", () => {
            lightbox.remove();
        });

        document.body.appendChild(lightbox);
    });
});


// ===========================
// ANIMATION STATISTIQUES
// ===========================
const counters = document.querySelectorAll(".counter");

counters.forEach(counter => {
    counter.innerText = "0";

    const updateCounter = () => {
        const target = +counter.getAttribute("data-target");
        const current = +counter.innerText;

        const increment = target / 100;

        if (current < target) {
            counter.innerText = `${Math.ceil(current + increment)}`;
            setTimeout(updateCounter, 30);
        } else {
            counter.innerText = target;
        }
    };

    updateCounter();
});


// ===========================
// FORMULAIRE CONTACT
// ===========================
const contactForm = document.querySelector("#contactForm");

if (contactForm) {
    contactForm.addEventListener("submit", (e) => {
        const name = document.querySelector("#name").value.trim();
        const email = document.querySelector("#email").value.trim();
        const message = document.querySelector("#message").value.trim();

        if (!name || !email || !message) {
            e.preventDefault();
            alert("Veuillez remplir tous les champs.");
        }
    });
}


// ===========================
// PRÉVISUALISATION IMAGE ADMIN
// ===========================
const imageInput = document.querySelector("#imageUpload");
const preview = document.querySelector("#preview");

if (imageInput && preview) {
    imageInput.addEventListener("change", function() {
        preview.innerHTML = "";

        Array.from(this.files).forEach(file => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const img = document.createElement("img");
                img.src = e.target.result;
                img.style.width = "120px";
                img.style.margin = "10px";
                img.style.borderRadius = "8px";
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    });
}
