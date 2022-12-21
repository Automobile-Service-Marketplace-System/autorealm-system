/**
 *
 * @param {string} template
 */
export function htmlToElement(template) {
    const templateEl = document.createElement('template');
    templateEl.innerHTML = template;
    return templateEl.content.firstElementChild;
}
