export * from "./spinners.util";

/**
 *
 * @param {string} template
 * @return {HTMLElement}
 */
export function htmlToElement(template) {
    const templateEl = document.createElement('template');
    templateEl.innerHTML = template;
    return templateEl.content.firstElementChild;
}

