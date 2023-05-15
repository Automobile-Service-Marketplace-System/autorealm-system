/**
 * @type {HTMLDivElement | null}
 */
const AdmittingFiltersContainer = document.querySelector('#dashboard-admitting-filters');

if(AdmittingFiltersContainer) {
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdownTrigger = document.querySelector('.filters__dropdown-trigger');
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdown = document.querySelector('.filters__dropdown');

    filterDropdownTrigger?.addEventListener("click", () => {
        filterDropdown.classList.toggle('analytic-filters__dropdown--active');
    })


}