import { Modal } from "../components/Modal";
import { htmlToElement } from "../utils";
import Notifier from "../components/Notifier";

const updateAppointmentButton = document.querySelectorAll(".office-update-appointment-btn");

updateAppointmentButton.forEach(function (btn) {
  btn.addEventListener("click", function () {
    const customerID = Number(btn.dataset.customerid);         

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

    const dateElement = appointmentRow.querySelector("td:nth-child(6)");
    const date = dateElement.textContent;

    const officeUpdateAppointmentForm = htmlToElement(`<form method="post" class="office-update-appointment-form" enctype="multipart/form-data">
        <div class="office-update-appointment-form_title" style="margin-top: -1rem;margin-bottom: 1rem">
            <button class="modal-close-btn">
              <i class="fas fa-times"></i>
            </button>
            <h1>
              Update appointment details
            </h1>
            <h2>
             ${customerName} - ${vehicleReg}
            </h2>
        </div>

        <div class="office-update-appointment-input-wrapper">  
                <div class='form-item '>
                    <label for='vehicle'>Vehicle<sup>*</sup></label>
                    <select  name='vehicle_reg_no' id='vehicle' required> 
                
                    </select> 
                </div>
                
                <div class='form-item '>
                    <label for='mileage'>Mileage (Km)<sup>*</sup></label>
                    <input type='number' name='mileage' id='mileage' placeholder='' required min="0" max="100000" value='${mileage}'>
                </div>

                <div class='form-item update-appointment-remarks'>
                    <label for='remarks'>Remarks</sup></label>
                    <textarea name='remarks' id='remarks' placeholder='' rows="1" style="height: 40px"> ${remarks}
                    </textarea>
                </div>
                
                <div class='form-item update-timeslot'>
                    <label for='date'>Date<sup>*</sup></label>
                    <input type="date" name="date" id="date">
                </div>
                <input style="display: none" name='customerID' id='customerID'>

                <div class='form-item'>
                    <label for='timeslot'>Timeslot<sup>*</sup></label>
                    <select name='timeslot' id='timeslot' required> </select>
                </div>
                <input style="display: none" name='customer_id' id='customer_id' value='${customerID}'>
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

/**
 * @param event {InputEvent}
 * @param formEl {HTMLElement}
 * @returns {Promise<void>}
 */
async function loadTimeSlots(event, formEl) {
  try {
      /**
       * @type {HTMLInputElement}
       */
      const input = event.target;
      const date = input.value;
      const result = await fetch(`/appointments/timeslots?date=${date}`);

      switch (result.status) {
          case 404:
              Notifier.show({
                  text: "No timeslots available",
                  type: "danger",
                  header: "Error",
                  closable: true,
                  duration: 5000
              });
              timeslots = [];
          case 200:
              const resultBody = await result.json();
              timeslots = resultBody;
              const selectTag = formEl.querySelector("select#timeslot");
              timeslots.forEach((timeslot) => {
                  const option = htmlToElement(
                      `<option value="${timeslot.time_id}">
                                  ${timeslot.from_time} - ${timeslot.to_time}
                               </option>`
                  )
                  selectTag.appendChild(option)
              })

      }
  } catch (e) {
      console.log(e)
      Notifier.show({
          text: "Something went wrong",
          type: "danger",
          header: "Error",
          closable: true,
          duration: 5000,
      });
  }

}
