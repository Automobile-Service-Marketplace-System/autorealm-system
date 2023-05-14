import {Modal} from "../../components/Modal";
import {htmlToElement} from "../../utils";
import Notifier from "../../components/Notifier";
import {CalendarView} from "../../components/CalendarView";
import {loadTimeSlots, loadHolidays, appointmentDataUtils} from "./appointment-data-utils"


const createAppointmentButton = document.querySelectorAll("#customer-create-appointment-btn");



createAppointmentButton.forEach(function (btn) {

    btn.addEventListener("click", async function () {
        try {

            const result = await fetch(`/vehicles/for-appointment`, {
                headers: {
                    "Content-Type": "application/json",
                }, method: "GET",
            });


            let vehicleOptions = `<option value="na">No vehicles available</option>`;

            switch (result.status) {
                case 404:
                    Notifier.show({
                        text: "You don't have any vehicles saved yet, please add a vehicle later at the service center.For now an appointment will be created without specifying a vehicle",
                        type: "warning",
                        header: "Warning", // closable: true,
                    })
                    break;
                case 200:
                    /**
                     * @type {{vehicles: Array<{reg_no: string, vehicle_name: string}>}}
                     */
                    const data = await result.json();
                    const {vehicles} = data;

                    vehicleOptions = vehicles.map((vehicle) => {
                        return `<option value="${vehicle.reg_no}">${vehicle.vehicle_name}</option>`;
                    }).join("");


                    const createAppointmentForm = htmlToElement(`
                        <form method="post" class="office-create-appointment-form" enctype="multipart/form-data">
                            <div class="office-create-appointment-form_title mb-4" >
                                <button class="modal-close-btn" type="button">
                                    <i class="fas fa-times"></i>
                                </button>
                                <h1>
                                    Get an appointment
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
                        </form>`);


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
                                    <button type="button" class="btn btn--thin" id="create-appointment-confirm-btn">
                                        <i class="fa fa-spinner"></i>
                                        Confirm
                                    </button>
                                    <style>
                                        #create-appointment-confirm-btn svg{
                                            display: none;
                                        } 
                                        
                                        #create-appointment-confirm-btn.btn--loading svg{
                                            display: initial;
                                            animation: spin 2s linear infinite;
                                        }
                                    </style>
                                </div>
                            </div>`;

                            const createAppointmentConfirmationModal = htmlToElement(template);

                            const createAppointmentConfirmBtn = createAppointmentConfirmationModal.querySelector("#create-appointment-confirm-btn");
                            createAppointmentConfirmBtn
                                .addEventListener("click", () => {

                                    createAppointmentConfirmBtn.disabled = true;
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
                        try {
                            const result = await fetch(`/appointments/create-by-customer`, {
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

                    await loadHolidays();

                    new CalendarView({
                        // maxDate a month from now
                        maxDate: (() => {
                            let currentDate = new Date(); // Get the current date
                            return new Date(currentDate.getFullYear(), currentDate.getMonth() + 2, 0)
                        })(), // minDate  a day from now
                        minDate: new Date(new Date().setDate(new Date().getDate() + 1)),
                        parent: ".create-time-slot",
                        boundInput: ".create-time-slot input[name='date']",
                        restrictedDates: appointmentDataUtils.holidays,
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