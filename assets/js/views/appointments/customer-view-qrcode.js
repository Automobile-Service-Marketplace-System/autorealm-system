import {htmlToElement} from "../../utils";
import {Modal} from "../../components/Modal";

/**
 * @type {NodeListOf<HTMLButtonElement>}
 */
const qrCodeButtons = document.querySelectorAll(".appointment-get-qrcode")

qrCodeButtons.forEach(button => {

    button.addEventListener('click', () => {

        const qrCodeURL = button.dataset.qrcode

        const qrCodeModal = htmlToElement(`
    <div>
        <div>QR Code for the appointment
            <button class="modal-close-btn about-to-spin">
                <i class="fa fa-xmark"></i>
            </button>
        </div>
        <div>
            <img src="${qrCodeURL}" alt="QR code">
        </div>
    </div> 
    `)

        Modal.show({
            closable: true,
            key: "qr-code-modal",
            content: qrCodeModal
        })

    })

})