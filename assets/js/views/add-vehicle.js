import { Modal } from "../components/Modal";
import { htmlToElement } from "../utils";
import Notifier from "../components/Notifier";

const addVehicleButton = document.querySelector("#add-vehicle-for-customer");

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());

console.log(localStorage);

const addVehicleForm =
  htmlToElement(`<form action="/vehicles/add/by-customer?id=${params.id}" method="post" enctype="multipart/form-data" id="add-vehicle-form">

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
            <select name='manufactured_year' id='manufactured_year' placeholder='' required>
            </select>

      </div><div class='form-item '>
            <label for='brand'>Brand.<sup>*</sup></label>
            <select  name='brand' id='brand'  required > 
          
            </select>
            
      </div>
     
      <div class='form-item '>
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
</form>`);

addVehicleForm
  ?.querySelector("#add-vehicle-modal-btn")
  ?.addEventListener("click", (e) => {
    const template = `<div>
                        <h3>Are you sure you want to add this vehicle?</h3>
                        <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                            <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>                        
                            <button class="btn btn--thin modal-close-btn" id="add-vehicle-confirm-btn">Confirm</button>                        
                        </div>
                        </div>`;
    const element = htmlToElement(template);
    element
      .querySelector("#add-vehicle-confirm-btn")
      .addEventListener("click", () => {
        const submitBtn = addVehicleForm?.querySelector(
          "#add-vehicle-final-btn"
        );
        submitBtn?.click();
      });

    Modal.show({
      content: element,
      key: "Add vehicle confirmation",
      closable: true,
    });
  });

addVehicleForm?.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData(e.target);
  try {
    const result = await fetch(`/vehicles/add/by-customer?id=${params.id}`, {
      body: formData,
      method: "POST",
    });
    if (result.status === 400) {
      const resultBody = await result.json();
      for (const inputName in resultBody.errors) {
        const inputWrapper = addVehicleForm.querySelector(
          `#${inputName}`
        ).parentElement;
        inputWrapper.classList.add("form-item--error");
        const errorElement = htmlToElement(
          `<small>${resultBody.errors[inputName]}</small>`
        );
        inputWrapper.appendChild(errorElement);
      }
    } else if (result.status === 201) {
      // add success message to url search params
      window.location.search = new URLSearchParams({
        ...params,
        success: "Vehicle added successfully",
      }).toString();
      location.reload();
    }
  } catch (e) {
    Notifier.show({
      closable: true,
      header: "Error",
      type: "danger",
      text: e.message,
    });
  }
});

addVehicleForm?.addEventListener("reset", (e) => {
  const formItems = addVehicleForm.querySelectorAll(".form-item");
  formItems.forEach((item) => {
    item.classList.remove("form-item--error");
    const errorElement = item.querySelector("small");
    if (errorElement) {
      item.removeChild(errorElement);
    }
  });
});

addVehicleButton?.addEventListener("click", () => {
  /**
   * @type {Array<{model_id: number, is_product_model: 0|1, is_vehicle_model: 0|1, model_name: string}>}
   */
  const models = JSON.parse(localStorage.getItem("models") || "[]");

  const modelOptions = models
    .filter((m) => m.is_vehicle_model === 1)
    .map(function (mod) {
      return `<option value="${mod.model_id}">${mod.model_name}</option>`;
    })
    .join("");

  /**
   * @type {Array<{brand_id: number, is_product_brand: 0|1, is_vehicle_brand: 0|1, brand_name: string}>}
   */
  const brands = JSON.parse(localStorage.getItem("brands") || "[]");
  const brandOptions = brands
    .filter((b) => b.is_vehicle_brand === 1)
    .map(function (brand) {
      return `<option value = "${brand.brand_id}">${brand.brand_name}</option> `;
    })
    .join("");

  const modelSelectElement = addVehicleForm.querySelector("#model");
  modelSelectElement.innerHTML = modelOptions;

  const brandSelectElement = addVehicleForm.querySelector("#brand");
  brandSelectElement.innerHTML = brandOptions;

  const years = []
  const maxYear = new Date().getFullYear()

  for (let index = maxYear; index >= 1900; index--) {
    years.push(index)
  }

  const modelYearOptions = years.map(y => {
    return `<option value="${y}">${y}</option>`
  })

  const manufacturedYearSelectElement = addVehicleForm.querySelector("#manufactured_year");
  manufacturedYearSelectElement.innerHTML = modelYearOptions;

  Modal.show({
    content: addVehicleForm,
    closable: false,
    key: "addVehicleForm",
  });
});
