export const menuButtons = document.querySelectorAll(".menu-btn");
const dropdownNav = document.querySelector(".dropdown-nav");
const employeeMenuButton = document.querySelector(".employee-menu-btn");
const employeeDashboardContainer = document.querySelector(".employee-dashboard-container")
const employeeSidebar = document.querySelector(".employee-dashboard-container__sidebar");
const employeeSidebarNav = document.querySelector(".employee-dashboard-container__sidebar nav")

menuButtons.forEach((menuButton) => {
    menuButton.addEventListener("click", () => {
        menuButton.classList.toggle("menu-btn--active");
        dropdownNav.classList.toggle("dropdown-nav--active");
        document.body.style.overflowY = dropdownNav.classList.contains("dropdown-nav--active") ? "hidden" : "auto";
    });
});


console.log(`Employee menu button: ${employeeMenuButton}`)

employeeMenuButton?.addEventListener("click", () => {
    console.log("clicked")
    employeeMenuButton?.classList.toggle("employee-menu-btn--active");
    if (window.innerWidth < 768) {
        if (employeeDashboardContainer?.classList.contains("employee-dashboard-container--close") || !employeeDashboardContainer?.classList.contains("employee-dashboard-container--open")) {
            employeeMenuButton?.classList.add("employee-menu-btn--active");
            employeeDashboardContainer?.classList.remove("employee-dashboard-container--close")
            employeeDashboardContainer?.classList.add("employee-dashboard-container--open")
            if (employeeSidebarNav) employeeSidebarNav.style.alignItems = "flex-start";
        } else {
            employeeMenuButton?.classList.remove("employee-menu-btn--active");
            employeeDashboardContainer?.classList.remove("employee-dashboard-container--open")
            employeeDashboardContainer?.classList.add("employee-dashboard-container--close")


        }
    } else if (window.innerWidth >= 768 && window.innerWidth <= 1200) {
        if (employeeDashboardContainer?.classList.contains("employee-dashboard-container--close") || !employeeDashboardContainer?.classList.contains("employee-dashboard-container--open")) {
            employeeMenuButton?.classList.add("employee-menu-btn--active");
            employeeDashboardContainer?.classList.remove("employee-dashboard-container--close")
            if (employeeSidebarNav) employeeSidebarNav.style.alignItems = "flex-start";
            employeeDashboardContainer?.classList.add("employee-dashboard-container--open")
        } else {
            employeeMenuButton?.classList.remove("employee-menu-btn--active");
            employeeDashboardContainer?.classList.remove("employee-dashboard-container--open")
            employeeDashboardContainer?.classList.add("employee-dashboard-container--close")
            setTimeout(() => {
                if (employeeSidebarNav) employeeSidebarNav.style.alignItems = "center"
            }, 150)
        }
    } else if (window.innerWidth > 1200) {
        if (employeeDashboardContainer?.classList.contains("employee-dashboard-container--close")) {
            employeeMenuButton?.classList.add("employee-menu-btn--active");
            if (employeeSidebarNav) employeeSidebarNav.style.alignItems = "flex-start"
            employeeDashboardContainer?.classList.remove("employee-dashboard-container--close")
            employeeDashboardContainer?.classList.add("employee-dashboard-container--open")
        } else {
            employeeMenuButton?.classList.remove("employee-menu-btn--active");

            employeeDashboardContainer?.classList.remove("employee-dashboard-container--open")
            employeeDashboardContainer?.classList.add("employee-dashboard-container--close")
            setTimeout(() => {
                if (employeeSidebarNav) employeeSidebarNav.style.alignItems = "center"
            }, 150)


        }
    }
});

