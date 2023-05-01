import {htmlToElement} from "./index";

const rotatingIcon = htmlToElement(`<i class="fa-solid fa-spinner rotating-icon"></i>`)

/**
 * @param {HTMLInputElement | SVGSVGElement} element
 * @param {boolean} status
 * @param {{ color?: string} | undefined } options
 */
export function setSpinner(element, status, options = undefined) {

    if (element) {
        if (options) {
            if (options.color) {
                rotatingIcon.style.color = options.color
            } else {
                rotatingIcon.style.color = "var(--color-primary)"
            }
        }
        const parent = element.parentElement
        if (parent) {
            if (status) {
                element.style.display = "none"
                parent.append(rotatingIcon)
            } else {
                element.style.display = "initial"
                parent.querySelector(
                    ".rotating-icon"
                )?.remove()
            }
        }
    }
}