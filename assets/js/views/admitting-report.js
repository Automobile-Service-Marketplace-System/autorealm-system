// // const addImage = document.querySelector("#more-image")

// // if(addImage) {
// //     const imageInput = document.querySelector("#image-input");
// //     addImage?.addEventListener("click", () => {
// //         imageInput.click();
// //     })

// //     imageInput?.addEventListener("change", async (e) => {
    
// //         const files = e.target.files;
// //         const image = files[0];
// //         console.log(image);
// //         const dataReader = new FileReader();
// //         dataReader.readAsDataURL(image);
// //         dataReader.onload = (e) => {
// //             addImage.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(${e.target.result})`;
// //             const cameraIcon = document.querySelector("#more-image svg")
// //             cameraIcon.style.color = "var(--color-white)";
// //         }
// //     })
// // }

// const admittingCards = document.querySelectorAll('.appointment-card');

// admittingCards.forEach(card => {
//     card.addEventListener('click', () => {
//         console.log(card.dataset);
//         const admittingID = card.dataset.admittingreportid;
//         console.log(admittingID);
//         // `<input type="number" value="${admittingID}" name="admitting_id" style="display: none" readonly> `
//         // const url = `/security-officer-dashboard/admitting-reports/view?admitting_id=${admittingID}`;
//         // location.href = url;
//     })
// })