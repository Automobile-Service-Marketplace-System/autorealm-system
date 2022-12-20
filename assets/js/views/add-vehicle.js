import {Modal} from "../components/Modal"

const addVehicleButton = document.querySelector("#add-vehicle-for-customer")

const urlSearchParams = new URLSearchParams(window.location.search);
const params = Object.fromEntries(urlSearchParams.entries());
console.log(params)

const addVehicleForm = `<form action="/office-staff-dashboard/vehicles/add/by-customer?id=${params.id}" method="post" class="office-staff-add-customer-form"
enctype="multipart/form-data">

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
                <option value='1' selected>Motorcycle</option><option value='2' >Motor Tricycle</option><option value='3' >Motor Vehicle</option><option value='4' >Motor Lorry</option><option value='5' >Motor Coach</option><option value='6' >Special Purpose Vehicle</option>
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

<div class="office-staff-btn">
    <button class="btn btn--danger btn--block">
        Reset
    </button>

    <button class="btn btn--blue btn--block">
        Create an account
    </button>
</div>
</form>`

addVehicleButton?.addEventListener("click", ()=>{
    Modal.show({
        content: addVehicleForm,
        closable: false,
        key: "addVehicleForm"
    })
})