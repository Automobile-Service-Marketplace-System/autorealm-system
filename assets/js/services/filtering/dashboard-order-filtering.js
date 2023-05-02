/**
 * @type {HTMLDivElement | null}
 */
const OrderFiltersContainer = document.querySelector('#dashboard-order-filters');

if(OrderFiltersContainer) {
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdownTrigger = document.querySelector('.filters__dropdown-trigger');
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdown = document.querySelector('.filters__dropdown');

    filterDropdownTrigger?.addEventListener("click", () => {
        filterDropdown.classList.toggle('order-filters__dropdown--active');
    })


}