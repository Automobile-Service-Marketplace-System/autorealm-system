import {Modal} from "../../components/Modal"
import {htmlToElement} from "../../utils";


const createAppointmentButton = document.querySelector("#create-appointment-btn");


const createAppointmentModal = htmlToElement(`
<div class="create-appointment">
<div class="add-vehicle-form_title" style="margin-top: -0.5rem;margin-bottom: 1rem">
    <h1 class="office-staff-add-customer-form__vehicle__title">
        Fill in details
    </h1>

    <button class="modal-close-btn">
        <i class="fas fa-times"></i>
    </button>
</div>
    <form action="/appointments/for-vin" method="post" class="create-appointment-form"
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
                    <div class='form-item '>
                        <label for='service_type'>Service Type<sup>*</sup></label>
                        <select  name='service_type' id='service_type'  required > 
                            <option value='2' >Caltex</option>
                            <option value='5' >Fairbay</option>
                            <option value='3' >Honda</option>
                            <option value='8' >Mitsubishi</option>
                            <option value='1' selected>Mobil</option>
                            <option value='7' >Suzuki</option>
                            <option value='6' >Teyes</option>
                            <option value='4' >Toyota</option>
                        </select> 
                    </div>
                    <div class='form-item'>
                        <label for='remarks'>Remarks<sup>*</sup></label>
                        <textarea name='remarks' id='remarks' placeholder='' required  value='' rows="1" style="height: 40px">
                        </textarea>
                    </div> 
            </div>
            <div class="create-appointment-form__bottom">
<!--                <div class="date-selector">-->
                    <div class="date-selector__date">
                            <div class="date-label">
                                <button>
                                    <i class="fa-solid fa-angle-left"></i>
                                </button>
                                <p>2023</p>
                                <button>
                                    <i class="fa-solid fa-angle-right"></i>
                                </button>
                            </div>
                            <div class="date-label">
                                <button>
                                    <i class="fa-solid fa-angle-left"></i>
                                </button>
                                <p>Jan</p>
                                <button>
                                    <i class="fa-solid fa-angle-right"></i>
                                </button>
                            </div>
                        <div class="date-selector__date-header">
                            <div>S</div>
                            <div>M</div>
                            <div>T</div>
                            <div>W</div>
                            <div>T</div>
                            <div>F</div>
                            <div>S</div>
                        </div>
                        <div class="date-selector__date-body">
                        <div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                        <div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                        <div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                        <div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                        <div></div><div></div><div></div><div></div><div></div><div></div><div></div>
                        </div>
                    </div>
<!--                </div>   -->
                <div class="create-appointment__last">
                <div class="timeslot-selector">
                        <div>08.00 - 10.30</div>
                        <div>10.30 - 12.00</div>
                        <div>12.00 - 13.30</div>
                        <div>13.30 - 15.00</div>
                        <div>15.00 - 16.30</div>
                        <div>16.30 - 18.00</div>
                </div>                
                <div class="create-appointment__actions">
                <button type="reset" class="btn btn--danger">Reset</button>  
                <button type="button" class="btn">Submit</button>   
                </div>
                </div>     
            </div>
    </form>
</div>
`);

const dates = createAppointmentModal.querySelectorAll(".date-selector__date-body div");
dates.forEach((date) => {
    date.innerHTML = "10"

});

createAppointmentButton?.addEventListener("click", () => {
    Modal.show({
        closable: false,
        content: createAppointmentModal,
        key: `CreateAppointmentForCustomer`,
    });
});
