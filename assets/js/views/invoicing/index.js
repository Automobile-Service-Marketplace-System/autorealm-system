import "./handle-product-section"
import "./handle-service-section"
import "./handle-total-section"


const printInvoiceButton = document.querySelector('#print-invoice')

if (printInvoiceButton) {
    printInvoiceButton.addEventListener('click', () => {
        window.print()
    })
}