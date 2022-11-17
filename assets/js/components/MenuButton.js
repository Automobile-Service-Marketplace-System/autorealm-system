export const menuButtons = document.querySelectorAll(".menu-btn");
const dropdownNav = document.querySelector(".dropdown-nav");

menuButtons.forEach((menuButton) => {
  menuButton.addEventListener("click", () => {
    menuButton.classList.toggle("menu-btn--active");
    dropdownNav.classList.toggle("dropdown-nav--active");
    document.body.style.overflowY = dropdownNav.classList.contains(
      "dropdown-nav--active"
    )
      ? "hidden"
      : "auto";
  });
});
