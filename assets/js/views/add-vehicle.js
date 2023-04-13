import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

const addVehicleButton = document.querySelector("#add-vehicle-for-customer")

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

const addVehicleForm = htmlToElement(`<form action="/vehicles/add/by-customer?id=${params.id}" method="post" enctype="multipart/form-data" id="add-vehicle-form">

<div class="add-vehicle-form_title" style="margin-top: -1rem">
    <h1 class="office-staff-add-customer-form__vehicle__title">
        Add New Vehicle
    </h1>

    <button class="modal-close-btn">
        <i class="fas fa-times"></i>
    </button>
</div>

<div class="office-staff-add-customer-form__vehicle">

    <div class='form-item '>
            <label for='vin'>VIN.<sup>*</sup></label>
            <input type='text' name='vin' id='vin' placeholder='' required  value=''   >
            
      </div><div class='form-item '>
            <label for='engine_no'>Engine No.<sup>*</sup></label>
            <input type='text' name='engine_no' id='engine_no' placeholder='' required  value=''   >
            
      </div><div class='form-item '>
            <label for='reg_no'>Registration No.<sup>*</sup></label>
            <input type='text' name='reg_no' id='reg_no' placeholder='' required  value=''   >
            
      </div><div class='form-item '>
            <label for='manufactured_year'>Manufactured Year.<sup>*</sup></label>
            <input type='date' name='manufactured_year' id='manufactured_year' placeholder='' required  value=''   >
            
      </div><div class='form-item '>
            <label for='brand'>Brand.<sup>*</sup></label>
            <select  name='brand' id='brand'  required > 
                <option value='2' >Caltex</option><option value='5' >Fairbay</option><option value='3' >Honda</option><option value='8' >Mitsubishi</option><option value='1' selected>Mobil</option><option value='7' >Suzuki</option><option value='6' >Teyes</option><option value='4' >Toyota</option>
            </select>
            
      </div><div class='form-item '>
            <label for='model_year'>Model Year.<sup>*</sup></label>
            <input type='date' name='model_year' id='model_year' placeholder='' required  value=''   >
            
      </div><div class='form-item '>
            <label for='vehicle_type'>Vehicle Type.<sup>*</sup></label>
            <select  name='vehicle_type' id='vehicle_type'  required > 
                <option value='Bike' selected>Bike</option><option value='Car' >Car</option><option value='Jeep' >Jeep</option><option value='Van' >Van</option><option value='Lorry' >Lorry</option><option value='Bus' >Bus</option><option value='Other'>Other</option>
            </select>
            
      </div><div class='form-item '>
            <label for='engine_capacity'>Engine Capacity.<sup>*</sup></label>
            <input type='text' name='engine_capacity' id='engine_capacity' placeholder='' required  value=''   >
            
      </div><div class='form-item '>
            <label for='model'>Model.<sup>*</sup></label>
            <select  name='model' id='model'  required > 
                <option value='1' selected>10w-30</option><option value='2' >15w-40</option><option value='3' >A-898</option><option value='4' >A-280</option><option value='5' >A-196</option><option value='6' >KSP-90</option><option value='9' >BP-0222</option><option value='10' >YZZE1</option><option value='11' >LK-111539</option><option value='12' >X1</option><option value='13' >CIVIC EX</option><option value='14' >Corolla</option><option value='15' >Gixxer</option><option value='16' >Lancer</option>
            </select>
            
      </div><div class='form-item '>
            <label for='transmission_type'>Transmission Type.<sup>*</sup></label>
            <select  name='transmission_type' id='transmission_type'  required > 
                <option value='1' selected>Manual</option><option value='2' >Automatic</option><option value='3' >Triptonic</option><option value='4' >CVT</option>
            </select>
            
      </div><div class='form-item '>
            <label for='fuel_type'>Fuel Type.<sup>*</sup></label>
            <select  name='fuel_type' id='fuel_type'  required > 
                <option value='1' selected>Petrol</option><option value='2' >Diesel</option><option value='3' >Hybrid</option><option value='4' >Electric</option>
            </select>
            
      </div>        </div>

<div class="add-vehicle-actions">
    <button class="btn btn--danger" type="reset">
        Reset
    </button>

    <button class="btn" id="add-vehicle-modal-btn" type="button">
        Add vehicle
    </button>
    <button style="display: none" type="submit" id="add-vehicle-final-btn"></button>
</div>
</form>`)


addVehicleForm?.querySelector("#add-vehicle-modal-btn")?.addEventListener("click", (e) => {

    const template =  `<div>
                        <h3>Are you sure you want to add this vehicle?</h3>
                        <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                            <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                            <button class="btn btn--thin modal-close-btn" id="add-vehicle-confirm-btn">Confirm</button>                        
                        </div>
                        </div>`
    const element = htmlToElement(template);
    element.querySelector("#add-vehicle-confirm-btn").addEventListener('click', () => {
        const submitBtn = addVehicleForm?.querySelector("#add-vehicle-final-btn");
        submitBtn?.click();
    })

    Modal.show({
        content: element,
        key: "Add vehicle confirmation",
        closable: true,
    })
})


addVehicleForm?.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    try {
        const result = await fetch(`/vehicles/add/by-customer?id=${params.id}`, {
            body: formData,
            method: 'POST'
        })
        if(result.status === 400) {
            const resultBody = await result.json()
            for (const inputName in resultBody.errors) {
                const inputWrapper = addVehicleForm.querySelector(`#${inputName}`).parentElement
                inputWrapper.classList.add('form-item--error')
                const errorElement = htmlToElement(`<small>${resultBody.errors[inputName]}</small>`)
                inputWrapper.appendChild(errorElement)
            }
        }
         else if (result.status === 201) {

            // add success message to url search params
            window.location.search = new URLSearchParams({
                ...params,
                success: 'Vehicle added successfully'
            }).toString()
            location.reload()
        }
    } catch (e) {
        Notifier.show({
            closable: true,
            header: 'Error',
            type: 'danger',
            text: e.message
        })
    }
})

addVehicleForm?.addEventListener('reset', (e) => {
    const formItems = addVehicleForm.querySelectorAll('.form-item')
    formItems.forEach(item => {
        item.classList.remove('form-item--error')
        const errorElement = item.querySelector('small')
        if (errorElement) {
            item.removeChild(errorElement)
        }
    })
})

addVehicleButton?.addEventListener("click", () => {
    Modal.show({
        content: addVehicleForm,
        closable: false,
        key: "addVehicleForm"
    })
})


