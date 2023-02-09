const employeeCards = document.querySelectorAll('.employee-card');


employeeCards.forEach(card => {
    card.addEventListener('click', () => {
        console.log(card.dataset)
        const employeeID = card.dataset.employeeid;
        const url = `/employees/view?employee_id=${employeeID}`;
        location.href = url;
     })
})