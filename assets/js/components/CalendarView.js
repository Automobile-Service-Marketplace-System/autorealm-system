import {htmlToElement} from "../utils"

/**
 * @typedef {Object} CalendarViewProps
 * @property {string | HTMLElement} parent
 * @property {string | HTMLInputElement} boundInput
 * @property {Date | string} minDate
 * @property {Date | string} maxDate
 * @property {{month: number;date: number}[]} restrictedDates
 */


class CalendarView {

    /**
     * @type {HTMLElement | null}
     */
    parent;

    /**
     * @type {HTMLInputElement | null}
     */
    boundInput;

    /**
     * @type {Date}
     */
    minDate;

    /**
     * @type {Date}
     */
    maxDate;

    /**
     * @type {{month: number;date: number}[]}
     */
    restrictedDates;

    /**
     * @type {HTMLDivElement}
     */
    element;

    /**
     * @type {number}
     */
    year;

    /**
     * @type {number}
     */
    month;

    /**
     * @param {CalendarViewProps} options
     */
    constructor(options) {
        this.parent = typeof options.parent === "string" ? document.querySelector(options.parent) : options.parent;
        this.boundInput = typeof options.boundInput === "string" ? document.querySelector(options.boundInput) : options.boundInput;
        this.minDate = new Date(options.minDate);
        this.maxDate = new Date(options.maxDate);
        this.restrictedDates = options.restrictedDates;

        console.log(this.maxDate)
        this.year = this.minDate.getFullYear()
        this.month = this.minDate.getMonth() + 1
        this.element = this.buildElement(this.month, this.year)
    }


    /**
     * @param {number} month
     * @param {number} year
     * @param {boolean} isChange
     */
    buildElement(month, year, isChange = false) {
        const header = this.getHeader(month, year)
        if (!isChange) {


            let datesElements = this.getConstructedCalendar(month, year)
            const calendarWrapper = htmlToElement(
                `
            <div class="calendar-view">
            </div>`
            );

            calendarWrapper.appendChild(
                header
            )

            calendarWrapper.appendChild(
                htmlToElement(
                    `
                <div class="calendar-view__dates">
                        ${datesElements}
                </div>  
                `
                )
            )

            this.parent.appendChild(calendarWrapper)
            this.setListeners(calendarWrapper.querySelectorAll(".calendar-view__date"))
            calendarWrapper.querySelectorAll(".calendar-view__date").forEach(dateEl => {
                console.log(dateEl)
            })
            return calendarWrapper
        }
        this.element.querySelector(".calendar-view__header")?.remove()
        const dates = this.element.querySelector(".calendar-view__dates")

        this.element.insertBefore(header, dates)
        dates.classList.add("calendar-view__dates--destroy")
        setTimeout(() => {
            dates?.remove()
            let datesElements = this.getConstructedCalendar(month, year)
            this.element.appendChild(htmlToElement(
                `
                <div class="calendar-view__dates calendar-view__dates--appear">
                        ${datesElements}
                </div>  
                `
            ))

            this.setListeners(this.element.querySelectorAll(".calendar-view__date"))
            // this.element.querySelectorAll(".calendar-view__date").forEach(dateEl => {
            //     console.log(dateEl)
            // })

            setTimeout(() => {
                dates?.classList.remove("calendar-view__dates--destroy")
            }, 300)

        }, 300)

        return this.element
        //
        //
        // const calendarWrapper = htmlToElement(
        //     `
        //     <div class="calendar-view">
        //     </div>`
        // );
        //
        // calendarWrapper.appendChild(
        //     header
        // )
        //
        // calendarWrapper.appendChild(
        //
        // )
        //
        // this.parent.appendChild(calendarWrapper)
        // return calendarWrapper
    }


    getHeader(month, year) {
        const isPrevMonthAvailable = this.minDate.getMonth() < month - 1
        const isNextMonthAvailable = this.maxDate.getMonth() > month - 1

        const daysElements = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'].map(day => {
            return `<p class="calendar-view__day">${day}</p>`
        }).join("");

        const months = {
            1: "January",
            2: "February",
            3: "March",
            4: "April",
            5: "May",
            6: "June",
            7: "July",
            8: "August",
            9: "September",
            10: "October",
            11: "November",
            12: "December"
        }

        const monthName = months[month]

        const header = htmlToElement(
            `
                <div class="calendar-view__header">
                    <p class="calendar-view__month">
                    ${isPrevMonthAvailable ?
                `<button id="prev-month">
                        <i class="fa-solid fa-chevron-left" ></i>
                        </button>` : ``}
                     ${monthName}
                     ${isNextMonthAvailable ?
                `<button id="next-month">
                        <i class="fa-solid fa-chevron-right" ></i>
                     </button>` : ''}
                    </p>
                    <div class="calendar-view__days">
                        ${daysElements}
                    </div>
                </div>
            `
        )
        header.querySelector("#next-month")?.addEventListener("click", () => {
            this.month = month + 1
            this.year = year
            this.changeMonth(month + 1, year)
        })

        header.querySelector("#prev-month")?.addEventListener("click", () => {
                this.month = month - 1
                this.year = year
                this.changeMonth(month - 1, year)
            }
        )

        return header
    }

    /**
     * @param {number} month
     * @param {number} year
     */
    getConstructedCalendar(month, year) {
        const numberOfDaysInThisMonth = this.getNumberOfDaysInMonth(month, year)
        const numberOfDaysInPreviousMonth = this.getNumberOfDaysInMonth(month - 1, year)

        let datesElements = ""
        const dateOffset = this.getDateOffset(month, year)
        for (let i = 1; i <= 42; i++) {
            const date = i - dateOffset

            // restricted if is in restrictedDates or if the date is before minDate or after maxDate
            const isRestricted = this.restrictedDates.some(date => date.month === month && date.date === i - dateOffset) ||
                (new Date(year, month - 1, i - dateOffset + 1) < this.minDate) ||
                (new Date(year, month - 1, i - dateOffset) > this.maxDate)

            console.log(isRestricted, month, i - dateOffset)

            if (date < 1) {
                datesElements += `<p class="calendar-view__date calendar-view__date--disabled">${date + numberOfDaysInPreviousMonth}</p>`
            } else if (date >= 1 && date <= numberOfDaysInThisMonth) {
                datesElements += `<p class="calendar-view__date ${isRestricted ? 'calendar-view__date--restricted' : ''}">${date}</p>`
            } else {
                datesElements += `<p class="calendar-view__date calendar-view__date--disabled">${date - numberOfDaysInThisMonth}</p>`
            }
        }

        return datesElements
    }

    changeMonth(month, year) {
        this.element = this.buildElement(month, year, true)
    }

    getNumberOfDaysInMonth(month, year) {
        return new Date(year, month, 0).getDate();
    }

    getDateOffset(month, year) {
        // check id first day of the month is a sun, then offset is 0
        // if it is a monday, then offset is 1, and so on
        return new Date(`${month}/1/${year}`).getDay();
    }

    /**
     * @param {NodeListOf<HTMLParagraphElement>} dateElements
     */
    setListeners(dateElements) {
        dateElements.forEach(dateEl => {
            if (!dateEl.classList.contains('calendar-view__date--disabled') && !dateEl.classList.contains('calendar-view__date--restricted')) {
                dateEl.addEventListener("click", () => {
                    this.selectedDate = new Date(this.year, this.month - 1, parseInt(dateEl.innerText))
                    this.element.querySelectorAll(".calendar-view__date").forEach(dateEl => {
                        dateEl.classList.remove("calendar-view__date--selected")
                    })
                    dateEl.classList.add("calendar-view__date--selected")
                    // this.onDateSelected(this.selectedDate)
                    console.log("Selected date is", this.selectedDate)
                    if (this.boundInput) {
                        this.boundInput.value = this.selectedDate.toLocaleDateString()
                    }
                })
            }
        })
    }

}


new CalendarView({
    // maxDate a month from now
    maxDate: (() => {
        let currentDate = new Date(); // Get the current date
        return new Date(currentDate.getFullYear(), currentDate.getMonth() + 2, 0)
    })(),
    // minDate  a day from now
    minDate: new Date(new Date().setDate(new Date().getDate() + 1)),
    parent: "#calendar-container",
    restrictedDates: [
        {month: 4, date: 29},
        {month: 4, date: 30},
        {month: 5, date: 6},
        {month: 5, date: 7},
        {month: 5, date: 18},
    ]
})