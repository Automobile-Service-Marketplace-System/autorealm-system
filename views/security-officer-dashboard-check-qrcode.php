<!--Create a div with two buttons to either open the camera or upload an image file-->
<div id="reader">
    <i class="fa-solid fa-camera"></i>
    <input type="file" accept="image/*" capture="camera" id="image-input" style="display: none">
</div>

<div class="qrcode-result-wrapper">
    <div id="qrcode-result" style="display: none">
        <p><strong>Appointment Date</strong></p>
        <p><strong>Time Slot</strong></p>
        <p><strong>Register Number</strong></p>
        <a id="btn" class="btn">
            Approve and create report
        </a>
    </div>
</div>

