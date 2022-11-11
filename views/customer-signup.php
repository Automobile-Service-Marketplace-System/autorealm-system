<?php
/**
 * @var array $errors
 */

if(isset($errors)) {
    echo "<pre>";
    var_dump($errors);
    echo "</pre>";
}

$hasErrors = isset($errors) && !empty($errors);
$isEmailError = $hasErrors && isset($errors['email']);
$isNICError = $hasErrors && isset($errors['NIC']);
$isFNameError = $hasErrors && isset($errors['f_name']);
$isLNameError = $hasErrors && isset($errors['l_name']);
$isContactNoError = $hasErrors && isset($errors['contact_no']);
$isAddressError = $hasErrors && isset($errors['address']);
$isPasswordError = $hasErrors && isset($errors['password']);



?>


<form action="/register" method="post" class="customer-signup-form">
    <h1>Register with us</h1>
    <div class="form-item <?php  echo $isFNameError ? 'form-item--error' : ''  ?> ">
        <label for="f_name">First Name <sup>*</sup> </label>
        <input type="text" name="f_name" id="f_name" required>
        <?php echo $isFNameError ? "<small>{$errors['f_name']}</small>" : ""?>
    </div>
    <div class="form-item">
        <label for="l_name">Last Name</label>
        <input type="text" name="l_name" id="l_name" required>
    </div><div class="form-item">
        <label for="contact_no">Contact No</label>
        <input type="tel" name="contact_no" id="contact_no" required>
    </div><div class="form-item">
        <label for="address">Address</label>
        <input type="text" name="address" id="address" required>
    </div><div class="form-item">
        <label for="nic">NIC</label>
        <input type="text" name="nic" id="nic" required>
    </div>
    <div class="form-item">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>
    </div>
    <div class="form-item">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
    </div><div class="form-item">
        <label for="confirm_password">Confirm Password</label>
        <input type="password" name="confirm_password" id="confirm_password">
    </div>
    <div class="form-item form-item--checkbox">
        <input type="checkbox" name="ua" id="ua" required>
        <label for="ua">I agree to the <a href="/user-agreement" class="link">User agreement</a> & <a href="/privacy-policy" class="link">Privacy policy</a> </label>
    </div>
    <button class="btn btn--danger btn--block">
        Create an account
    </button>
</form>