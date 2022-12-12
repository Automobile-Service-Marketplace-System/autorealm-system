import {menuButtons} from "./MenuButton";

const mainHeader = document.querySelector(".main-header");
export const mainHeaderHome = document.querySelector(".main-header--home");
const employeeHeader = document.querySelector(".employee-dashboard-container__content-header");
const employeeDashboardPage = document.querySelector(".employee-dashboard-page");
const pixelToWatch = document.querySelector(".pixel");
const employeePixelToWatch = document.querySelector(".employee-pixel");
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


const employeePixelObserver = new IntersectionObserver((entries) => {
        const y = entries[0].boundingClientRect.y;
        if (y < 55) {
            employeeHeader?.classList.add("employee-dashboard-container__content-header--scrolled");
            employeeDashboardPage?.classList.add("employee-dashboard-page--scrolled");
        } else {
            employeeHeader?.classList.remove("employee-dashboard-container__content-header--scrolled");
            employeeDashboardPage?.classList.remove("employee-dashboard-page--scrolled");
        }
    }, {
        root: employeeDashboardPage,
        threshold: 0.5
    }
)

if (employeePixelToWatch) {
    employeePixelObserver.observe(employeePixelToWatch);
}