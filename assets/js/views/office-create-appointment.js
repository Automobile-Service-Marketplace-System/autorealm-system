import { Modal } from "../components/Modal";
import { htmlToElement } from "../utils";

const createAppointmentButton = document.querySelectorAll(
  ".create-appointment-btn"
);

createAppointmentButton.forEach(function (btn) {
  btn.addEventListener("click", function () {

    const customerID = btn.dataset.id;
    const customereRow = btn.parentElement.parentElement.parentElement;

    const customerNameElement = customereRow.querySelector("td:nth-child(2)");
    const name = customerNameElement.textContent;
    // console.log(name);


    const createAppointmentform = htmlToElement(`
    <div class="create-appointment">
    <div class="add-vehicle-form_title" style="margin-top: -1rem;margin-bottom: 1rem">
        <h1 class="office-staff-add-customer-form__vehicle__title">
            Create an appointment
        </h1>
        <p>${name}</p>
    
        <button class="modal-close-btn">
            <i class="fas fa-times"></i>
        </button>
    </div><form action="/appointments/for-vin" method="post" class="create-appointment-form"
    enctype="multipart/form-data">
        <div class="create-appointment-form__top">
               <div class='form-item '>
                  <label for='vehicle'>Vehicle<sup>*</sup></label>
                  <select  name='vehicle' id='vehicle'  required > 
                      <option value='2' >Toyota Corolla</option>
                      <option value="3">Suzuki Swift</option>
                  </select> 
                </div>

                <div class='form-item '>
                  <label for='mileage'>Mileage<sup>*</sup></label>
                  <input type='text' name='mileage' id='mileage' placeholder='' required  value=''>
                </div>

                <div class='form-item'>
                  <label for='remarks'>Remarks<sup>*</sup></label>
                  <textarea name='remarks' id='remarks' placeholder='' required  value='' rows="1" style="height: 40px">
                  </textarea>
                </div> 

                <div class="create-timeslot">
                    <div class='form-item'>
                        <label for='remarks'>Date<sup>*</sup></label>
                        <input type="date">
                </div>

                <div class="create-timeslot">
                    <div class='form-item'>
                        <label for='remarks'>Timeslot<sup>*</sup></label>
                        <textarea name='timesolt' id='timesolt' placeholder='' required  value='' rows="1" style="height: 40px">
                        </textarea>
                </div> 
        </div>
                          
          <div class="create-appointment__actions">
          <button type="reset" class="btn btn--danger">Reset</button>  
          <button type="button" class="btn" id="create-appointment-modal-btn">Submit</button>   
          </div>
          </div>     
      </div>
    </form>
    </div>`);

    createAppointmentform
      ?.querySelector("#create-appointment-modal-btn")
      ?.addEventListener("click", (e) => {
        const template = `<div style="width: 350px">
                                <h3>Are you sure you want to create this appointment?</h3>
                                <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem" class="mt-4">
                                    <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                                    <button class="btn btn--thin modal-close-btn" id="update-vehicle-confirm-btn">Confirm</button>                        
                                </div>
                                </div>`;
        const element = htmlToElement(template);
        // console.log(element)
        element
          .querySelector("#update-vehicle-confirm-btn")
          .addEventListener("click", () => {
            const submitBtn = createAppointmentform?.querySelector(
              "#update-vehicle-final-btn"
            );
            submitBtn?.click();
          });

        Modal.show({
          content: element,
          key: "Update vehicle confirmation",
          closable: true,
        });
      });

    createAppointmentform?.addEventListener("submit", async (e) => {
      e.preventDefault();
      if (
        createAppointmentform.classList.contains("update-vehicle-form--error")
      ) {
        createAppointmentform
          .querySelectorAll(".form-item")
          .forEach((inputWrapper) => {
            inputWrapper.classList.remove("form-item--error");
            inputWrapper.querySelector("small")?.remove();
          });
      }
      const formData = new FormData(e.target);
      try {
        const result = await fetch("/vehicles/update", {
          body: formData,
          method: "POST",
        });
        if (result.status === 400) {
          createAppointmentform?.classList.add("update-vehicle-form--error");
          const resultBody = await result.json();
          for (const inputName in resultBody.errors) {
            const inputWrapper = createAppointmentform.querySelector(
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
        console.log(e);
        Notifier.show({
          closable: true,
          header: "Error",
          type: "danger",
          text: e.message,
        });
      }
    });

    createAppointmentform?.addEventListener("reset", (e) => {
      const formItems = createAppointmentform.querySelectorAll(".form-item");
      formItems.forEach((item) => {
        item.classList.remove("form-item--error");
        const errorElement = item.querySelector("small");
        if (errorElement) {
          item.removeChild(errorElement);
        }
      });
    });

    Modal.show({
      content: createAppointmentform,
      closable: false,
      key: "createAppointmentform",
    });
  });
});
