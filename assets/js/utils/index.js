export * from "./spinners.util";
export * from "./scolling.util";
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

