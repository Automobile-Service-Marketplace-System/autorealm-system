import {htmlToElement} from "../../utils";
import Notifier from "../../components/Notifier";

/**
 * @typedef {Object} Technician
 * @property {number} Name
 * @property {string} ID
 * @property {string} Image
 * @property {boolean} IsAvailable
 */


/**
 * @type {HTMLDivElement | null}
 */
export const createJobTechniciansContainer = document.querySelector(".create-job__employees")

if (createJobTechniciansContainer) {

    async function loadTechnicians() {
        try {
            const result = await fetch("/technicians")
            if (result.status === 200) {
                /**
                 * @type {{data: Technician[]}}
                 */
                const response = await result.json()
                console.log(response.data)
                return response.data
            }
        } catch (e) {
            Notifier.show({
                text: "Failed to load technicians",
                closable: true,
                duration: 5000,
                header: "Error",
                type: "danger"
            })
        }
    }

    /**
     * @param {Technician[]} technicians
     */
    function showTechnicians(technicians) {
        createJobTechniciansContainer?.append(...technicians.map(technician => {
            const element = htmlToElement(
                `
                <div class="create-job__technicians-item">
                    <div class="flex items-center gap-4"> 
                        <span class="${technician.IsAvailable ? 'success' : 'danger'}"></span>
                        <p> ${technician.IsAvailable ? 'Available' : 'Busy  +'}  </p>
                    </div>
                    <img src="${technician.Image}" alt="${technician}'s image">
                    <h4>${technician.Name}</h4>
                    <i class="fa-solid fa-circle-check"></i>
                    <input type="checkbox" name="technicians[]" value="${technician.ID}" style="display: none">
                </div>
                `
            )
            element.addEventListener("click", () => {
                    element.classList.toggle("create-job__technicians-item--selected")
                    if (element.classList.contains("create-job__technicians-item--selected")) {
                        element.querySelector("input")?.setAttribute("checked", "checked")
                    } else {
                        element.querySelector("input")?.removeAttribute("checked")
                    }
                }
            )
            return element
        }))
    }

    window.addEventListener("load",
        async () => {
            showTechnicians(await loadTechnicians())
        })
}
