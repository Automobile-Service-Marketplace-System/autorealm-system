import {htmlToElement} from "../utils";
import {Modal} from "../components/Modal";
import Notifier from "../components/Notifier";

/**
 * @type {HTMLDivElement}
 */
const reviewsContainer = document.querySelector(".reviews")

/**
 * @type {HTMLDivElement}
 */
const paginationContainer = document.querySelector(".dashboard-pagination-container");

let reviewPage = 1;
let reviewLimit = 4;
let reviewTotal = 0;


/**
 * @type {HTMLButtonElement | null}
 */
const writeReviewButton = document.querySelector('#write-review-button');

const productNameElement = document.querySelector('#product-name');
let productName = productNameElement?.innerHTML;

// if name is too long, shortening it and adding ellipsis
if (productName && productName.length > 20) {
    productName = productName.slice(0, 20) + '...';
}

writeReviewButton?.addEventListener('click', addReview)


function addReview() {

    const reviewModal = htmlToElement(
        `
            <div class="review-modal">
                <div class="review-modal__header">
                    <p>
                        Write a review for ${productName}
                    </p>
                    <button class="modal-close-btn">
                        <i class="fas fa-times"></i>
                    </button>    
                </div>
                <div class="review-modal__body">
                    <div class="form-item">
                        <input type="number" min="1" max="5" value="5" step="1">
                    </div>
                    <div class="form-item">
                        <textarea name="review" id="review" cols="30" rows="5" placeholder="Write your review here..."></textarea>
                    </div>
                </div>
                <div class="review-modal__footer">
                    <button class="btn btn--danger btn--text btn--thin modal-close-btn">
                        Cancel
                    </button>
                    <button class="btn btn--primary btn--thin" id="review-submit-btn">
                        <i class="fa fa-spinner"></i>
                        Submit
                    </button>
                </div>
            </div>
            `
    )

    /**
     * @type {HTMLButtonElement}
     */
    const reviewSubmitButton = reviewModal.querySelector('#review-submit-btn');

    reviewSubmitButton.addEventListener('click', async () => {

        reviewSubmitButton.disabled = true;
        reviewSubmitButton.classList.add("btn--loading");

        const rating = Number(reviewModal.querySelector('input[type="number"]').value);
        const review = reviewModal.querySelector('textarea').value;

        // get id param from url
        const urlParams = new URLSearchParams(window.location.search);
        const item = Number(urlParams.get('id'));

        try {
            const result = await fetch('/reviews', {
                body: JSON.stringify({
                    rating,
                    text: review,
                    item_code: item
                }), headers: {
                    'Content-Type': 'application/json'
                }, method: 'POST'
            })


            switch (result.status) {
                case 201:
                    await loadReviews(reviewLimit, 1)
                    toggleAddReviewButton()
                    Modal.close('review-modal');
                    Notifier.show({
                        text: 'Review submitted successfully',
                        type: 'success',
                        closable: true,
                        duration: 3000,
                        header: 'Success'
                    })
                    break;

                case 400:
                    const {message} = await result.json();
                    Notifier.show({
                        text: message,
                        type: 'danger',
                        closable: true,
                        duration: 3000,
                        header: 'Error'
                    })
                    break;
                case 500:
                    const data = await result.text();
                    // console.log(data);
                    Notifier.show({
                        text: 'Internal server error',
                        type: 'danger',
                        closable: true,
                        duration: 3000,
                        header: 'Error'
                    })
            }
        } catch (e) {
            console.log(e);
            Notifier.show({
                text: 'Something went wrong',
                type: 'danger',
                closable: true,
                duration: 3000,
                header: 'Error'
            })
        } finally {
            reviewSubmitButton.disabled = false;
            reviewSubmitButton.classList.remove("btn--loading");
        }
    })


    Modal.show({
        content: reviewModal,
        closable: true,
        key: 'review-modal'
    })

}


if (reviewsContainer) {
    window.addEventListener('load', async () => {
        await loadReviews(reviewLimit, 1);
    })
}

/**
 * @param limit {number}
 * @param page {number}
 * @return {Promise<void>}
 */
async function loadReviews(limit, page) {

    const customerId = Number(reviewsContainer.dataset.customerid);
    reviewsContainer.classList.add('reviews--loading');

    try {
        const urlParams = new URLSearchParams(window.location.search);
        const item = Number(urlParams.get('id'));
        const result = await fetch(`/reviews?item_code=${item}&page=${page}&limit=${limit}`)

        switch (result.status) {
            case 200:
                /**
                 *
                 * @type {{page:number;total: number;reviews: {Text: string;Rating:number;Name: string;Image:string;Date:string,CustomerID: number}[]}}
                 */
                const data = await result.json();
                const reviews = data.reviews;
                reviewTotal = data.total;
                reviewPage = data.page;

                console.log(reviews, reviewTotal, reviewPage);

                let reviewsHtml = '';
                reviews.forEach(review => {

                    let rating = Math.round(review.Rating);
                    let stars = "";

                    new Array(rating).fill(0).forEach(() => {
                        stars += `<i class="fas fa-star" style="color: gold"></i>`
                    })


                    let emptyStars = "";
                    new Array(5 - rating).fill(0).forEach(() => {
                        emptyStars += `<i class="far fa-star" style="color: gold"></i>`
                    })


                    let reviewItem =
                        `
                            <div class='review'>
                                <div class='review__header'>
                                    <img src='${review.Image}' alt='${review.Name}'>
                                    <div>
                                        <p>${review.Name}</p>
                                        <span>${review.Date}</span>
                                    </div>
                                    <div>
                                        ${stars}
                                        ${emptyStars}
                                    </div>
                                </div>
                                <div class='review__mobile-rating'>
                                    ${stars}
                                    ${emptyStars}
                                </div>
                                <p>
                                    ${review.Text}
                                </p>
                                    ${
                            review.CustomerID === customerId ?
                                `<button class="btn btn--text btn--danger" id="review-delete-btn">
                                            <i class="fa fa-trash"></i>
                                            Delete
                                        </button>` :
                                ""
                        }
                            </div>
                            `;
                    reviewsHtml += reviewItem;
                })

                reviewsContainer.innerHTML = `${reviewsHtml}  <i class="fa-solid fa-spinner"></i>`;
                reviewsContainer.querySelector('#review-delete-btn')?.addEventListener('click', async () => {


                    const deleteConfirmationModal = htmlToElement(
                        `
                            <div class="review-modal">
                                <div class="review-modal__header">
                                    <p>
                                        Delete your review of ${productName}
                                    </p>
                                    <button class="modal-close-btn">
                                        <i class="fas fa-times"></i>
                                    </button>    
                                </div>
                                <div class="review-modal__footer">
                                    <button class="btn btn--danger btn--text btn--thin modal-close-btn">
                                        Cancel
                                    </button>
                                    <button class="btn btn--primary btn--thin" id="review-delete-confirm-btn">
                                        <i class="fa fa-spinner"></i>
                                        Confirm
                                    </button>
                                </div>
                            </div>
                            `
                    );


                    /**
                     * @type {HTMLButtonElement}
                     */
                    const deleteConfirmButton = deleteConfirmationModal.querySelector('#review-delete-confirm-btn')

                    deleteConfirmButton?.addEventListener('click', async () => {
                        deleteConfirmButton.disabled = true;
                        deleteConfirmButton.classList.add("btn--loading");

                        try {
                            const result = await fetch(`/reviews/delete?item_code=${item}`, {method: 'POST'})

                            switch (result.status) {
                                case 200:
                                    Notifier.show({
                                        text: 'Review deleted successfully',
                                        type: 'success',
                                        closable: true,
                                        duration: 3000,
                                        header: 'Success'
                                    })
                                    await loadReviews(reviewLimit, reviewPage);
                                    toggleAddReviewButton();
                                    Modal.close('review-delete-modal');
                                    break;
                                case 404:
                                    const {message} = await result.json();
                                    Notifier.show({
                                        text: message,
                                        type: 'danger',
                                        closable: true,
                                        duration: 3000,
                                        header: 'Error'
                                    })
                            }

                        } catch (e) {
                            console.log(e);
                            Notifier.show({
                                text: 'Something went wrong',
                                type: 'danger',
                                closable: true,
                                duration: 3000,
                                header: 'Error'
                            })
                        } finally {
                            deleteConfirmButton.disabled = false;
                            deleteConfirmButton.classList.remove("btn--loading");
                        }
                    })

                    Modal.show({
                        content: deleteConfirmationModal,
                        closable: true,
                        key: 'review-delete-modal'
                    })
                })

                createReviewPaginationContainer();

        }

    } catch (e) {
        console.log(e);
    } finally {
        reviewsContainer.classList.remove('reviews--loading');
    }
}

function createReviewPaginationContainer() {
    let hasNextPage = reviewPage < Math.ceil(reviewTotal / reviewLimit);
    let hasNextPageClass = hasNextPage ? "" : "dashboard-pagination-item--disabled";
    let hasPreviousPage = reviewPage > 1;
    let hasPreviousPageClass = hasPreviousPage ? "" : "dashboard-pagination-item--disabled";

    let prevBtn = `
                <button class="dashboard-pagination-item ${hasPreviousPageClass}">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
    `;

    let nextBtn = `
                <button class="dashboard-pagination-item ${hasNextPageClass}">
                  <i class="fa-solid fa-chevron-right"></i>
                </button>
    `;

    let otherButtons = "";

    for (let i = 1; i <= Math.ceil(reviewTotal / reviewLimit); i++) {
        let isActive = i === reviewPage ? "dashboard-pagination-item--active" : "";
        otherButtons += `<button class="dashboard-pagination-item ${isActive}">${i}</button>`;
    }

    paginationContainer.innerHTML = prevBtn + otherButtons + nextBtn;

    paginationContainer.querySelectorAll('.dashboard-pagination-item').forEach(item => {
        item.addEventListener('click', async () => {
            await loadReviews(reviewLimit, Number(item.textContent));
        })
    })

}

/**
 * @type {HTMLButtonElement}
 */
let addReviewButtonElement = htmlToElement(
    `<button class="btn btn--dark-blue mb-8" id="write-review-button">
                <i class="fa-solid fa-pen"></i>
                Write a review
            </button>`)

const reviewsParent = document.querySelector('#reviews-parent');

function toggleAddReviewButton() {
    const btn = document.querySelector('#write-review-button');
    if (btn) {
        btn.remove();
    } else {
        addReviewButtonElement.addEventListener('click', addReview)
        reviewsParent?.insertBefore(addReviewButtonElement, reviewsContainer);
    }
}