import Notifier from "../components/Notifier";

// #region Elements
/**
 * @type {NodeListOf<HTMLInputElement>}
 */
const emailOtpInputs = document.querySelectorAll("#email-otp-1, #email-otp-2, #email-otp-3, #email-otp-4, #email-otp-5, #email-otp-6")
/**
 * @type {NodeListOf<HTMLInputElement>}
 */
const mobileOtpInputs = document.querySelectorAll("#mobile-otp-1, #mobile-otp-2, #mobile-otp-3, #mobile-otp-4, #mobile-otp-5, #mobile-otp-6")
/**
 * @type {NodeListOf<HTMLDivElement>}
 */
const verificationSteps = document.querySelectorAll(".verification__step#verification__step-1, .verification__step#verification__step-2")

/**
 * @type {NodeListOf<HTMLParagraphElement>}
 */
const verificationStepIndicators = document.querySelectorAll(".step-indicator")
/**
 * @type {HTMLDivElement}
 */
const verificationProgress = document.querySelector(".verification__progress")
/**
 * @type {NodeListOf<HTMLParagraphElement>}
 */
const verificationErrorElements = document.querySelectorAll(".verification-error-element")

/**
 *
 * @type {HTMLButtonElement}
 */
const retryEmailButton = document.querySelector("#retry-email")
/**
 * @type {HTMLButtonElement}
 */
const retryMobileButton = document.querySelector("#retry-mobile")

// #endregion

emailOtpInputs[0]?.addEventListener('paste', (e) => {
    handlePaste(e, 'email')
})
mobileOtpInputs[0]?.addEventListener('paste', (e) => {
    handlePaste(e, 'mobile')
})
emailOtpInputs.forEach((emailOtpInput, index) => {
    emailOtpInput.addEventListener('beforeinput', async (e) => {
        await handleBeforeNormalInput(e, index, 'email')
    })
    emailOtpInput.addEventListener('input', async (e) => {
        await handleNormalInput(e, index, 'email')
    })
})


mobileOtpInputs.forEach((mobileOtpInput, index) => {

    mobileOtpInput.addEventListener('beforeinput', e => {
        handleBeforeNormalInput(e, index, 'mobile')
    })
    mobileOtpInput.addEventListener('input', async (e) => {
        await handleNormalInput(e, index, 'mobile')
    })
})


retryEmailButton?.addEventListener('click', async () => {
    await retrySendingOTP('email')
})

retryMobileButton?.addEventListener('click', async () => {
    await retrySendingOTP('mobile')
})

/**
 * @param {ClipboardEvent} e
 * @param {"email" | "mobile"} mode
 */
function handlePaste(e, mode) {
    e.preventDefault();
    const data = e.clipboardData.getData("text/plain")
    // exit if data is not an integer string (preceding 0 is ok)
    if (!/^\d+$/.test(data)) {
        return
    }
    data.split("").forEach(async (char, index) => {
        // if char is a digit
        if (char.match(/\d/)) {
            if (mode === "email") {
                emailOtpInputs[index].value = char
                if (index < emailOtpInputs.length - 1) {
                    emailOtpInputs[index + 1].focus()
                } else {
                    disableInputs('email');
                    await handleCompleteOTPInput(e, 'email')
                }
            } else if (mode === "mobile") {
                mobileOtpInputs[index].value = char
                if (index < mobileOtpInputs.length - 1) {
                    mobileOtpInputs[index + 1].focus()
                } else {
                    disableInputs('mobile');
                    await handleCompleteOTPInput(e, 'mobile')
                }
            }

        }
    })
}

/**
 *
 * @param {Event | InputEvent} e
 * @param {number} index
 * @param {"email" | "mobile"} mode
 */
async function handleNormalInput(e, index, mode) {
    if (e.inputType === "deleteContentBackward") {
        if (index > 0) {
            mode === 'email' ? emailOtpInputs[index - 1].focus() : mode === 'mobile' ? mobileOtpInputs[index - 1].focus() : null
        }
    } else if (e.inputType === "insertText") {
        if (mode === "email") {
            if (index < emailOtpInputs.length - 1) {
                emailOtpInputs[index + 1].focus()
            } else {
                disableInputs('email')
                await handleCompleteOTPInput(e, 'email')
            }
        } else if (mode === "mobile") {
            if (index < mobileOtpInputs.length - 1) {
                mobileOtpInputs[index + 1].focus()
            } else {
                disableInputs('mobile');
                await handleCompleteOTPInput(e, 'mobile')
            }
        }
    }
}


/**
 *
 * @param {InputEvent} e
 * @param {number} index
 * @param {"email" | "mobile"} mode
 */
async function handleBeforeNormalInput(e, index, mode) {
    if (e.data === null) return
    if (e.target.value !== "") {
        if (index < emailOtpInputs.length - 1) {
            emailOtpInputs[index + 1].focus()
            emailOtpInputs[index + 1].value = e.data

            // if last input, also handle complete OTP input
            if (mode === 'email' && (index + 1) === emailOtpInputs.length - 1) {
                disableInputs('email')
                await handleCompleteOTPInput(e, 'email')
            } else if (mode === 'mobile' && (index + 1) === mobileOtpInputs.length - 1) {
                disableInputs('mobile')
                await handleCompleteOTPInput(e, 'mobile')
            }
        }
        e.preventDefault()
        return
    }
    const digit = Number(e.data + e.target.value)
    // if valid digit between 0 and 9
    if (!Number.isNaN(digit) && digit >= 0 && digit <= 9) {
    } else {
        e.preventDefault();
    }
}

/**
 *
 * @param {InputEvent | ClipboardEvent} e
 * @param {"email" | "mobile"} mode
 */
async function handleCompleteOTPInput(e, mode) {
    const isModeEmail = mode === "email"
    try {
        verificationProgress?.classList.add("verification__progress--in-progress")
        const result = await verifyOTP(mode)
        if (result !== true) {
            throw new Error(result)
        }
        Notifier.show({
            header: "Success",
            type: "success",
            closable: true,
            duration: 5000,
            text: `Your ${isModeEmail ? "email address" : "mobile number"} has been verified successfully`
        })
        completeStep(isModeEmail ? 0 : 1)
    } catch (e) {
        /**
         * @type {string}
         */
        const errorMessage = e.message
        verificationErrorElements[isModeEmail ? 0 : 1].innerText = errorMessage
        enableInputs(isModeEmail ? 'email' : 'mobile');
        // alert(e)
    } finally {
        verificationProgress?.classList.remove("verification__progress--in-progress")
    }
}

/**
 *
 * @param {"email"|"mobile"}mode
 */
function disableInputs(mode) {
    if (mode === "email") {
        emailOtpInputs.forEach((element) => {
            element.disabled = true;
            element.readOnly = true;
        })
    } else if (mode === "mobile") {
        mobileOtpInputs.forEach((element) => {
            element.disabled = true;
            element.readOnly = true;
        })
    }
}


/**
 *
 * @param {"email"|"mobile"}mode
 */
function enableInputs(mode) {
    if (mode === "email") {
        emailOtpInputs.forEach((element) => {
            element.disabled = false;
            element.readOnly = false;
        })
    } else if (mode === "mobile") {
        mobileOtpInputs.forEach((element) => {
            element.disabled = false;
            element.readOnly = false;
        })
    }
}


/**
 *
 * @param {number} index
 */
function completeStep(index) {
    verificationSteps[index].classList.add("verification__step--completed")

    setTimeout(() => {
        verificationSteps[index].style.display = "none"
        verificationStepIndicators[0].classList.add("step-indicator--disabled")
        verificationStepIndicators[1].classList.remove("step-indicator--disabled")
        if (index === -1) {
            verificationSteps[1].classList.remove("verification__step--disabled")
            verificationSteps[1].classList.add("verification__step--active")
        } else {
            window.location.href = "/dashboard/overview"
        }
    }, 300)
}

/**
 *
 * @param {"email" | "mobile"} mode
 * @returns {Promise<string|boolean>}
 */
async function verifyOTP(mode) {
    const isModeEmail = mode === "email"
    try {
        const result = await fetch(`/register/verify?mode=${mode}`, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                otp: isModeEmail ?
                    `${emailOtpInputs[0].value}${emailOtpInputs[1].value}${emailOtpInputs[2].value}${emailOtpInputs[3].value}${emailOtpInputs[4].value}${emailOtpInputs[5].value}` :
                    `${mobileOtpInputs[0].value}${mobileOtpInputs[1].value}${mobileOtpInputs[2].value}${mobileOtpInputs[3].value}${mobileOtpInputs[4].value}${mobileOtpInputs[5].value}`
            }),
        })
        if (result.status === 200) {
            return true
        } else if (result.status === 500) {
            /**
             * @type {{
             *    message: string
             *    }}
             */
            const data = await result.json()
            throw new Error(data.message)
        }
    } catch (e) {
        return e.message
    }
}


/**
 * @param {"email"|"mobile"} mode
 * @returns {Promise<boolean | string>}
 */
async function retrySendingOTP(mode) {
    const isEmailMode = mode === "email"
    isEmailMode ? retryEmailButton.innerText = "Sending..." : retryMobileButton.innerText = "Sending..."
    isEmailMode ? retryEmailButton.disabled = true : retryMobileButton.disabled = true
    isEmailMode ? retryEmailButton.classList.add("btn--loading") : retryMobileButton.classList.add("btn--loading")
    try {
        const result = await fetch(`/register/verify/retry?mode=${mode}`, {
            method: "POST",
            headers: {
                'Content-Type': 'application/json'
            }
        })
        if (result.status === 200) {
            Notifier.show({
                header: "Success",
                type: "success",
                closable: true,
                duration: 5000,
                text: `OTP sent to your ${isEmailMode ? "email address" : "mobile number"}`
            })
            return true;
        } else if (result.status === 500) {
            /**
             * @type {{
             *    message: string
             *    }}
             */
            const data = await result.text()
            console.log(data)
            throw new Error(data.message)
        }
    } catch (e) {
        return e.message
    } finally {
        isEmailMode ? retryEmailButton.innerText = "Didn't receive or invalid OTP? Try again" : retryMobileButton.innerText = "Didn't receive or invalid OTP? Try again"
        isEmailMode ? retryEmailButton.disabled = false : retryMobileButton.disabled = false
        isEmailMode ? retryEmailButton.classList.remove("btn--loading") : retryMobileButton.classList.remove("btn--loading")
    }
}