import { htmlToElement } from "../utils";

const admittingReportAddImages = document.querySelector(
  ".admitting-report-add-images"
);
const admittingReportAdImagesContainer = document.querySelector(
  ".admitting-report-add-images-container"
);

const admittingReportAddImagesInput = document.querySelector(
  "#admitting-report-add-images__input"
);

let index = 1;

admittingReportAddImagesInput?.addEventListener("change", () => {
  // console.log(admittingReportAddImagesInput.files[0]);
  admittingReportAdImagesContainer.querySelectorAll("div").forEach((el)=>
  {
    el.remove();
  })

  if ( admittingReportAddImagesInput.files && admittingReportAddImagesInput.files.length > 0) {
    Array.from(admittingReportAddImagesInput.files).forEach((file) => {
      const reader = new FileReader();
      reader.readAsDataURL(file);
      reader.onload = function () {
        const dataUrl = reader.result;
        const element = htmlToElement(
          `<div> <img src="${dataUrl}" > <input type> </div>`,

        );
        admittingReportAdImagesContainer.appendChild(element);
      };
    });
  }
});
