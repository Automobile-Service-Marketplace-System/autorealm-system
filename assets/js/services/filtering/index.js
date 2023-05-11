import "./dashboard-product-filtering";
import "./dashboard-order-filtering";
import "./dashboard-supplier-filtering";
import "./dashboard-review-filtering";
import "./site-product-filtering";

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

//get the form in the filters container and add event listener to the reset type button

    const filterForm = document.querySelector('.filters form');
    const resetButton = filterForm.querySelector('button[type="reset"]');

    resetButton.addEventListener('click', function(event) {

        // console.log("reset clicked")
        const textInputs = filterForm.querySelectorAll('input[type="text"]')
        console.log(textInputs)

        textInputs.forEach((input) => {
            if(input.value) {
              // console.log(input.value)
                input.removeAttribute('value')
            }
        })

        //remove selected attribute from all the options in the form
       const optionElements = filterForm.querySelectorAll('option');

         optionElements.forEach((option) => {
            if(option.selected) {
                option.removeAttribute('selected');
            }
         })

        const dateInputs = filterForm.querySelectorAll('input[type="date"]')
        dateInputs.forEach((input) => {
            if(input.value) {
                input.removeAttribute('value')
            }
        })

    });






}


