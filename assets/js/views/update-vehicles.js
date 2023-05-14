import { Modal } from "../components/Modal";
import { htmlToElement } from "../utils";
import Notifier from "../components/Notifier";

const updateCustomerButton = document.querySelectorAll(".update-vehicle-btn");


const vehicleTypes = ["bike", "car", "jeep", "van", "lorry", "bus", "other"];
const fuelTypes = ["petrol", "diesel", "hybrid", "electric"];
const transmissionTypes = ["manual", "automatic", "triptonic", "cvt"];

updateCustomerButton.forEach(function (btn) {
  btn.addEventListener("click", function () {
    const vin = btn.dataset.vin;
    const vehicleRow = btn.parentElement.parentElement.parentElement;

    const vehicleVINElement = vehicleRow.querySelector("td:nth-child(1)");
    const VIN = vehicleVINElement.textContent;

    const vehicleRegtNoElement = vehicleRow.querySelector("td:nth-child(2)");
    const RegNo = vehicleRegtNoElement.textContent;

    const vehicleEnginetNoElement = vehicleRow.querySelector("td:nth-child(3)");
    const EngineNo = vehicleEnginetNoElement.textContent;

    const vehicleManuYRElement = vehicleRow.querySelector("td:nth-child(5)");
    const ManufacturedYear = vehicleManuYRElement.textContent;

    const vehicleEngineCapacityElement =
      vehicleRow.querySelector("td:nth-child(6)");
    const EngineCapacity = vehicleEngineCapacityElement.textContent;

    const vehicleVehicleTypeElement =
      vehicleRow.querySelector("td:nth-child(7)");
    const VehicleType = vehicleVehicleTypeElement.textContent;

    const vehicleFuelTypeElement = vehicleRow.querySelector("td:nth-child(8)");
    const FuelType = vehicleFuelTypeElement.textContent;

    const vehicleTransmissionTypeElement =
      vehicleRow.querySelector("td:nth-child(9)");
    const TransmissionType = vehicleTransmissionTypeElement.textContent;

    const vehicleModelElement = vehicleRow.querySelector("td:nth-child(10)");
    const model = vehicleModelElement.textContent;

    const modelId = Number(btn.dataset.modelid);
    /**
     * @type {Array<{model_id: number}>}
     */
    const models = JSON.parse(localStorage.getItem("models") || "[]");
    console.log(`modelId = ${modelId}`, models);

    const modelOptions = models
      .map(function (mod) {
        return `<option value="${
          mod.model_id
        }" ${mod.model_id === modelId ? "selected" : ""}>${mod.model_name}</option>`;
      })
      .join("");

    const vehicleBrandElement = vehicleRow.querySelector("td:nth-child(10)");
    const brand = vehicleBrandElement.textContent;

    const brandId = Number(btn.dataset.brandid);
    /**
     * @type {Array<{brand_id: number}>}
     */
    const brands = JSON.parse(localStorage.getItem("brands") || "[]");
    const brandOptions = brands
      .map(function (brand) {
        return `<option value = "${
          brand.brand_id
        }" ${brand.brand_id === brandId ? "selected" : ""}>${brand.brand_name}</option> `;
      })
      .join("");

    const CustomerID = btn.dataset.customerid;

    const updateVehicleForm = htmlToElement(`<form id="update-vehicle-details">
        <div class="modal-header">
            <h3>
            Update vehicle details
            </h3>
        <button class="modal-close-btn">
            <i class="fas fa-times"></i>
        </button>
        </div>

        <div class="grid" style="display: grid; grid-template-columns: repeat(2, 1fr); gap:1.5rem;">
        
        <div class='form-item'>
                <label for='vin'>VIN<sup>*</sup></label>
                <input type='text' name='vin' id='vin' placeholder='' required  value='${VIN}'>
        </div>
        <input style="display: none" name='old_vin' id='old_vin' value='${VIN}'>

        <div class='form-item'>
                <label for='reg_no'>Registration No<sup>*</sup></label>
                <input type='text' name='reg_no' id='reg_no' placeholder='' required  value='${RegNo}'>
        </div>
        <input style="display: none" name='old_reg_no' id='old_reg_no' value='${RegNo}'>

        <div class='form-item'>
                <label for='engine_no'>Engine No<sup>*</sup></label>
                <input type='text' name='engine_no' id='engine_no' placeholder='' required  value='${EngineNo}'>      
        </div>
        <input style="display: none" name='old_engine_no' id='old_engine_no' value='${EngineNo}'>

        <div class='form-item'>
                <label for='manufactured_year'>Manufactured Year<sup>*</sup></label>
                <input type='text' name='manufactured_year' id='manufactured_year' placeholder='' required  value='${ManufacturedYear}'>      
        </div>

        <div class='form-item'>
                <label for='engine_capacity'>Engine Capacity<sup>*</sup></label>
                <input type='text' name='engine_capacity' id='engine_capacity' placeholder='' required  value='${EngineCapacity}'>      
        </div>

        <div class='form-item'>
            <label for='vehicle_type'>Vehicle Type<sup>*</sup></label>
            <select name='vehicle_type' id='vehicle_type' required>
                ${vehicleTypes
                  .map(
                    (type) =>
                      `<option value="${type}" ${
                        type === VehicleType ? "selected" : ""
                      }>${type}</option>`
                  )
                  .join("")}
            </select>
        </div>

        <div class='form-item'>
            <label for='fuel_type'>Fuel Type<sup>*</sup></label>
            <select name='fuel_type' id='fuel_type' required>
                ${fuelTypes
                  .map(
                    (type) =>
                      `<option value="${type}" ${
                        type === FuelType ? "selected" : ""
                      }>${type}</option>`
                  )
                  .join("")}
            </select>
        </div>

        <div class='form-item'>
            <label for='transmission_type'>Transmission Type<sup>*</sup></label>
            <select name='transmission_type' id='transmission_type' required>
                ${transmissionTypes
                  .map(
                    (type) =>
                      `<option value="${type}" ${
                        type === TransmissionType ? "selected" : ""
                      }>${type}</option>`
                  )
                  .join("")}
            </select>
        </div>

        <div class="form-item">
            <label for='model_id'>Model<sup>*</sup></label>
                <select name="model_id" id="model_id">
                    ${modelOptions}
                </select>
        </div>
        
        <div class="form-item">
            <label for='brand_id'>Brand<sup>*</sup></label>
                <select name="brand_id" id="brand_id">
                    ${brandOptions}
                </select>
        </div>

        <div class='form-item'>
                <label for='brandName'>Customer ID<sup>*</sup></label>
                <input type='text' name='customer_id' id='customer_id' placeholder='' required  value='${CustomerID}'>      
        </div>
        
        </div>

        <div class="flex-centered-y justify-between mt-4">
            <button class="btn btn--thin btn--danger" type="reset">
                Reset
            </button>
            <button class="btn btn--thin" id="update-vehicle-modal-btn" type="button">
                Submit
            </button>
            <button style="display: none" type="submit" id="update-vehicle-final-btn">
            </button>
        </div>
    </form>`);

    updateVehicleForm
      ?.querySelector("#update-vehicle-modal-btn")
      ?.addEventListener("click", (e) => {
        const template = `<div style="width: 350px">
                                <h3>Are you sure you want to update this vehicle?</h3>
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
            const submitBtn = updateVehicleForm?.querySelector(
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

    updateVehicleForm?.addEventListener("submit", async (e) => {
      e.preventDefault();
      if(updateVehicleForm.classList.contains("update-vehicle-form--error")){
        updateVehicleForm.querySelectorAll(".form-item").forEach((inputWrapper)=>{
          inputWrapper.classList.remove("form-item--error")
          inputWrapper.querySelector("small")?.remove()
        })
      }
      const formData = new FormData(e.target);
      try {
        const result = await fetch("/vehicles/update", {
          body: formData,
          method: "POST",
        });
        if (result.status === 400) {
          updateVehicleForm?.classList.add("update-vehicle-form--error");
          const resultBody = await result.json();
          for (const inputName in resultBody.errors) {
            const inputWrapper = updateVehicleForm.querySelector(
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

    updateVehicleForm?.addEventListener("reset", (e) => {
      const formItems = updateVehicleForm.querySelectorAll(".form-item");
      formItems.forEach((item) => {
        item.classList.remove("form-item--error");
        const errorElement = item.querySelector("small");
        if (errorElement) {
          item.removeChild(errorElement);
        }
      });
    });

    Modal.show({
      content: updateVehicleForm,
      closable: false,
      key: "updateVehicleForm",
    });
  });
});
