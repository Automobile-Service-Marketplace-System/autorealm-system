const employeeCards = document.querySelectorAll('.employee-card');


employeeCards.forEach(card => {
    card.addEventListener('click', () => {
        console.log(card.dataset)
        const employeeID = card.dataset.employeeid;
        const url = `/employees/view?employee_id=${employeeID}`;
        location.href = url;
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