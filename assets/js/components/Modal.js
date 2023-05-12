import {disableScrollOnBody, enableScrollOnBody, htmlToElement} from "../utils";


class ModalElement {

    /**
     * @type {HTMLDivElement | undefined}
     */
    overlayEl;

    /**
     * @type {HTMLDivElement | undefined}
     */
    modalEl;


    /**
     *@type {string | undefined}
     */
    key;

    /**
     * @type {string | undefined}
     */
    previousScrollMode;

    /**
     * @param {{ content: string|HTMLElement, closable: boolean, key: string   }} options
     */
    constructor({closable, content, key}) {
        this.key = key;
        this.createModalElement();
        this.addModalContent(content);
        this.showModal();
        this.handleOutsideClick(closable);
    }


    createModalElement() {
        this.overlayEl = document.createElement("div");
        this.overlayEl.classList.add("modal-overlay");
        this.overlayEl.style.display = "block";
        this.modalEl = document.createElement("div");
        this.modalEl.classList.add("modal");
    }


    /**
     *
     * @param {string | HTMLElement} content
     */
    addModalContent(content) {

        if (content instanceof HTMLElement) {
            this.modalEl.appendChild(content);
            const closeButtons = this.modalEl.querySelectorAll(".modal-close-btn");
            closeButtons.forEach((closeBtn) => {
                closeBtn.addEventListener("click", () => {
                    this.destroy();
                });
            })
            return
        }

        const modalContentEl = htmlToElement(content);
        const closeButtons = modalContentEl.querySelectorAll(".modal-close-btn");
        closeButtons.forEach((closeBtn) => {
            closeBtn.addEventListener("click", () => {
                this.destroy();
                // Modal.activeModals.splice(Modal.activeModals.indexOf(this), 1);
            });
        })
        this.modalEl.appendChild(modalContentEl);
    }

    showModal() {
        this.modalEl.style.display = "block";
        this.overlayEl.appendChild(this.modalEl);
        document.body.appendChild(this.overlayEl);
        this.modalEl.classList.add("modal-open");
        this.overlayEl.classList.add("overlay-open");
        // get current scroll mode of the body
        this.previousScrollMode = document.body.style.overflow;
        // disable scroll
        // document.body.style.overflow = "hidden";
        disableScrollOnBody();
    }

    /**
     * @param {boolean} closable
     */
    handleOutsideClick(closable) {
        if (closable) {
            this.overlayEl.addEventListener("click", (e) => {
                if (e.target === this.overlayEl) {
                    this.destroy();
                    // Modal.activeModals.splice(Modal.activeModals.indexOf(this), 1);
                }
            });
        }
    }


    destroy() {
        if (this.modalEl && this.overlayEl) {
            this.overlayEl.classList.remove("overlay-open");
            this.modalEl.classList.remove("modal-open");
            this.modalEl.classList.add("modal-close");
            this.overlayEl.classList.add("overlay-close");

            setTimeout(() => {
                this.modalEl.style.display = "none";
                this.overlayEl.style.display = "none";
                this.modalEl.classList.remove("modal-close");
                this.overlayEl.classList.remove("overlay-close");

                this.modalEl.remove();
                this.overlayEl.remove();
                this.modalEl = undefined;
                this.overlayEl = undefined;
            }, 200);

            Modal.activeModals.splice(Modal.activeModals.indexOf(this), 1);
            // restore previous scroll mode
            // document.body.style.overflow = this.previousScrollMode;
            enableScrollOnBody(this.previousScrollMode)
        }
    }
}

export class Modal {

    /**
     * @type {ModalElement[]}
     */
    static activeModals = []

    /**
     * @param {{ content: string | Element |HTMLElement, closable?: boolean, key: string   }} options
     */
    static show({closable, content, key}) {
        const modal = new ModalElement({closable: closable || closable === undefined, content, key});
        Modal.activeModals.push(modal);
    }

    /**
     *
     * @param {string} key
     */
    static close(key) {
        const modal = Modal.activeModals.find(modal => modal.key === key);
        if (modal) {
            modal.destroy();
            Modal.activeModals = Modal.activeModals.filter(modal => modal.key !== key);
        }
    }

}






