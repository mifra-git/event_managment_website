// ================= NAVBAR ACTIVE LINK ON SCROLL =================
const sections = document.querySelectorAll("section");
const navLinks = document.querySelectorAll("nav ul li a");

window.addEventListener("scroll", () => {
    let current = "";

    sections.forEach(section => {
        const sectionTop = section.offsetTop - 100;
        if (pageYOffset >= sectionTop) {
            current = section.getAttribute("id");
        }
    });

    navLinks.forEach(link => {
        link.classList.remove("active");
        if (link.getAttribute("href") === "#" + current) {
            link.classList.add("active");
        }
    });
});

// ================= FORM SUBMISSION ALERTS =================
const bookingForm = document.getElementById("bookingForm");
if (bookingForm) {
    bookingForm.addEventListener("submit", function(e){
        e.preventDefault();
        alert("Booking submitted successfully!");
        bookingForm.reset(); // Reset form after submission
    });
}

const contactForm = document.getElementById("contactForm");
if (contactForm) {
    contactForm.addEventListener("submit", function(e){
        e.preventDefault();
        alert("Message sent successfully!");
        contactForm.reset(); // Reset form after submission
    });
}

// ================= CUSTOMER REVIEWS SLIDER =================
document.addEventListener("DOMContentLoaded", () => {
    const slider = document.querySelector('.reviews-slider');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');

    if (!slider || !prevBtn || !nextBtn) return; // Safety check

    // Function to calculate card width dynamically
    function getCardWidth() {
        const card = slider.querySelector('.review-card');
        if (!card) return 0;
        const cardStyle = getComputedStyle(card);
        const marginRight = parseInt(cardStyle.marginRight) || 0;
        return card.offsetWidth + marginRight;
    }

    // Next button scroll
    nextBtn.addEventListener('click', () => {
        const cardWidth = getCardWidth();
        slider.scrollBy({ left: cardWidth, behavior: 'smooth' });
    });

    // Prev button scroll
    prevBtn.addEventListener('click', () => {
        const cardWidth = getCardWidth();
        slider.scrollBy({ left: -cardWidth, behavior: 'smooth' });
    });

    // Optional: Auto-scroll slider every 5 seconds
    // setInterval(() => {
    //     const cardWidth = getCardWidth();
    //     slider.scrollBy({ left: cardWidth, behavior: 'smooth' });
    // }, 5000);
});

console.log("Event Management Website Loaded");
