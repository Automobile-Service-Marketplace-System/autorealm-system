import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const officeDeleteAppointmentButtons = document.querySelectorAll(".office-delete-appointment-btn")

officeDeleteAppointmentButtons.forEach(deleteAppointmentButton =>{
    deleteAppointmentButton?.addEventListener("click", () =>{

        const appointmentRow = deleteAppointmentButton.parentElement.parentElement.parentElement;

        const customerNameElement = appointmentRow.querySelector("td:nth-child(3)");
        const customerName = customerNameElement.textContent; 

        const modalContent = htmlToElement(`
                <div>
                    <p>Are you sure you want to delete appointment for ${customerName}?</p>
                    <div class="button-area">
                        <button class="btn btn--danger btn--thin modal-close-btn">Cancel</button>
                        <button class="btn btn--thin modal-close-btn">Confirm</button>
                    </div>
                </div>
                `)

        const confBtn = modalContent.querySelector("button:last-child")
        confBtn.addEventListener("click", async() =>{
            try{
                 const result = await fetch("/appointments/delete",{
                     method: "POST",
                     body: JSON.stringify({
                         appointment_id: deleteAppointmentButton.dataset.appointmentid
                     }),
                     headers:{
                         'Content-Type': 'application/json'
                     }
                 })

                switch (result.status){
                    case 204:
                        Notifier.show({
                            text: "Appointment deleted successfully",
                            type: "success",
                            header: "Success",
                        })
                        setTimeout(() => {
                            location.reload()
                        }, 800)

                        break;
                    case 500:
                        Notifier.show({
                            text: "Something went wrong: error:500",
                            type: "danger",
                            header: "Error",
                        })
                        break;
                    default:
                        console.log("inside default")
                        break;
                }
            }
            catch(e){
                console.log(e)
                Notifier.show({
                    text: "Something went wrong",
                    type: "error",
                    header: "Error",
                })
            }

        })
    Modal.show({
        key: "delete-appointment",
        content: modalContent,
    })
    })
})
