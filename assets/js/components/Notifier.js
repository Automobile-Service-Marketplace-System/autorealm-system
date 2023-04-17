class NotifierElement {
    /**
     * @type {number}
     */
    id;
    /**
     * @type {boolean}
     */
    closable;
    /**
     * @type {number}
     */
    duration;
    /**
     * @type {string | undefined}
     */
    header;
    /**
     * @type {string}
     */
    text;
    /**
     * @type {'success' | 'danger' | 'warning' | 'info' | 'dark' | 'light' }
     */
    type;
    /**
     * @type {HTMLDivElement | undefined}
     */
    #element = undefined;

    /**
     * @type {number | undefined}
     */
    x1;
    /**
     * @type {number | undefined}
     */
    x2;

    /**
     *
     * @param {{ id: number, header?: string, text: string, duration: number, closable: boolean, type?: 'success' | 'danger' | 'warning' | 'info' | 'dark' | 'light' }} options
     */
    constructor({duration, closable, id, text, header, type}) {
        this.id = id;
        this.closable = closable;
        this.duration = duration;
        this.header = header;
        this.text = text;
        this.type = type;
    }

    createElement() {
        const wrapper = document.createElement("div");
        wrapper.classList.add("notifier");
        if (window.innerWidth < 577) {
            wrapper.classList.add("notifier--mobile");
        } else {
            wrapper.classList.add("notifier--desktop");
        }
        if (this.type) {
            wrapper.style.setProperty(
                "--background-color",
                `var(--color-${this.type})`
            );
        } else {
            wrapper.style.setProperty("--background-color", `var(--color-info)`);
        }
        wrapper.id = `notifier-${this.id}`;

        this.setPosition(wrapper);
        this.createHeader(wrapper);
        this.createText(wrapper);
        this.handleDuration(wrapper);
        this.handleDragClose(wrapper);
        this.#element = wrapper;
        return wrapper;
    }

    /**
     *
     * @param {HTMLDivElement} wrapper
     */
    close(wrapper) {
        wrapper.classList.add("notifier--desktop--leave");
        // if (window.innerWidth < 577) {
        wrapper.classList.add("notifier--mobile--leave");
        // } else {
        // wrapper.classList.add("notifier--desktop--leave");
        // }
        setTimeout(() => {
            if (document.body.contains(wrapper)) {
                document.body.removeChild(wrapper);
                Notifier.activeNotifiers.splice(
                    Notifier.activeNotifiers.indexOf(this),
                    1
                );
            }
        }, 300);
        this.goUp(this.id);
    }

    /**
     * @param {HTMLDivElement} wrapper
     * @param {HTMLHeadingElement} notifierHeader
     */
    handleCloseButton(wrapper, notifierHeader) {
        const closeButton = document.createElement("button");
        closeButton.innerHTML = `<i class="fa-solid fa-xmark"></i>`;

        closeButton.addEventListener("click", () => {
            this.close(wrapper);
        });

        notifierHeader.appendChild(closeButton);
    }

    /**
     * @param {HTMLDivElement} wrapper
     */
    handleDragClose(wrapper) {
        wrapper.addEventListener("touchstart", (e) => {
            this.x1 = e.touches[0].clientX;
        }, {passive: true});
        wrapper.addEventListener("touchend", (e) => {
            this.x2 = e.changedTouches[0].clientX;
            if (this.x2 >= this.x1 + 100) {
                this.close(wrapper);
            }
        }, {passive: true});
    }

    /**
     * @param {HTMLDivElement} wrapper
     */
    handleDuration(wrapper) {
        if (this.duration) {
            const durationBar = document.createElement("hr");
            wrapper.style.setProperty("--margin-bottom", `1rem`);
            wrapper.appendChild(durationBar);
            wrapper.style.setProperty("--duration", `${this.duration}ms`);
            durationBar.classList.add("leaving");
            setTimeout(() => {
                this.close(wrapper);
            }, this.duration);
        }
    }

    /**
     *
     * @param {HTMLDivElement} wrapper
     */
    createHeader(wrapper) {
        const notifierHeader = document.createElement("h4");
        notifierHeader.classList.add("notifier__header");
        notifierHeader.innerHTML = this.header ? this.header : "";
        if (this.closable || this.closable === undefined) {
            this.handleCloseButton(wrapper, notifierHeader);
        }
        wrapper.appendChild(notifierHeader);
    }

    /**
     * @param {HTMLDivElement} wrapper
     */
    createText(wrapper) {
        const notifierText = document.createElement("p");
        notifierText.innerHTML = this.text;
        wrapper.appendChild(notifierText);
    }

    /**
     *
     * @param {HTMLDivElement} wrapper
     */
    setPosition(wrapper) {
        const prevBottom = Notifier.activeNotifiers
            .find((notifier) => notifier.id === this.id - 1)
            ?.element?.getBoundingClientRect()?.bottom;
        if (prevBottom) {
            wrapper.style.setProperty(
                "--desktop-top",
                `calc(1rem + ${prevBottom}px)`
            );
        }
    }

    /**
     * Actual notifier html element
     */
    get element() {
        if (this.#element) return this.#element;
        return this.createElement();
    }

    /**
     *
     * @param {number} id
     */
    goUp(id) {
        const currEL = Notifier.activeNotifiers.find((n) => n.id === id);
        const nextEl =
            Notifier.activeNotifiers[Notifier.activeNotifiers.indexOf(currEL) + 1];
        if (!nextEl) return;
        if (currEL) {
            // const top = currEL.element.getBoundingClientRect().top;
            const height = currEL.element.getBoundingClientRect().height;
            // get current --desktop-top of nextEl
            const nextElTop = nextEl.element.style.getPropertyValue(
                "--desktop-top"
            ).replace("px", "");

            const newNextElTop = nextElTop - height - 16;
            console.log(nextElTop)

            nextEl.element.style.setProperty("--desktop-top", `${newNextElTop}px`);
            console.log(`currEl = ${currEL.id}, currEl.top = ${top}, nextEl = ${nextEl.id}, nextEl.top = ${nextEl.element.style.getPropertyValue("--desktop-top")}`)
            this.goUp(nextEl.id);
        }
    }
}

export default class Notifier {
    /**
     * Array to temporarily keep the active notifiers
     * @type {NotifierElement[]}
     */
    static activeNotifiers = [];

    /**
     *Create the notifier element object and returns the associated html element
     * @param {{ header?: string, text: string, duration?: number, closable?: boolean, type?: 'success' | 'danger' | 'warning' | 'info' | 'dark' | 'light' }} options
     */
    static #createNotifier({closable, duration, text, header, type}) {
        const notifierElement = new NotifierElement({
            id: Notifier.activeNotifiers[Notifier.activeNotifiers.length - 1]
                ? Notifier.activeNotifiers[Notifier.activeNotifiers.length - 1].id + 1
                : 1,
            closable,
            duration,
            header,
            text,
            type,
        });

        Notifier.activeNotifiers.push(notifierElement);
        return notifierElement.element;
    }

    /**
     * Show a notification to user
     * @param {{header: string, text: string, type: string}} options
     */
    static show(options) {
        const notifier = Notifier.#createNotifier(options);
        document.body.appendChild(notifier);
    }
}
