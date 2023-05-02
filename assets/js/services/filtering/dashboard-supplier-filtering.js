/**
 * @type {HTMLDivElement | null}
 */
const SupplierFiltersContainer = document.querySelector('#dashboard-supplier-filters');


if(SupplierFiltersContainer) {
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdownTrigger = document.querySelector('.filters__dropdown-trigger');
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdown = document.querySelector('.filters__dropdown');

    filterDropdownTrigger?.addEventListener("click", () => {

        filterDropdown.classList.toggle('supplier-filters__dropdown--active');
    })


}