import {Modal} from "./Modal"
import {htmlToElement} from "../utils";
import Notifier from "./Notifier";


// noinspection ExceptionCaughtLocallyJS
export class JobSelector {

    /**
     * job selector element
     * @type {HTMLDivElement | null}
     */
    element = null

    url = "/jobs/for-selector"


    limit = 8;
    page = 1;
    total = 0;


    searchTimeout = null;


    /**
     * @type {{q: null| string; page:number; limit: number}}
     */
    selectedFiltersRaw = {
        customer_name: null,
        foreman_name: null,
        vehicle_reg_no: null,
        job_date: null,
        page: 1,
        limit: 8
    }


    selectedFilters = new Proxy(this.selectedFiltersRaw, {
        set: async (target, key, value) => {
            target[key] = value
            // console.log(this.selectedFiltersRaw)
            await this.loadJobs();
            return true
        }
    })


    /**
     * @type {number | null}
     */
    selectedJob = null;


    listeners = {
        onFinish: [],
    }

    constructor() {
        return (async () => {
            this.element = this.createElement();
            Modal.show({
                closable: false,
                content: this.element,
                key: "JobSelector"
            });
            await this.initialLoad();
            this.listenForFilterChanges();
            this.attachListeners();
            return this
        })();
    }

    /**
     * @returns {HTMLDivElement}
     */
    createElement() {
        return htmlToElement(
            `
    <div class="job-selector job-selector--loading">
        <i class="fa fa-spinner job-selector__spinner"></i>
        <div class="job-selector__body">
            <div class="job-selector__header">
                <h3>Select a job</h3>
                <div class="flex items-center gap-4">
                    <button class="btn btn--danger btn--thin modal-close-btn">
                        <i class="fa fa-xmark"></i>
                        Cancel
                    </button>
                    <button class="btn btn--thin job-selector__finish">
                        <i class="fa fa-check"></i>
                        Confirm
                    </button>
                </div> 
            </div>
            <div class="job-selector__filters">
                <div class='form-item'>
                    <input type='search' name='customer_name' id='customer_name' placeholder='Search with customer name'>
                </div>
                <div class='form-item'>
                    <input type='search' name='foreman_name' id='foreman_name' placeholder='Search with foreman name'>
                </div>
                <div class='form-item'>
                    <input type='search' name='vehicle_reg_no' id='vehicle_reg_no' placeholder='Search with vehical reg no'>
                </div>
                <div class="form-item">
                    <input type="date" name="job_date" id="job_date" placeholder="Start date">
                </div>
            </div>
            <p class="job-selector__result-indicator">
                Showing <span id="job-selector__show-count"></span> of <span id="job-selector__total-count"></span> results
            </p>
            <div class="job-selector__gallery job-selector__gallery--loading">
                <i class="fa fa-spinner job-selector__spinner"></i>
                <p class="job-selector__empty-message">
                    <i class="fa fa-search"></i>
                    No jobs found
                </p>
            </div>
            <div class="pagination-container pagination-container--select">
            </div>
        </div>
    </div>`
        )
    }

    async initialLoad() {
        await this.loadJobs();
        this.element.classList.remove("job-selector--loading")
    }


    listenForFilterChanges() {
        /**
         * @type {NodeListOf<HTMLInputElement>}
         */
        const searchInputs = this.element.querySelectorAll("input[type='search']")

        searchInputs.forEach(searchInput => {
            searchInput?.addEventListener("input", () => {
                if (this.searchTimeout) {
                    clearTimeout(this.searchTimeout)
                }
                this.searchTimeout = setTimeout(() => {
                    const value = searchInput.value;
                    if (value === "") {
                        this.selectedFilters[searchInput.id] = null;
                    } else {
                        this.selectedFilters[searchInput.id] = value;
                    }

                }, 500)
            })
        })

        const dateInput = this.element.querySelector("input[type='date']")
        dateInput?.addEventListener("change", () => {
                const value = dateInput.value;
                if (value === "") {
                    this.selectedFilters[dateInput.id] = null;
                } else {
                    this.selectedFilters[dateInput.id] = value;
                }
            }
        )

    }

    async loadJobs() {
        try {
            this.setLoading(true)
            const url = this.url;
            const filters = {}
            for (const selectedFiltersKey in this.selectedFilters) {
                if (this.selectedFilters.hasOwnProperty(selectedFiltersKey)) {
                    const selectedFilter = this.selectedFilters[selectedFiltersKey];
                    if (selectedFilter) {
                        filters[selectedFiltersKey] = selectedFilter
                    }
                }
            }
            const result = await fetch(`${url}?${new URLSearchParams(filters)}`);

            switch (result.status) {
                case 200:
                    /**
                     * @type {{ total:number;limit: number;page: number;jobs: JobCard[]}}
                     */
                    let response = await result.json();
                    console.log(response)
                    this.limit = response.limit;
                    this.page = response.page;
                    this.total = response.total;
                    const jobs = response.jobs
                    this.showJobs(jobs)
                    break;
                case 500:
                    const error = await result.json();
                    throw new Error(error.error);
            }
        } catch (e) {
            console.log(e)
            Notifier.show({
                text: "Something went wrong",
                type: "danger",
                header: "Error",
                closable: true,
                duration: 2000
            })
        } finally {
            this.setLoading(false)
        }
    }


    /**
     * @param {JobCard[]} jobs
     */
    showJobs(jobs) {
        /**
         * @type {HTMLDivElement}
         */


        const jobSelectorGallery = this.element.querySelector(".job-selector__gallery")
        while (jobSelectorGallery.firstChild) {
            jobSelectorGallery.removeChild(jobSelectorGallery.firstChild)
        }

        jobSelectorGallery.innerHTML = `
                <i class="fa fa-spinner job-selector__spinner"></i>
                <p class="job-selector__empty-message">
                    <i class="fa fa-search"></i>
                    No jobs found
                </p>
        `;
        jobs.forEach(job => {
            const isAlreadySelected = this.selectedJob === job.job_card_id;
            const jobEl = htmlToElement(
                `
                    <div class="job-selector__gallery-item ${isAlreadySelected ? 'job-selector__gallery-item--selected' : ''}">
                        <h4>${job.reg_no}</h4>
                        <p  style="font-size: 0.8rem;"><strong>Customer</strong> ${job.customer_name}</p>
                        <p  style="font-size: 0.8rem;"><strong>Started on</strong> ${job.start_date_time.split(" ")[0]}</p>
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    `
            )
            jobEl.addEventListener('click', () => {
                if (jobEl.classList.contains("job-selector__gallery-item--selected")) {
                    jobEl.classList.remove("job-selector__gallery-item--selected")
                    this.selectedJob = null;
                } else {
                    jobEl.classList.add("job-selector__gallery-item--selected")
                    this.selectedJob = job.job_card_id;
                }
            })
            jobSelectorGallery.appendChild(jobEl)
        })

        if (jobs.length > 0) {
            jobSelectorGallery.classList.remove("job-selector__gallery--empty")
        } else {
            jobSelectorGallery.classList.add("job-selector__gallery--empty")
        }

        const paginationContainer = this.element.querySelector(".pagination-container")
        paginationContainer.innerHTML = "";
        for (let i = 1; i <= Math.ceil(this.total / this.limit); i++) {
            let isActive = i === this.page ? "pagination-item--active" : "";
            let button = htmlToElement(`<button class="pagination-item ${isActive}">${i}</button>`);
            button.addEventListener("click", () => {
                this.selectedFilters.page = i;
            })
            paginationContainer.appendChild(button)
        }

        const jobSelectorShowCount = this.element.querySelector("#job-selector__show-count")
        jobSelectorShowCount.innerHTML = `${jobs.length}`
        const jobSelectorTotalCount = this.element.querySelector("#job-selector__total-count")
        jobSelectorTotalCount.innerHTML = `${this.total}`
    }


    /**
     * @param {boolean} status
     */
    setLoading(status) {
        const jobSelectorGallery = this.element.querySelector(".job-selector__gallery")
        if (status) {
            jobSelectorGallery.classList.add("job-selector__gallery--loading")
        } else {
            jobSelectorGallery.classList.remove("job-selector__gallery--loading")
        }
    }


    attachListeners() {
        this.element.querySelector(".job-selector__finish").addEventListener("click", () => {
            this.finish()
        })
    }

    finish() {
        this.listeners.onFinish.forEach((callback) => {
            callback(this.selectedJob)
        })

        this.destroy()
    }

    destroy() {
        Modal.close("JobSelector")
    }


    addEventListener(event, callback) {
        switch (event) {
            case "onFinish":
                this.listeners.onFinish.push(callback)
        }
    }

}

/**
 * @typedef {Object} JobCard
 * @property {number} job_card_id
 * @property {string} reg_no
 * @property {string} start_date_time
 * @property {string} end_date_time
 * @property {string} customer_name
 */
