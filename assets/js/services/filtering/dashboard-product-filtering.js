/**
 * @type {HTMLDivElement | null}
 */
const ProductFiltersContainer = document.querySelector('#dashboard-product-filters');

if(ProductFiltersContainer) {
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdownTrigger = document.querySelector('.filters__dropdown-trigger');
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdown = document.querySelector('.filters__dropdown');

    filterDropdownTrigger?.addEventListener("click", () => {
        filterDropdown.classList.toggle('product-filters__dropdown--active');
    })


}