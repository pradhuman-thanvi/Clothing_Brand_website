// Navbar menu toggle
const menuBtn = document.getElementById("menu-btn");
const navLinks = document.getElementById("nav-links");
const menuBtnIcon = menuBtn.querySelector("i");

menuBtn.addEventListener("click", () => {
  navLinks.classList.toggle("open");

  const isOpen = navLinks.classList.contains("open");
  menuBtnIcon.setAttribute("class", isOpen ? "ri-close-line" : "ri-menu-line");
});

// Close nav menu when a link is clicked (on mobile)
navLinks.querySelectorAll("a").forEach((link) => {
  link.addEventListener("click", () => {
    navLinks.classList.remove("open");
    menuBtnIcon.setAttribute("class", "ri-menu-line");
  });
});

// ScrollReveal animations
const scrollRevealOption = {
  origin: "bottom",
  distance: "50px",
  duration: 1000,
};

ScrollReveal().reveal(".header__image img", {
  ...scrollRevealOption,
  origin: "right",
});
ScrollReveal().reveal(".header__content h1", {
  ...scrollRevealOption,
  delay: 500,
});
ScrollReveal().reveal(".header__content p", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".header__btns", {
  ...scrollRevealOption,
  delay: 1500,
});
ScrollReveal().reveal(".arrival__card", {
  ...scrollRevealOption,
  interval: 500,
});
ScrollReveal().reveal(".sale__image img", {
  ...scrollRevealOption,
  origin: "left",
});
ScrollReveal().reveal(".sale__content h2", {
  ...scrollRevealOption,
  delay: 500,
});
ScrollReveal().reveal(".sale__content p", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".sale__content h4", {
  ...scrollRevealOption,
  delay: 1000,
});
ScrollReveal().reveal(".sale__btn", {
  ...scrollRevealOption,
  delay: 1500,
});
ScrollReveal().reveal(".favourite__card", {
  ...scrollRevealOption,
  interval: 500,
});

// Duplicate banner items for infinite scroll effect
const banner = document.querySelector(".banner__container");
const bannerItems = Array.from(banner.children);

bannerItems.forEach((item) => {
  const clone = item.cloneNode(true);
  clone.setAttribute("aria-hidden", "true");
  banner.appendChild(clone);
});
