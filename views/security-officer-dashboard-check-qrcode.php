<!--Create a div with two buttons to either open the camera or upload an image file-->
<div id="reader">
    <i class="fa-solid fa-camera"></i>
    <input type="file" accept="image/*" capture="camera" id="image-input" style="display: none">
</div>

<div class="qrcode-result-wrapper">
    <div id="qrcode-result" style="display: none">
        <p><strong>Appointment Date</strong>11/10/2022</p>
        <p><strong>Time Slot</strong>3.00-4.30pm</p>
        <p><strong>Register Number</strong>BCM 4576</p>
        <input type="submit" value="Approve and create report" id="btn" class="btn" onclick="window.location.href='https://dashboard.autorealm.lk/security-officer-dashboard/admitting-reports/add';">
    </div>
</div>

