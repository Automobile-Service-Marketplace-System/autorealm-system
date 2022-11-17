const employeeProfileDropdownToggle1 = document.querySelector(
    "#employee-profile-dropdown-1"
);
const employeeProfileDropdownToggle2 = document.querySelector(
    "#employee-profile-dropdown-2"
);

const employeeProfileDropdown1 = document.querySelector(
    "#employee-profile-dropdown__box-1"
);
const employeeProfileDropdown2 = document.querySelector(
    "#employee-profile-dropdown__box-2"
);

employeeProfileDropdownToggle1?.addEventListener("click", () => {
    if (
        employeeProfileDropdown1?.classList.contains(
            "employee-profile-dropdown__box--open"
        )
    ) {
        employeeProfileDropdown1?.classList.remove(
            "employee-profile-dropdown__box--open"
        );
        employeeProfileDropdown1?.classList.add(
            "employee-profile-dropdown__box--close"
        );

        setTimeout(() => {
            employeeProfileDropdown1?.classList.remove(
                "employee-profile-dropdown__box--close"
            );
        }, 200);
    } else {
        employeeProfileDropdown1?.classList.add(
            "employee-profile-dropdown__box--open"
        );
    }
});

employeeProfileDropdownToggle2?.addEventListener("click", () => {
    if (
        employeeProfileDropdown2?.classList.contains(
            "employee-profile-dropdown__box--open"
        )
    ) {
        employeeProfileDropdown2?.classList.remove(
            "employee-profile-dropdown__box--open"
        );
        employeeProfileDropdown2?.classList.add(
            "employee-profile-dropdown__box--close"
        );

        setTimeout(() => {
            employeeProfileDropdown2?.classList.remove(
                "employee-profile-dropdown__box--close"
            );
        }, 200);
    } else {
        employeeProfileDropdown2?.classList.add(
            "employee-profile-dropdown__box--open"
        );
    }
});
