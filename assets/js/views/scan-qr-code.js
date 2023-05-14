import QRScanner from 'qr-scanner';
import Notifier from "../components/Notifier";


const openCameraBtn = document.querySelector("#open-camera-btn");
const imageInput = document.querySelector("#image-input");
//catch the image-input id

const resultContainer = document.querySelector("#qrcode-result");
console.log(resultContainer)
//catch the qrcode-result id

/**
 * @type {HTMLAnchorElement | null}
 */
const createAdmittingReportLink = resultContainer?.querySelector("a")
//if anchor elements exit, get the first anchor element (<a>) found in the resultcontainer
//if no anchor elements are found or if resultContainer is null or undefined, the value of createAdmittingReportLink will be null.


const qrCodeDate = document.querySelector("#qrcode-result p:first-child");
const qrCodeTime = document.querySelector("#qrcode-result p:nth-child(2)");
const qrCodeRegisterNo = document.querySelector("#qrcode-result p:nth-child(3)");
//get the data

const reader = document.querySelector("#reader")
console.log(reader)


if (reader && qrCodeDate && qrCodeRegisterNo && qrCodeTime && resultContainer) {
    reader?.addEventListener("click", () => {
        imageInput.click();
    })
    //If reader is null or undefined, the code skips the rest of the expression
    //If reader is not null or undefined, the addEventListener method is called on the element referenced by reader.

    imageInput?.addEventListener("change", async (e) => {
        const files = e.target.files;
        //retrieves the files array that contains the selected file(s) from the file input field.
        const image = files[0];
        console.log(image);
        const dataReader = new FileReader();
        //read the contents of the selected file.
        dataReader.readAsDataURL(image);
        //reads the contents of the selected file as a data URL
        //can be used to display the image in the web page.
        dataReader.onload = (e) => {
            //image are loaded into memory
            reader.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(${e.target.result})`;
            //the linear-gradient is a CSS property that creates a gradient background for the div element
            const cameraIcon = document.querySelector("#reader svg")
            //wueryselector() used to select the camera icon element using its id, which is #reader svg
            cameraIcon.style.color = "var(--color-white)";
        }

        try {
            console.log("start scanning");
            const scanResult = await QRScanner.scanImage(image)
            //uses a function called scanImage() provided by a QR scanning library called QRScanner
            const appointmentObject = JSON.parse(scanResult);
            //contains the data encoded within the QR code, as a JSON object using the JSON.parse() method
            qrCodeDate.innerHTML = `<strong>Appointment Date</strong><span>${appointmentObject['date']}</span>`;
            qrCodeTime.innerHTML = `<strong>Time Slot</strong><span>${appointmentObject['timeslot']}</span>`;
            qrCodeRegisterNo.innerHTML = `<strong>Register Number</strong><span>${appointmentObject['registrationNumber']}</span>`;
            createAdmittingReportLink?.setAttribute("href", `https://dashboard.autorealm.lk/security-officer-dashboard/admitting-reports/add?reg_no=${appointmentObject['registrationNumber']}`)
            resultContainer.style.display = "flex";

            Notifier.show({
                header: "Scan Successful",
                text: "QR Code is valid.<br>Approve and create the admitting report",
                type: "success"
            })
            //shows a notification message 
        } catch (e) {
            console.log(e);
        }

    })

}
