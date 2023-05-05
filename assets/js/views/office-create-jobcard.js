import { Modal } from "../components/Modal";
import { htmlToElement } from "../utils";
import Notifier from "../components/Notifier";

const createJobCardButton = document.querySelectorAll(".office-create-jobcard");

createJobCardButton.forEach(function (btn) {
  btn.addEventListener("click", async function () {
    const customerID = Number(btn.dataset);         
    const foremanAvailability = btn.dataset.foremaninfo;
    const appointmentRow = btn.parentElement.parentElement.parentElement;
    const appointmentIDElement = appointmentRow.querySelector("td:nth-child(3)");
    const customerName = appointmentIDElement.textContent;

    const officeCreateJobCardForm = htmlToElement(`<form method="post" class="office-create-jobcard-form" enctype="multipart/form-data">
        <div class="office-create-jobcard-form_title" style="margin-top: -1rem;margin-bottom: 1rem">
            <button class="modal-close-btn">
              <i class="fas fa-times"></i>
            </button>
            <h1>
              Create a JobCard
            </h1>
            <h2>
              ${customerName} 
            </h2>
            <h3>
              Assign a Foreman
            </h3>

        </div>

        <div class="assign-a-foreman">
                <div class="select-foreman-cards select-foreman-cards--loading">
                  <i class="fa fa-spinner spin-icon"></i>
                </div>
 
        </div>

        <div class="flex-centered-y justify-between mt-4">
            <button class="btn btn--thin btn--danger" type="reset">
                Reset
            </button>
            <button class="btn btn--thin" id="office-create-jobcard-modal-btn" type="button">
                Submit
            </button>
            <button style="display: none" type="submit" id="office-create-jobcard-confirm-btn-final-btn">
            </button>
        </div>
    </form>`);

    officeCreateJobCardForm
      ?.querySelector("#office-create-jobcard-modal-btn")
      ?.addEventListener("click", (e) => {
        const template = `<div style="width: 350px">
                                <h3>Are you sure you want to start this job?</h3>
                                <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem" class="mt-4">
                                    <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                                    <button class="btn btn--thin modal-close-btn" id="office-create-jobcard-confirm-btn">Confirm</button>                        
                                </div>
                                </div>`;
        const element = htmlToElement(template);
        // console.log(element)
        element
          .querySelector("#office-create-jobcard-confirm-btn")
          .addEventListener("click", () => {
            const submitBtn = officeCreateJobCardForm?.querySelector(
              "#office-create-jobcard-confirm-btn-final-btn"
            );
            submitBtn?.click();
          });

        Modal.show({
          content: element,
          key: "Create jobcard confirmation",
          closable: true,
        });

        
      });

      officeCreateJobCardForm?.addEventListener("submit", async (e) => {
      e.preventDefault();
      if(officeCreateJobCardForm.classList.contains("office-create-jobcard-form--error")){
        officeCreateJobCardForm.querySelectorAll(".form-item").forEach((inputWrapper)=>{
          inputWrapper.classList.remove("form-item--error")
          inputWrapper.querySelector("small")?.remove()
        })
      }
      const formData = new FormData(e.target);
      try {
        const result = await fetch("/jobcard/create", {
          body: formData,
          method: "POST",
        });
        if (result.status === 400) {
          officeCreateJobCardForm?.classList.add("office-create-jobcard-form--error");
          const resultBody = await result.json();
          for (const inputName in resultBody.errors) {
            const inputWrapper = officeCreateJobCardForm.querySelector(
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

    officeCreateJobCardForm?.addEventListener("reset", (e) => {
      const formItems = officeCreateJobCardForm.querySelectorAll(".form-item");
      formItems.forEach((item) => {
        item.classList.remove("form-item--error");
        const errorElement = item.querySelector("small");
        if (errorElement) {
          item.removeChild(errorElement);
        }
      });
    });

    Modal.show({
      content: officeCreateJobCardForm,
      closable: false,
      key: "officeCreateJobCardForm",
    });
  });
});

