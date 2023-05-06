/**
 * @type {HTMLDivElement | null}
 */
const ReviewFiltersContainer = document.querySelector('#dashboard-review-filter');

if(ReviewFiltersContainer) {
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdownTrigger = document.querySelector('.filters__dropdown-trigger');
    /**
     * @type {HTMLDivElement}
     */
    const filterDropdown = document.querySelector('.filters__dropdown');

    filterDropdownTrigger?.addEventListener("click", () => {
        filterDropdown.classList.toggle('review-filters__dropdown--active');
    })


}