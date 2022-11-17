import { menuButtons } from "./MenuButton";

const mainHeader = document.querySelector(".main-header");
export const mainHeaderHome = document.querySelector(".main-header--home");
const pixelToWatch = document.querySelector(".pixel");
const loginButton = mainHeaderHome?.querySelector(
  ".main-nav ul li:last-child a.login-btn"
);

const pixelObserver = new IntersectionObserver((entries) => {
  if (entries[0].boundingClientRect.y < 0) {
    mainHeaderHome?.classList.add("main-header--scrolled");
    mainHeader?.classList.add("main-header--scrolled");
    menuButtons.forEach((menuButton) => {
      menuButton?.classList.add("menu-btn--scrolled");
    });
    loginButton?.classList.remove("btn--white");
    loginButton?.classList.add("btn--dark-blue");
  } else {
    mainHeaderHome?.classList.remove("main-header--scrolled");
    mainHeader?.classList.remove("main-header--scrolled");
    menuButtons.forEach((menuButton) => {
      menuButton?.classList.remove("menu-btn--scrolled");
    });
    loginButton?.classList.remove("btn--dark-blue");
    loginButton?.classList.add("btn--white");
  }
});

if (pixelToWatch) {
  pixelObserver.observe(pixelToWatch);
}
