const slides = document.querySelectorAll(".slide");
const navButtons = document.querySelectorAll(".slider-nav button");
let currentSlide = 0;

function showSlide(index) {
  slides[currentSlide].classList.remove("active");
  navButtons[currentSlide].classList.remove("active");
  slides[index].classList.add("active");
  navButtons[index].classList.add("active");
  currentSlide = index;
}

function nextSlide() {
  showSlide((currentSlide + 1) % slides.length);
}

navButtons.forEach((button, index) => {
  button.addEventListener("click", () => showSlide(index));
});

// Auto-advance slides every 5 seconds
setInterval(nextSlide, 5000);



