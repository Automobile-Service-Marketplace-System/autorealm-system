/**
 * @type {HTMLDivElement | null}
 */
const siteProductFiltersContainer = document.querySelector('#site-product-filters');

if(siteProductFiltersContainer) {
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