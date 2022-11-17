export const menuButtons = document.querySelectorAll(".menu-btn");
const dropdownNav = document.querySelector(".dropdown-nav");
const employeeMenuButton = document.querySelector(".employee-menu-btn");
const employeeSidebar = document.querySelector(".employee-dashboard-container__sidebar");
const employeeSidebarNav = document.querySelector(".employee-dashboard-container__sidebar nav")

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


employeeMenuButton?.addEventListener("click", () => {
    employeeMenuButton?.classList.toggle("employee-menu-btn--active");
    if (employeeSidebar?.classList.contains("employee-dashboard-container__sidebar--open")) {
        employeeSidebar?.classList.remove("employee-dashboard-container__sidebar--open");
        if (window.innerWidth > 768) {
            employeeSidebar?.classList.add("employee-dashboard-container__sidebar--close");

            setTimeout(() => {
                if (employeeSidebarNav)
                    employeeSidebarNav.style.alignItems = "center";
            }, 200)

        }
    } else {
        employeeSidebar?.classList.add("employee-dashboard-container__sidebar--open");
        if (window.innerWidth > 768 && employeeSidebar?.classList.contains("employee-dashboard-container__sidebar--close")) {
            employeeSidebar?.classList.remove("employee-dashboard-container__sidebar--close");
            if (employeeSidebarNav)
                employeeSidebarNav.style.alignItems = "flex-start";
        }
    }
});

