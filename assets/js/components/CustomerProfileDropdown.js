const customerProfileDropdownToggle1 = document.querySelector(
  "#customer-profile-dropdown-1"
);
const customerProfileDropdownToggle2 = document.querySelector(
  "#customer-profile-dropdown-2"
);

const customerProfileDropdown1 = document.querySelector(
  "#customer-profile-dropdown__box-1"
);
const customerProfileDropdown2 = document.querySelector(
  "#customer-profile-dropdown__box-2"
);

customerProfileDropdownToggle1?.addEventListener("click", () => {
  if (
    customerProfileDropdown1?.classList.contains(
      "customer-profile-dropdown__box--open"
    )
  ) {
    customerProfileDropdown1?.classList.remove(
      "customer-profile-dropdown__box--open"
    );
    customerProfileDropdown1?.classList.add(
      "customer-profile-dropdown__box--close"
    );

    setTimeout(() => {
      customerProfileDropdown1?.classList.remove(
        "customer-profile-dropdown__box--close"
      );
    }, 200);
  } else {
    customerProfileDropdown1?.classList.add(
      "customer-profile-dropdown__box--open"
    );
  }
});

customerProfileDropdownToggle2?.addEventListener("click", () => {
  if (
    customerProfileDropdown2?.classList.contains(
      "customer-profile-dropdown__box--open"
    )
  ) {
    customerProfileDropdown2?.classList.remove(
      "customer-profile-dropdown__box--open"
    );
    customerProfileDropdown2?.classList.add(
      "customer-profile-dropdown__box--close"
    );

    setTimeout(() => {
      customerProfileDropdown2?.classList.remove(
        "customer-profile-dropdown__box--close"
      );
    }, 200);
  } else {
    customerProfileDropdown2?.classList.add(
      "customer-profile-dropdown__box--open"
    );
  }
});
