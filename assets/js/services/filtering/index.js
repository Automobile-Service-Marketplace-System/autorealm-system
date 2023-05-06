import "./dashboard-product-filtering";
import "./dashboard-order-filtering";
import "./dashboard-supplier-filtering";
import "./dashboard-review-filtering";

/**
 * @type {HTMLDivElement | null}
 */
const filtersContainer = document.querySelector('.filters');

if(filtersContainer) {
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdownTrigger = document.querySelector('.filters__dropdown-trigger');
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdown = document.querySelector('.filters__dropdown');

    filterDropdownTrigger?.addEventListener("click", () => {
        filterDropdownTrigger.classList.toggle('filters__dropdown-trigger--active');
        filterDropdown.classList.toggle('filters__dropdown--active');
    })


}


