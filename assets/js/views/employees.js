const employeeCards = document.querySelectorAll('.employee-card');


employeeCards.forEach(card => {
    card.addEventListener('click', () => {
        const employeeID = card.dataset.employeeid;
        const employeeJobType = card.dataset.employeejobtype;
        console.log(employeeJobType);
        `<input type="number" value="${employeeID}" name="employee_id" style="display: none" readonly> `
        if(employeeJobType !== "admin"){
          const url = `/employees/view?employee_id=${employeeID}`;
          location.href = url;
        }
     })
})

function loadImage(event) {
    var file = event.target.files[0];
    var reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = function() {
      var imagePreview = document.getElementById('image-preview');
      imagePreview.src = reader.result;
    };
}