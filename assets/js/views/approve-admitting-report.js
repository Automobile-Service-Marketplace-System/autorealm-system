import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";

/**
 *
 * @type {NodeListOf<HTMLButtonElement>}
 */
const approveAdmittingReportButton = document.querySelector('#admitting-report-approve');
// console.log("Tharushi"  );
// console.log(approveAdmittingReportButton.dataset.reportno);
approveAdmittingReportButton?.addEventListener("click", () => {
 
    const modalContent = htmlToElement(`
        <div>
            <p>Are you sure you want to approve?</p>
            <div class="button-area">
                <button class="btn btn--danger btn--thin modal-close-btn">Cancel</button>
                <button class="btn btn--thin modal-close-btn">Confirm</button>
            </div>
        </div>
    `);

    console.log(approveAdmittingReportButton.dataset.reportno);
    const confirmBtn = modalContent.querySelector("button:last-child");
    confirmBtn.addEventListener("click", async () => {
    //   console.log("Tharushi");
    // console.log(approveAdmittingReportButton.dataset.reportno);
        try {
            const result = await fetch("/security-officer-dashboard/admitting-reports/approve", {
                method: "POST",
                body: JSON.stringify({
                    report_no: Number(approveAdmittingReportButton.dataset.reportno)
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })

            console.log(await result.text())

            // const

            switch (result.status) {
                case 204:
                    Notifier.show({
                        text: "Approved successfully",
                        type: "success",
                        header: "Success",
                    })
                    setTimeout(() => {
                        location.reload()
                    }, 800)

                    break;

                case 500:
                    Notifier.show({
                        text: "Something went wrong",
                        type: "danger",
                        header: "Error",
                    })
                    break;
                default:

                    break

            }
        } catch (e) {
            console.log(e)
            Notifier.show({
                text: "Something went wrong",
                type: "error",
                header: "Error",
            })
        }
    })

    Modal.show({
        key: "approve-report",
        content: modalContent,
    })

  })