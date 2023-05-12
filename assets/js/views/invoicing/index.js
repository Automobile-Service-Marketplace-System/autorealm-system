import "./handle-product-section"
import "./handle-service-section"
import "./handle-total-section"
import "./load-from-jobcard"
import "./manually-add-customer-details"


const printInvoiceButton = document.querySelector('#print-invoice')

if (printInvoiceButton) {
    printInvoiceButton.addEventListener('click', () => {
        window.print()
    })
}