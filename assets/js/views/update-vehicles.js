const vehicleUpdateButtons = document.querySelectorAll(".update-vehicle-btn");
import { Modal } from "../components/Modal";
import { htmlToElement } from "../utils";

vehicleUpdateButtons.forEach(function (btn) {
  btn.addEventListener("click", function () {
    const vin = btn.dataset.vin;
    const vehicleRow = btn.parentElement.parentElement.parentElement;

    console.log(vin);
    console.log(vehicleRow);

    const vehicleVINElement = vehicleRow.querySelector("td:nth-child(1)");
    const VIN = vehicleVINElement.textContent;

    const vehicleRegtNoElement = vehicleRow.querySelector("td:nth-child(2)");
    const RegNo = vehicleRegtNoElement.textContent;

    const vehicleEnginetNoElement = vehicleRow.querySelector("td:nth-child(3)");
    const EngineNo = vehicleEnginetNoElement.textContent;

    const vehicleManuYRElement = vehicleRow.querySelector("td:nth-child(4)");
    const ManufacturedYear = vehicleManuYRElement.textContent;

    const vehicleEngineCapacityElement =
      vehicleRow.querySelector("td:nth-child(5)");
    const EngineCapacity = vehicleEngineCapacityElement.textContent;

    const vehicleVehicleTypeElement =
      vehicleRow.querySelector("td:nth-child(6)");
    const VehicleType = vehicleVehicleTypeElement.textContent;

    const vehicleFuelTypeElement = vehicleRow.querySelector("td:nth-child(7)");
    const FuelType = vehicleFuelTypeElement.textContent;

    const vehicleTransmissionTypeElement =
      vehicleRow.querySelector("td:nth-child(8)");
    const TransmissionType = vehicleTransmissionTypeElement.textContent;

    const vehicleModelNameElement = vehicleRow.querySelector("td:nth-child(9)");
    const ModelName = vehicleModelNameElement.textContent;

    const vehicleBrandNameElement = vehicleRow.querySelector("td:nth-child(9)");
    const BrandName = vehicleBrandNameElement.textContent;

    const vehicleInfo = {
      VIN,
      RegNo,
      EngineNo,
      ManufacturedYear,
      EngineCapacity,
      VehicleType,
      FuelType,
      TransmissionType,
      ModelName,
      BrandName
    };

    const updatevehicleDetailsForm = htmlToElement(
      `<form action="/vehicles" method="post" enctype="multipart/form-data" id="update-vehicle-details">
                        <div class="modal-header">
                            <h3>
                            Update vehicle info 
                            </h3>
                        <button class="modal-close-btn">
                            <i class="fas fa-times"></i>
                        </button>
                        </div>
        
                        <div class="grid grid-template-colums:repeat(2,1fr)">
                        
                        <div class='form-item'>
                                <label for='vin'>VIN<sup>*</sup></label>
                                <input type='text' name='vin' id='vin' placeholder='' required  value='${vehicleInfo.VIN}'>
                        </div>

                        <div class='form-item'>
                                <label for='regNo'>Registration No<sup>*</sup></label>
                                <input type='text' name='regNo' id='regNo' placeholder='' required  value='${vehicleInfo.RegNo}'>
                        </div>

                        <div class='form-item'>
                                <label for='engineNo'>Engine No<sup>*</sup></label>
                                <input type='text' name='engineNo' id='engineNo' placeholder='' required  value='${vehicleInfo.EngineNo}'>      
                        </div>

                        <div class='form-item'>
                                <label for='manuYr'>Manufactured Year<sup>*</sup></label>
                                <input type='text' name='manuYr' id='manuYr' placeholder='' required  value='${vehicleInfo.ManufacturedYear}'>      
                        </div>

                        <div class='form-item'>
                                <label for='engineCapacity'>Engine Capacity<sup>*</sup></label>
                                <input type='text' name='engineCapacity' id='engineCapacity' placeholder='' required  value='${vehicleInfo.EngineCapacity}'>      
                        </div>

                        <div class='form-item'>
                                <label for='vehicleType'>Vehicle Type<sup>*</sup></label>
                                <input type='text' name='vehicleType' id='vehicleType' placeholder='' required  value='${vehicleInfo.VehicleType}'>      
                        </div>

                        <div class='form-item'>
                                <label for='fuelType'>Fuel Type<sup>*</sup></label>
                                <input type='text' name='fuelType' id='fuelType' placeholder='' required  value='${vehicleInfo.FuelType}'>      
                        </div>

                        <div class='form-item'>
                                <label for='transmissionType'>Transmission Type<sup>*</sup></label>
                                <input type='text' name='transmissionType' id='transmissionType' placeholder='' required  value='${vehicleInfo.TransmissionType}'>      
                        </div>

                        <div class='form-item'>
                                <label for='modelName'>MOdel Name<sup>*</sup></label>
                                <input type='text' name='modelName' id='modelName' placeholder='' required  value='${vehicleInfo.ModelName}'>      
                        </div>

                        <div class='form-item'>
                                <label for='brandName'>Brand Name<sup>*</sup></label>
                                <input type='text' name='brandName' id='brandName' placeholder='' required  value='${vehicleInfo.BrandName}'>      
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
                    </form>`
    );

    Modal.show({
      key: "update-vehicle",
      content: updatevehicleDetailsForm,
      closable: false,
    });

    updatevehicleDetailsForm?.querySelector("#update-vehicle-modal-btn")?.addEventListener("click", (e) => {
        const UpdateConfModal = htmlToElement(`<div>
                                 <h3>Are you sure you want to update this details</h3>
                                 <div style="display: flex;align-items: center;justify-content: flex-end;gap: 1rem;margin-top: 1rem">
                                      <button class="btn btn--thin btn--danger modal-close-btn">Cancel</button>
                                      <button class="btn btn--thin modal-close-btn" id="update-vehicle-confirm-btn">Confirm</button>
                                 </div>
                              </div>`)

        Modal.show({
          closable: true,
          content: UpdateConfModal,
          key: "Update vehicle Confirmation",
        });
      });
  });
});
