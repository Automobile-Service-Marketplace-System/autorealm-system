// const addImage = document.querySelector("#more-image")

// if(addImage) {
//     const imageInput = document.querySelector("#image-input");
//     addImage?.addEventListener("click", () => {
//         imageInput.click();
//     })

//     imageInput?.addEventListener("change", async (e) => {
    
//         const files = e.target.files;
//         const image = files[0];
//         console.log(image);
//         const dataReader = new FileReader();
//         dataReader.readAsDataURL(image);
//         dataReader.onload = (e) => {
//             addImage.style.backgroundImage = `linear-gradient(rgba(0,0,0,0.3), rgba(0,0,0,0.3)), url(${e.target.result})`;
//             const cameraIcon = document.querySelector("#more-image svg")
//             cameraIcon.style.color = "var(--color-white)";
//         }
//     })
// }
