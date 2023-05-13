import {Modal} from "../components/Modal";
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";
import {CalendarView} from "../components/CalendarView";

const createAppointmentButton = document.querySelectorAll(".create-appointment-btn");

/**
 * @type {Array<{time_id: number, from_time: string, to_time:string}>}
 */
let timeslots = [];

createAppointmentButton.forEach(function (btn) {

    btn.addEventListener("click", async function () {
        try {
            const customerID = Number(btn.dataset.id);
            const customerRow = btn.parentElement.parentElement.parentElement;
            const customerNameElement = customerRow.querySelector("td:nth-child(2)");
            const name = customerNameElement.textContent;

            let customerVehicles = [];

            const result = await fetch(`/vehicles/by-customer-json?id=${customerID}`, {
                headers: {
                    "Content-Type": "application/json",
                }, method: "GET",
            });

            switch (result.status) {
                case 404:
                    Notifier.show({
                        text: "No vehicles found for this customer<br>Please add one first",
                        type: "danger",
                        header: "Error", // closable: true,
                    })
                    return;
                case 200:
                    /**
                     * @type {Array<{reg_no: string, model_name: string, brand_name: string}>}
                     */
                    const vehicles = await result.json();

                    let vehicleOptions = vehicles.map((vehicle) => {
                        return `<option value="${vehicle.reg_no}">${vehicle.reg_no} - ${vehicle.brand_name} ${vehicle.model_name}</option>`;
                    }).join("");


                    const createAppointmentForm = htmlToElement(`
        <form method="post" class="office-create-appointment-form" enctype="multipart/form-data">
            <div class="office-create-appointment-form_title mb-4" >
                <button class="modal-close-btn" type="button">
                    <i class="fas fa-times"></i>
                </button>
                <h1>
                    Create an appointment for ${name}
                </h1>
            </div>

            <div class="office-create-appointment-input-wrapper mt-8">  
                <div class='form-item '>
                    <label for='vehicle'>Vehicle<sup>*</sup></label>
                    <select  name='vehicle_reg_no' id='vehicle' required> 
                        ${vehicleOptions}
                    </select> 
                </div>
                
                <div class='form-item '>
                    <label for='mileage'>Mileage (Km)<sup>*</sup></label>
                    <input type='number' name='mileage' id='mileage' placeholder='' required  value='' min="0" max="100000">
                </div>

                <div class='form-item create-appointment-remarks'>
                    <label for='remarks'>Remarks</sup></label>
                    <textarea name='remarks' id='remarks' placeholder='' rows="1" style="height: 40px">
                    </textarea>
                </div>
                <div class="create-time-slot">
                    <input type="date" id="date" style="display: none" name="date">
                </div>
                <input style="display: none" name='customerID' id='customerID' value='${customerID}'>
                <div class='form-item'>
                    <label for='timeslot'>Timeslot<sup>*</sup></label>
                    <select name='timeslot' id='timeslot' required> </select>
                </div>
            </div>

            <div class="office-create-appointment__actions">
                <button type="reset" class="btn btn--danger btn--thin btn--text">Reset</button>
                <button type="button" class="btn btn--thin" id="create-appointment-modal-btn">Submit</button>
                <button type="submit" style="display: none" id="create-appointment-final-btn"></button>
            </div>
    </form>
`);


                    createAppointmentForm.querySelector("input#date")?.addEventListener('change', async (e) => {
                        await loadTimeSlots(createAppointmentForm.querySelector("input#date"), createAppointmentForm)
                    })


                    createAppointmentForm
                        ?.querySelector("#create-appointment-modal-btn")
                        ?.addEventListener("click", (e) => {
                            const template = `<div style="width: 350px">
                                <h3>Are you sure you want to create this appointment?</h3>
                                <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem" class="mt-4">
                                    <button type="button" class="btn btn--thin btn--danger modal-close-btn">
                                        Cancel
                                    </button>
                                    <button type="button" class="btn btn--thin modal-close-btn" id="create-appointment-confirm-btn">
                                        <i class="fa fa-spinner"></i>
                                        Confirm
                                    </button>
                                </div>
                            </div>`;

                            const createAppointmentConfirmationModal = htmlToElement(template);

                            const createAppointmentConfirmBtn = createAppointmentConfirmationModal.querySelector("#create-appointment-confirm-btn");
                            createAppointmentConfirmBtn
                                .addEventListener("click", () => {

                                    createAppointmentConfirmBtn.classList.add("btn--loading");
                                    const submitBtn = createAppointmentForm?.querySelector("#create-appointment-final-btn");
                                    submitBtn?.click();
                                    setTimeout(() => {
                                        createAppointmentConfirmBtn.classList.remove("btn--loading");
                                    }, 2000);
                                });

                            Modal.show({
                                content: createAppointmentConfirmationModal,
                                key: "create appointment confirmation",
                                closable: true,
                            });
                        });

                    createAppointmentForm?.addEventListener("submit", async (e) => {
                        e.preventDefault();
                        if (createAppointmentForm.classList.contains("create-appointment-form--error")) {
                            createAppointmentForm
                                .querySelectorAll(".form-item")
                                .forEach((inputWrapper) => {
                                    inputWrapper.classList.remove("form-item--error");
                                    inputWrapper.querySelector("small")?.remove();
                                });
                        }
                        const formData = new FormData(e.target);
                        // console.log(Object.fromEntries(formData.entries()))
                        // return;
                        try {
                            const result = await fetch(`/appointments/create`, {
                                body: formData, method: "POST",
                            });

                            if (result.status === 400) {
                                createAppointmentForm?.classList.add("create-appointment-form--error");
                                const resultBody = await result.json();
                                for (const inputName in resultBody.errors) {
                                    const inputWrapper = createAppointmentForm.querySelector(`#${inputName}`).parentElement;
                                    inputWrapper.classList.add("form-item--error");
                                    const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`);
                                    inputWrapper.appendChild(errorElement);
                                }
                            } else if (result.status === 201) {
                                location.reload();
                            }
                        } catch (e) {
                            console.log(e);
                            Notifier.show({
                                closable: true, header: "Error", type: "danger", text: e.message,
                            });
                        }
                    });

                    createAppointmentForm?.addEventListener("reset", (e) => {
                        const formItems = createAppointmentForm.querySelectorAll(".form-item");
                        formItems.forEach((item) => {
                            item.classList.remove("form-item--error");
                            const errorElement = item.querySelector("small");
                            if (errorElement) {
                                item.removeChild(errorElement);
                            }
                        });
                    });


                    Modal.show({
                        content: createAppointmentForm, closable: false, key: "createAppointmentForm",
                    });

                    new CalendarView({
                        // maxDate a month from now
                        maxDate: (() => {
                            let currentDate = new Date(); // Get the current date
                            return new Date(currentDate.getFullYear(), currentDate.getMonth() + 2, 0)
                        })(), // minDate  a day from now
                        minDate: new Date(new Date().setDate(new Date().getDate() + 1)),
                        parent: ".create-time-slot",
                        boundInput: ".create-time-slot input[name='date']",
                        restrictedDates: [{month: 4, date: 29}, {month: 4, date: 30}, {month: 5, date: 6}, {
                            month: 5,
                            date: 7
                        }, {month: 5, date: 18},]
                    })
                    break;
                case 401:
                    Notifier.show({
                        text: "You are not authorized to perform this action",
                        type: "danger",
                        header: "Error",
                        closable: true,
                        duration: 5000,
                    })
                    return;
                default:
                    Notifier.show({
                        text: "Something went wrong", type: "danger", header: "Error", closable: true, duration: 5000,
                    });
                    return
            }

        } catch (e) {
            console.log(e);
            Notifier.show({
                closable: true, header: "Error", type: "danger", text: "Something went wrong",
            })
        }

    });
});


/**
 * @param input {HTMLInputElement}
 * @param formEl {HTMLElement}
 * @returns {Promise<void>}
 */
async function loadTimeSlots(input, formEl) {
    try {
        const date = input.value;
        console.log(date)
        const result = await fetch(`/appointments/timeslots?date=${date}`);

        switch (result.status) {
            case 404:
                Notifier.show({
                    text: "No timeslots available", type: "danger", header: "Error", closable: true, duration: 5000
                });
                timeslots = [];
                break;
            case 200:
                const resultBody = await result.json();
                timeslots = resultBody;
                const selectTag = formEl.querySelector("select#timeslot");
                timeslots.forEach((timeslot) => {
                    const option = htmlToElement(`<option value="${timeslot.time_id}">
                                    ${timeslot.from_time} - ${timeslot.to_time}
                                 </option>`)
                    selectTag.appendChild(option)
                })

        }
    } catch (e) {
        console.log(e)
        Notifier.show({
            text: "Something went wrong", type: "danger", header: "Error", closable: true, duration: 5000,
        });
    }
}