import Notifier from "../components/Notifier";

/**
 *
 * @type {NodeListOf<HTMLInputElement>}
 */
const emailOtpInputs = document.querySelectorAll("#email-otp-1, #email-otp-2, #email-otp-3, #email-otp-4, #email-otp-5, #email-otp-6")
/**
 *
 * @type {NodeListOf<HTMLDivElement>}
 */
const verificationSteps = document.querySelectorAll(".verification__step#verification__step-1, .verification__step#verification__step-2")

/**
 *
 * @type {NodeListOf<HTMLParagraphElement>}
 */
const verificationStepIndicators = document.querySelectorAll(".step-indicator")
/**
 *
 * @type {HTMLDivElement}
 */
const verificationProgress = document.querySelector(".verification__progress")

emailOtpInputs[0]?.addEventListener('paste', handlePaste)
emailOtpInputs.forEach((emailOtpInput, index) => {

    emailOtpInput.addEventListener('beforeinput', e => {
        handleBeforeNormalInput(e, index)
    })

    emailOtpInput.addEventListener('input', async (e) => {
        await handleNormalInput(e, index)
    })
})

/**
 * @param {ClipboardEvent} e
 */
function handlePaste(e) {
    e.preventDefault();
    const data = e.clipboardData.getData("text/plain")
    // exit if data is not a integer string (preceding 0 is ok)
    if (!/^\d+$/.test(data)) {
        return
    }
    data.split("").forEach(async (char, index) => {
        // if char is a digit
        if (char.match(/\d/)) {
            emailOtpInputs[index].value = char
            if (index < emailOtpInputs.length - 1) {
                emailOtpInputs[index + 1].focus()
            } else {
                disableEmailInputs();
                await handleCompleteEmailOTPInput(e)
            }
        }
    })
}

/**
 *
 * @param {InputEvent} e
 * @param {number} index
 */
async function handleNormalInput(e, index) {
    console.log(emailOtpInputs[index].value)
    if (e.inputType === "deleteContentBackward") {
        if (index > 0) {
            emailOtpInputs[index - 1].focus()
        }
    } else if (e.inputType === "insertText") {
        if (index < emailOtpInputs.length - 1) {
            emailOtpInputs[index + 1].focus()
        } else {
            disableEmailInputs();
            await handleCompleteEmailOTPInput(e)
        }
    }
}


/**
 *
 * @param {InputEvent} e
 * @param {number} index
 */
function handleBeforeNormalInput(e, index) {
    if(e.data === null) return
    const digit= Number(e.data + e.target.value)
    // if valid digit between 0 and 9
    if (!Number.isNaN(digit) && digit >= 0 && digit <= 9) {}
    else {
        e.preventDefault();
    }
}

/**
 *
 * @param {InputEvent | ClipboardEvent} e
 */
async function handleCompleteEmailOTPInput(e) {
    try {
        verificationProgress?.classList.add("verification__progress--in-progress")
        await verifyEmail()
        Notifier.show({
            header: "Success",
            type: "success",
            closable: true,
            duration: 5000,
            text: "Your email has been verified successfully"
        })
        completeStep(0)
    } catch (e) {
        enableEmailInputs();
        alert(e)
    } finally {
        verificationProgress?.classList.remove("verification__progress--in-progress")
    }
}


function disableEmailInputs() {
    emailOtpInputs.forEach((element) => {
        element.disabled = true;
        element.readOnly = true;
    })
}


function enableEmailInputs() {
    emailOtpInputs.forEach((element) => {
        element.disabled = false;
        element.readOnly = false;
    })
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
        if(index === 0 ) {
            verificationSteps[1].classList.remove("verification__step--disabled")
            verificationSteps[1].classList.add("verification__step--active")
        }
    }, 300)
}

function verifyEmail() {
    return new Promise((resolve, reject) => {
        setTimeout(() => {
                resolve("something")
            },
            3000)
    })
}