import {Modal} from "../components/Modal";
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const createJobCardButton = document.querySelectorAll(".office-create-jobcard");



/**
 * @typedef {Object} Foreman
 * @property {number} ID
 * @property {string} Name
 * @property {1|0} Availability
 * @property {string} Image
 */



/**
 * @type {(container: HTMLDivElement) => Promise<void> | null}
 */
let loadForemen = null;

createJobCardButton.forEach(function (btn) {
    btn.addEventListener("click", async function () {

        if (!loadForemen) {
            loadForemen = async (container) => {
                try {
                    const response = await fetch("/foremen");
                    switch (response.status) {
                        case 200:
                            /**
                             * @type {Foreman[]}
                             */
                            const foremen = await response.json();

                            container.classList.remove("select-foreman-cards--loading");
                            const spinIcon = container.querySelector(".spin-icon");

                            foremen.forEach((foreman) => {
                                const availabilityClass = foreman.Availability === 1 ? "indicator indicator--success" : "indicator";
                                const availabilityPhrase = foreman.Availability === 1 ? "Available" : "Busy";
                                const foremanCard = htmlToElement(
                                    `
                                    <div class='foreman-card gap-8'>
                                        <img class ='foreman-card-img' src='${foreman.Image}' alt='${foreman.Name}'>
                                        <div class="foreman-card__info">
                                        <p class="foreman-card__name">${foreman.Name}</p>    
                                        <div class='flex items-center gap-4'>
                                            <p>
                                                ${availabilityPhrase}
                                            </p>
                                            <div class='${availabilityClass}'></div>
                                        </div>
                                        </div>
                                        <i class="fa-solid fa-circle-check"></i>
                                        <input type="radio" name="foreman_id" value="${foreman.ID}" style="display: none">
                                    </div>
                                    `
                                )


                                foremanCard.addEventListener('click', () => {
                                    const selectedForemanCard = container.querySelector('.foreman-card--selected')
                                    if(selectedForemanCard){
                                        selectedForemanCard.classList.remove('foreman-card--selected')
                                    }
                                    foremanCard.classList.add('foreman-card--selected')
                                    foremanCard.querySelector('input').checked = true
                                })

                                container.insertBefore(foremanCard, spinIcon)
                                // const foremanCardHeader = foremanCard.querySelector(".foreman-card__header")
                            })


                            break
                        case 500:
                            throw new Error("Internal server error")
                    }
                } catch (e) {
                    console.log(e)
                    Notifier.show({
                        text: e.message,
                        type: "danger",
                        closable: true,
                        header: "Error",
                        duration: 5000
                    })
                }
            }
        }

        const customerID = Number(btn.dataset);
        const foremanAvailability = btn.dataset.foremaninfo;
        const appointmentRow = btn.parentElement.parentElement.parentElement;
        const appointmentIDElement = appointmentRow.querySelector("td:nth-child(3)");
        const customerName = appointmentIDElement.textContent;

        const officeCreateJobCardForm = htmlToElement(`<form method="post" class="office-create-jobcard-form" enctype="multipart/form-data">
        <div class="office-create-jobcard-form_title" style="margin-top: -1rem;margin-bottom: 1rem">
            <button class="modal-close-btn" type="button">
              <i class="fas fa-times"></i>
            </button>
            <h2>
              Create a job for ${customerName}
            </h2>
        </div>
        <section class="assign-a-foreman">
            <p>Select the foreman to handle this job</p>
            <div class="select-foreman-cards select-foreman-cards--loading">
               <i class="fa fa-spinner spin-icon"></i>
            </div>
        </section>

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

        const selectForemanCards = officeCreateJobCardForm.querySelector(".select-foreman-cards");

        officeCreateJobCardForm?.addEventListener("submit", async (e) => {
            e.preventDefault();
            if (officeCreateJobCardForm.classList.contains("office-create-jobcard-form--error")) {
                officeCreateJobCardForm.querySelectorAll(".form-item").forEach((inputWrapper) => {
                    inputWrapper.classList.remove("form-item--error")
                    inputWrapper.querySelector("small")?.remove()
                })
            }
            const formData = new FormData(e.target);
            try {
                const result = await fetch("/job-card/create", {
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
        if (loadForemen)
            await loadForemen(selectForemanCards);

    });
});

