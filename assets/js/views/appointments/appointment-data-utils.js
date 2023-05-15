import Notifier from "../../components/Notifier";
import {htmlToElement} from "../../utils";


export const appointmentDataUtils = {
    /**
     * @type {Array<{time_id: number, from_time: string, to_time:string}>}
     */
    timeslots: [],
    /**
     * @type {{month:number, date: number}[]}
     */

    holidays: []
}

/**
 * @param input {HTMLInputElement}
 * @param formEl {HTMLElement}
 * @returns {Promise<void>}
 */
export async function loadTimeSlots(input, formEl) {
    try {
        const date = input.value;
        console.log(date)
        const result = await fetch(`/appointments/timeslots?date=${date}`);

        switch (result.status) {
            case 404:
                Notifier.show({
                    text: "No timeslots available", type: "danger", header: "Error", closable: true, duration: 5000
                });
                appointmentDataUtils.timeslots = [];
                break;
            case 200:
                const resultBody = await result.json();
                appointmentDataUtils.timeslots = resultBody;
                const selectTag = formEl.querySelector("select#timeslot");
                appointmentDataUtils.timeslots.forEach((timeslot) => {
                    const option = htmlToElement(`<option value="${timeslot.time_id}">
                                    ${timeslot.from_time} - ${timeslot.to_time}
                                 </option>`)
                    selectTag.appendChild(option)
                })

        }
    } catch (e) {
        console.log(e)
        Notifier.show({
            text: "Something went wrong", type: "danger", header: "Error", closable: true, duration: 5000,
        });
    }
}


/**
 * @returns {Promise<void>}
 */
export async function loadHolidays() {
    try {
        const result = await fetch(`/holidays`);
        console.log(await result.text())
        return
        switch (result.status) {
            case 404:
                appointmentDataUtils.holidays = [];
                break;
            case 200:
                /**
                 * @type {{holidays: {date: string, id: number}[]}}
                 */
                const resultBody = await result.json();
                appointmentDataUtils.holidays = resultBody.holidays.map((holiday) => {
                    const dateObj = new Date(holiday.date);
                    const month = dateObj.getMonth() + 1;
                    const date = dateObj.getDate();
                    return {month, date}
                })

        }
    } catch (e) {
        console.log(e)
        Notifier.show({
            text: "Something went wrong", type: "danger", header: "Error", closable: true, duration: 5000,
        });
    }
}