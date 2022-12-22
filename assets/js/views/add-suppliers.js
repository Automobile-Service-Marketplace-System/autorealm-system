import {Modal} from "../components/Modal"
import {htmlToElement} from "../utils";

const addSupplierBtn = document.querySelector('#add-supplier-btn');

addSupplierBtn?.addEventListener('click', () => {

    const template = `<div>
            <button class="modal-close-btn">
                <i class="fas fa-times"></i>
            </button>
            <p>Hello, I'm a modal</p>
            <button class="btn" id="open-another">Open another modal</button>
           </div>`
    console.log(template)
    const element = htmlToElement(template);
    console.log(element)
    const openAnotherBtn = element.querySelector('#open-another');
    openAnotherBtn?.addEventListener('click', () => {
       Modal.show({
           closable: true,
           content:  `<div>This is another modal</div>`,
           key: 'another-modal'
       })
    } )})
// import {Modal} from "../components/Modal"

//     Modal.show({
//         key: "add-supplier",
//         closable: false,
//         content: element
//     })
// })
// const addSupplierButton = document.querySelector("#add-supplier")