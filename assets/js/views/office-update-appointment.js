import { Modal } from "../components/Modal";
import { htmlToElement } from "../utils";
import Notifier from "../components/Notifier";

const updateAppointmentButton = document.querySelectorAll(".office-update-appointment-btn");


updateAppointmentButton.forEach(function (btn) {
  btn.addEventListener("click", function () {
    const appointmentRow = btn.parentElement.parentElement.parentElement;

    const appointmentIDElement = appointmentRow.querySelector("td:nth-child(1)");
    const appointmentID = appointmentIDElement.textContent;

    const vehicleRegNElement = appointmentRow.querySelector("td:nth-child(2)");
    const vehicleReg = vehicleRegNElement.textContent;

    const customerNameElement = appointmentRow.querySelector("td:nth-child(3)");
    const customerName = customerNameElement.textContent;

    const mileageElement = appointmentRow.querySelector("td:nth-child(4)");
    const mileage = mileageElement.textContent;

    const remarksElement = appointmentRow.querySelector("td:nth-child(5)");
    const remarks = remarksElement.textContent;

    const dateTimeElement = appointmentRow.querySelector("td:nth-child(6)");
    const dateTime = dateTimeElement.textContent;

    const officeUpdateAppointmentForm = htmlToElement(`<form id="office-update-appointment-details">
        <div class="modal-header">
            <h3>
            Update appointment details
            </h3>
            <h2>
             ${customerName} - ${vehicleReg}
            </h2>
        <button class="modal-close-btn">
            <i class="fas fa-times"></i>
        </button>
        </div>

        <div class="grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap:1.5rem;">
        
        <input style="display: none" name='appointment_id' id='appointment_id' value='${appointmentID}'>

        <div class='form-item'>
                <label for='vin'>Mileage<sup>*</sup></label>
                <input type='text' name='mileage' id='mileage' placeholder='' required  value='${mileage}'>
        </div>

        <div class='form-item'>
                <label for='reg_no'>Remarks<sup>*</sup></label>
                <input type='text' name='remarks' id='remarks' placeholder='' required  value='${remarks}'>
        </div>

        <div class='form-item'>
                <label for='engine_no'>Date & Time<sup>*</sup></label>
                <input type='text' name='date_time' id='date_time' placeholder='' required  value='${dateTime}'>      
        </div>

        <div class="flex-centered-y justify-between mt-4">
            <button class="btn btn--thin btn--danger" type="reset">
                Reset
            </button>
            <button class="btn btn--thin" id="office-update-appointment-modal-btn" type="button">
                Submit
            </button>
            <button style="display: none" type="submit" id="office-update-appointment-confirm-btn-final-btn">
            </button>
        </div>
    </form>`);

    officeUpdateAppointmentForm
      ?.querySelector("#office-update-appointment-modal-btn")
      ?.addEventListener("click", (e) => {
        const template = `<div style="width: 350px">
                                <h3>Are you sure you want to update this appointment?</h3>
                                <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem" class="mt-4">
                                    <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                                    <button class="btn btn--thin modal-close-btn" id="office-update-appointment-confirm-btn">Confirm</button>                        
                                </div>
                                </div>`;
        const element = htmlToElement(template);
        // console.log(element)
        element
          .querySelector("#office-update-appointment-confirm-btn")
          .addEventListener("click", () => {
            const submitBtn = officeUpdateAppointmentForm?.querySelector(
              "#office-update-appointment-confirm-btn-final-btn"
            );
            submitBtn?.click();
          });

        Modal.show({
          content: element,
          key: "Update appointment confirmation",
          closable: true,
        });
      });

      officeUpdateAppointmentForm?.addEventListener("submit", async (e) => {
      e.preventDefault();
      if(officeUpdateAppointmentForm.classList.contains("office-update-appointment-form--error")){
        officeUpdateAppointmentForm.querySelectorAll(".form-item").forEach((inputWrapper)=>{
          inputWrapper.classList.remove("form-item--error")
          inputWrapper.querySelector("small")?.remove()
        })
      }
      const formData = new FormData(e.target);
      try {
        const result = await fetch("/appointments/update", {
          body: formData,
          method: "POST",
        });
        if (result.status === 400) {
          officeUpdateAppointmentForm?.classList.add("office-update-appointment-form--error");
          const resultBody = await result.json();
          for (const inputName in resultBody.errors) {
            const inputWrapper = officeUpdateAppointmentForm.querySelector(
              `#${inputName}`
            ).parentElement;
            inputWrapper.classList.add("form-item--error");
            const errorElement = htmlToElement(
              `<small>${resultBody.errors[inputName]}</small>`
            );
            inputWrapper.appendChild(errorElement);
          }
        } else if (result.status === 201) {
          location.reload();
        }
      } catch (e) {
        console.log(e)
        Notifier.show({
          closable: true,
          header: "Error",
          type: "danger",
          text: e.message,
        });
      }
    });

    officeUpdateAppointmentForm?.addEventListener("reset", (e) => {
      const formItems = officeUpdateAppointmentForm.querySelectorAll(".form-item");
      formItems.forEach((item) => {
        item.classList.remove("form-item--error");
        const errorElement = item.querySelector("small");
        if (errorElement) {
          item.removeChild(errorElement);
        }
      });
    });

    Modal.show({
      content: officeUpdateAppointmentForm,
      closable: false,
      key: "officeUpdateAppointmentForm",
    });
  });
});
