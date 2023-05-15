import {htmlToElement} from "../../utils";
import Notifier from "../../components/Notifier";
import {Modal} from "../../components/Modal";

/**
 * @type {NodeListOf<HTMLButtonElement>}
 */
const qrCodeCancelButtons = document.querySelectorAll(".customer-appointment-delete-btn")

qrCodeCancelButtons.forEach((btn) => {
    btn.addEventListener('click', () => {

        const appointmentConfirmationModal = htmlToElement(
            `
            <div>
                <div class="flex items-center justify-between">
                    <h2>Confirmation</h2>
                    <button class="modal-close-btn rotate-on-hover-btn">
                        <i class="fas fa-xmark"></i>
                    </button>
                </div>
                <div>
                    Are you sure you want to cancel this appointment?
                </div>
                <div class="flex items-center justify-between">
                    <button class="btn btn--thin btn--danger btn--text" id="confirm-cancel-appointment-btn">
                        Confirm
                    </button>
                    <button class="btn btn--thin about-to-spin" id="appointment-delete-confirm">
                        Confirm
                    </button>
                </div>
            </div>
            `
        )


        /**
         * @type {HTMLButtonElement}
         */
        const confirmBtn = appointmentConfirmationModal.querySelector("#appointment-delete-confirm");
        confirmBtn.addEventListener('click', async () => {
            const appointmentId = btn.dataset.id;

            confirmBtn.disabled = true;
            confirmBtn.classList.add('btn--loading')
            confirmBtn.innerHTML = "<i class='fa fa-spinner'></i> deleting"

            try {
                const response = await fetch(`/appointments/delete`, {
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    method: 'POST',
                    body: JSON.stringify({
                        appointment_id: appointmentId
                    })
                })
                switch (response.status) {
                    case 400:
                        Notifier.show({
                            header: 'Error',
                            text: 'Something went wrong',
                            closable: true,
                            duration: 5000,
                            type: 'danger'
                        })
                        break;
                    case 204:
                        Notifier.show({
                                header: 'Success',
                                text: 'Appointment deleted successfully',
                                closable: true,
                                duration: 2000,
                                type: 'success'
                            }
                        )
                }
            } catch (e) {
                console.log(e)
                Notifier.show({
                    header: 'Error',
                    text: 'Something went wrong',
                    closable: true,
                    duration: 5000,
                    type: 'danger'
                })

            } finally {
                confirmBtn.disabled = false;
                confirmBtn.classList.remove('btn--loading')
                confirmBtn.innerHTML = "Confirm"

                location.reload();
            }

        })

        Modal.show({
            key: "Appointment cancellation confirmation",
            closable: true,
            content: appointmentConfirmationModal
        })
    })
})
