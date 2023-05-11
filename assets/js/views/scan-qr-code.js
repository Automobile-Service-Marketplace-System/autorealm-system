import QRScanner from 'qr-scanner';
import Notifier from "../components/Notifier";

const openCameraBtn = document.querySelector("#open-camera-btn");
const imageInput = document.querySelector("#image-input");
const resultContainer = document.querySelector("#qrcode-result");

/**
 * @type {HTMLAnchorElement | null}
 */
const createAdmittingReportLink = resultContainer?.querySelector("a")

const qrCodeDate = document.querySelector("#qrcode-result p:first-child");
const qrCodeTime = document.querySelector("#qrcode-result p:nth-child(2)");
const qrCodeRegisterNo = document.querySelector("#qrcode-result p:nth-child(3)");

const reader = document.querySelector("#reader")

if (reader && qrCodeDate && qrCodeRegisterNo && qrCodeTime && resultContainer) {
    reader?.addEventListener("click", () => {
        imageInput.click();
    })

    imageInput?.addEventListener("change", async (e) => {
        const files = e.target.files;
        const image = files[0];
        console.log(image);
        const dataReader = new FileReader();
        dataReader.readAsDataURL(image);
        dataReader.onload = (e) => {
            reader.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(${e.target.result})`;
            const cameraIcon = document.querySelector("#reader svg")
            cameraIcon.style.color = "var(--color-white)";
        }

        try {
            console.log("start scanning");
            const scanResult = await QRScanner.scanImage(image)
            const appointmentObject = JSON.parse(scanResult);
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
        } catch (e) {
            console.log(e);
        }

    })

}
