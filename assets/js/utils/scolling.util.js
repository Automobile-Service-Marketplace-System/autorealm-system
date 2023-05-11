/**
 * Disable scroll on body without changing the width of the body
 */
export function disableScrollOnBody() {
    document.body.style.overflow = "hidden";
}

/**
 * Enable scroll on body again
 * @param {string} scrollMode
 */
export function enableScrollOnBody(scrollMode) {
    document.body.style.overflow = scrollMode;
}