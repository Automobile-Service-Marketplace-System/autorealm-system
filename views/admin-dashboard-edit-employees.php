<?php

/**
 *  @var object $employee
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
$hasImageError = $hasErrors && isset($errors['image']);

?>

<main class="update-employee">
    <form action="/employees/edit" method="post" enctype="multipart/form-data">
        <p>Update the account of <?php echo $employee->f_name ?></p><br>
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
                    // var_dump($employee);
                    FormItem::render(
                        id: "f_name",
                        label: "First Name",
                        name: "f_name",
                        hasError: $hasFNameError,
                        error: $hasFNameError ? $errors['f_name'] : "",
                        value: $employee->f_name ?? ($body['f_name'] ?? null) ,
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
                        value: $employee->l_name ?? ($body['l_name'] ?? null) ,
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
                        value: $employee->fi ?? ($body['fi'] ?? null) ,
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
                            value: $employee->dob ?? ($body['dob'] ?? null) ,
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
                            value: $employee->NIC ?? ($body['NIC'] ?? null) ,
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
                        value: $employee->address ?? ($body['address'] ?? null) ,
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
                        value: $employee->contact_no ?? ($body['contact_no'] ?? null) ,
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
                        value: $employee->email ?? ($body['email'] ?? null) ,
                    );
                    ?>
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
            <button type="submit" class="btn">Cansel</button>
            <button type="reset" class="btn btn--warning">Update</button>
        </div>
    </form>
</main>