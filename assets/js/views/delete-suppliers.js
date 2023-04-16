import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";
import Notifier from "../components/Notifier";



const deleteSupplierButtons = document.querySelectorAll(".delete-supplier-btn")
deleteSupplierButtons.forEach(deleteSupplierButton =>{
    deleteSupplierButton?.addEventListener("click", () =>{
        const supplierName = deleteSupplierButton.parentElement.dataset.suppliername
        const modalContent = htmlToElement(`
                <div>
                    <p>Are you sure you want to delete "${supplierName}"?</p>
                    <div class="button-area">
                        <button class="btn btn--danger btn--thin modal-close-btn">Cancel</button>
                        <button class="btn btn--thin modal-close-btn">Confirm</button>
                    </div>
                </div>
                `)

        const confBtn = modalContent.querySelector("button:last-child")
        confBtn.addEventListener("click", async() =>{
            console.log(`confirm for product ${deleteSupplierButton.parentElement.dataset.supplierid}`)
            try{
                console.log("inside try")
                 const result = await fetch("/suppliers/delete",{
                     method: "POST",
                     body: JSON.stringify({
                         supplier_id: deleteSupplierButton.parentElement.dataset.supplierid
                     }),
                     headers:{
                         'Content-Type': 'application/json'
                     }
                 })

                switch (result.status){
                    case 204:
                        Notifier.show({
                            text: "Supplier deleted successfully",
                            type: "success",
                            header: "Success",
                        })
                        setTimeout(() => {
                            location.reload()
                        }, 800)

                        break;
                    case 500:
                        Notifier.show({
                            text: "Something went wrong: error:500",
                            type: "danger",
                            header: "Error",
                        })
                        break;
                    default:
                        console.log("inside default")
                        break;
                }
            }
            catch(e){
                console.log(e)
                Notifier.show({
                    text: "Something went wrong",
                    type: "error",
                    header: "Error",
                })
            }

        })
    Modal.show({
        key: "delete-supplier",
        content: modalContent,
    })
    })
})
