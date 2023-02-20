<?php

/**
 *  @var array $errors
 */

use app\components\FormItem;

$hasErrors = isset($errors) && !empty($errors);
$hasFNameError = $hasErrors && isset($errors['f_name']);
$hasLNameError = $hasErrors && isset($errors['l_name']);
$hasFIError = $hasErrors && isset($errors['fi']);
$hasDOBError = $hasErrors && isset($errors['dob']);
$hasNICError = $hasErrors && isset($errors['nic']);
$hasAddressError = $hasErrors && isset($errors['address']);
$hasContactNoError = $hasErrors && isset($errors['contact_no']);
$hasEmailError = $hasErrors && isset($errors['email']);
$hasPasswordError = $hasErrors && isset($errors['password']);
$hasConfirmPasswordError = $hasErrors && isset($errors['confirm_password']);
$hasImageError = $hasErrors && isset($errors['image']);
?>


<main class="create-employee">
    <form action="/employees/add" method="post" enctype="multipart/form-data">
        <p>Add a new staff account, these accounts will allow your employees to<br> access their respective dashboards</p>
        <b>Choose the account type</b>
        <div class="role-input">
            <div class="role-input-item">
                <input type="radio" id="security-officer" name="job_role" value="security_officer">
                <label for="security-officer">Security Officer</label>
            </div>
            <div class="role-input-item">
                <input type="radio" id="office-staff" name="job_role" value="office_staff_member">
                <label for="office-staff">Office Staff</label>
            </div>
            <div class="role-input-item">
                <input type="radio" id="foreman" name="job_role" value="foreman">
                <label for="foreman">Foreman</label>
            </div>
            <div class="role-input-item">
                <input type="radio" id="technician" name="job_role" value="technician">
                <label for="technician">Technician</label>
            </div>
            <div class="role-input-item">
                <input type="radio" id="stock-manager" name="job_role" value="stock_manager">
                <label for="stock-manager">Stock Manager</label>

            </div>
        </div>

        <div class="part">
            <div class="part1">
                <div class="form-input">
                    <?php
                    FormItem::render(
                        id: "f_name",
                        label: "First Name",
                        name: "f_name",
                        hasError: $hasFNameError,
                        error: $hasFNameError ? $errors['f_name'] : "",
                        value: $body['f_name'] ?? null,
                        additionalAttributes: "pattern='^[\p{L} ]+$'"
                    );

                    ?>
                </div>
                <div class="form-input">
                    <?php
                    FormItem::render(
                        id: "l_name",
                        label: "Last Name",
                        name: "l_name",
                        hasError: $hasLNameError,
                        error: $hasLNameError ? $errors['l_name'] : "",
                        value: $body['l_name'] ?? null,
                        additionalAttributes: "pattern='^[\p{L} ]+$'"
                    );

                    ?>
                </div>

                <div class="form-input">
                    <?php
                    FormItem::render(
                        id: "fi",
                        label: "Full Name with initials",
                        name: "fi",
                        hasError: $hasFIError,
                        error: $hasFIError ? $errors['fi'] : "",
                        value: $body['fi'] ?? null,
                    );

                    ?>
                </div>
        
                <div class="line">
                    <div class="form-input-small">
                        <?php
                        FormItem::render(
                            id: "dob",
                            label: "Date of Birth",
                            name: "dob",
                            type: "date",
                            hasError: $hasDOBError,
                            error: $hasDOBError ? $errors['dob'] : "",
                            value: $body['dob'] ?? null,
                        );

                        ?>
                    </div>

        
                    <div class="form-input-small">
                        <?php
                        FormItem::render(
                            id: "nic",
                            label: "National Identity Card No",
                            name: "nic",
                            hasError: $hasNICError,
                            error: $hasNICError ? $errors['nic'] : "",
                            value: $body['nic'] ?? null,
                            additionalAttributes: "pattern='^(\d{9}[xXvV]|\d{12})$'"
                        );
                        ?>
                    </div>
                </div>

                <div class="form-input">
                    <?php
                    FormItem::render(
                        id: "address",
                        label: "Address",
                        name: "address",
                        hasError: $hasAddressError,
                        error: $hasAddressError ? $errors['address'] : "",
                        value: $body['address'] ?? null,
                    );
                    ?>
                </div>

                <div class="form-input">
                    <?php
                    FormItem::render(
                        id: "contact_no",
                        label: "Contact no",
                        name: "contact_no",
                        hasError: $hasContactNoError,
                        error: $hasContactNoError ? $errors['contact_no'] : "",
                        value: $body['contact_no'] ?? null,
                    );
                    ?>
                </div>

                <div class="form-input">
                    <?php
                    FormItem::render(
                        id: "email",
                        label: "Email Address",
                        name: "email",
                        type: "email",
                        hasError: $hasEmailError,
                        error: $hasEmailError ? $errors['email'] : "",
                        value: $body['email'] ?? null,
                    );
                    ?>
                </div>

                <div class="line">
                    <div class="form-input-small">
                        <?php
                        FormItem::render(
                            id: "password",
                            label: "Password",
                            name: "password",
                            type: "password",
                            hasError: $hasPasswordError,
                            error: $hasPasswordError ? $errors['password'] : "",
                            value: $body['password'] ?? null,
                        );
                        ?>
                    </div>

                    <div class="form-input-small">
                        <?php
                        FormItem::render(
                            id: "confirm_password",
                            label: "Confirm Password",
                            name: "confirm_password",
                            type: "password",
                            hasError: $hasConfirmPasswordError,
                            error: $hasConfirmPasswordError ? $errors['confirm_password'] : "",
                            value: $body['confirm_password'] ?? null,
                        );
                        ?>
                    </div>

                </div>
            </div>
            <div class="part2">
                <div class="form-input">
                    <b>Photo</b>
                    <input type="file" name="image">
                </div>
            </div>
        </div>
        <div class="flex items-center justify-between my-4">
            <button type="reset" id="rst" class="btn btn--danger">Reset</button>
            <button type="submit" id="sm" class="btn">Create Account</button>
        </div>
    </form>
</main>
