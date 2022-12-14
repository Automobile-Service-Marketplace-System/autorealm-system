<!-- <style>
    p{
        font-size: 18px;
        margin-bottom: 2rem; 
    }

    label{
        font-size: 16px;
        /* /margin-bottom: 1rem;   */
    }

    .role-input{
        display: flex;
        justify-content: space-between;
        margin-bottom: .25rem;  
    }

    .role-input-item{
        margin-top:0.75rem;
        background-color: #FFFFFF;
        border-radius: 8px; 
        text-align:left;
        padding: 0.25rem;
        width: 4cm;
        margin-bottom:1rem;
    }

    input{
        border: 0.5px solid #1d1d1d;
        border-radius: 8px;
    }

    body{
        background: #F8F8F8;
        margin-right: 5cm;
        /* margin-left: 10cm; */
    }

    .form-input{
        display: flex;
        flex-direction: column;
        gap: .25rem;
        margin-top: .5rem;
    }

    .form-input>input{
        width: 645px;
        height: 40px;
        padding-left: .5cm;
    }

    .form-input-small>input{
        width: 309px;
        height: 40px;
        padding-left: .5cm;
    }

    .line{
        display: flex;
        gap: .7cm;
    }

    .form-input-small{
        display: flex;
        flex-direction: column; 
        gap: .25rem;
        margin-top: .5rem; 
    }

    .btn1{
        margin-top: 1cm;
        background-color: #E53030;
        color: #FFFFFF;
        border-color: #E53030;
        Width: 139px;
        Height:50px;
        border-radius:8px;
    }

    .btn2{
        margin-top: 1cm;
        width: 390px;
        height: 50px;
        border-radius: 0%;
        background: #6100FF;
        border-color: #6100FF;
        border-radius: 8px;
        color: #FFFFFF;
        float: right;
    }

    .part{
        display: flex;
        justify-content: space-between;
    }

    .pic{
        width: auto;
        height:500px;
    }

</style> -->

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
$hasADDRESSError = $hasErrors && isset($errors['address']);
$hasCONNOError = $hasErrors && isset($errors['con_no']);
$hasEmailError = $hasErrors && isset($errors['email']);
$hasPasswordError = $hasErrors && isset($errors['password']);
$hasCPWError = $hasErrors && isset($errors['cpw']);
$hasImageError = $hasErrors && isset($errors['image']);
?>


<main class="create-employee">
    <form action="/admin-dashboard/employees/add" method="post" enctype="multipart/form-data">
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
<!--                    <label class="label"><b>First Name</b></label>-->
<!--                    <input type="text" id="f_name" name=f_name class="lbl">-->
                    <?php
                    FormItem::render(
                        id: "f_name",
                        label: "First Name",
                        name: "f_name",
                        hasError: $hasFNameError,
                        error: $hasFNameError ? $errors['f_name'] : "",
                        value: $body['f_name'] ?? null,
//                        additionalAttributes: "pattern='^[\p{L} ]+$'"
                    );

                    ?>
                </div>
                <div class="form-input">
<!--                    <label class="label"><b>Last Name</b></label>-->
<!--                    <input type="text" id="l_name" name=l_name class="lbl">-->
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
<!--                    <label class="label"><b>Full Name with Initials</b></label>-->
<!--                    <input type="text" id="fi" name=fi class="lbl">-->
                    <?php
                    FormItem::render(
                        id: "fi",
                        label: "Full Name with initials",
                        name: "fi",
                        hasError: $hasFIError,
                        error: $hasFIError ? $errors['fi'] : "",
                        value: $body['fi'] ?? null,
                        additionalAttributes: "pattern='^[\p{L} ]+$'"
                    );

                    ?>
                </div>
        
                <div class="line">
                    <div class="form-input-small">
<!--                        <label class="label"><b>Date of Birth</b></label>-->
<!--                        <input type="date" id="dob" name="dob" class="lbl2">-->
                        <?php
                        FormItem::render(
                            id: "dob",
                            label: "Date of Birth",
                            name: "dob",
                            hasError: $hasDOBError,
                            error: $hasDOBError ? $errors['dob'] : "",
                            value: $body['dob'] ?? null,
                        );

                        ?>
                    </div>

        
                    <div class="form-input-small">
<!--                        <label class="label"><b>National Identity Card No</b></label>-->
<!--                        <input type="text" id="nic" name="nic" class="lbl2">-->
                        <?php
                        FormItem::render(
                            id: "nic",
                            label: "National Identity Card No",
                            name: "nic",
                            hasError: $hasNICError,
                            error: $hasNICError ? $errors['nic'] : "",
                            value: $body['nic'] ?? null,
                        );
                        ?>
                    </div>
                </div>

                <div class="form-input">
<!--                    <label class="label"><b>Address</b></label>-->
<!--                    <input type="text" id="address" name='address' class="lbl">-->
                    <?php
                    FormItem::render(
                        id: "address",
                        label: "Address",
                        name: "address",
                        hasError: $hasADDRESSError,
                        error: $hasADDRESSError ? $errors['address'] : "",
                        value: $body['address'] ?? null,
//                        additionalAttributes: "pattern='^[\p{L} ]+$'"
                    );
                    ?>
                </div>

                <div class="form-input">
<!--                    <label class="label"><b>Contact numbers (Primary first, then any other seperated with commas)</b></label>-->
<!--                    <input type="text" id="con_no" name='con_no' class="lbl">-->
                    <?php
                    FormItem::render(
                        id: "con_no",
                        label: "Contact numbers (Primary first, then any other seperated with commas",
                        name: "con_no",
                        hasError: $hasCONNOError,
                        error: $hasCONNOError ? $errors['con_no'] : "",
                        value: $body['con_no'] ?? null,
                    );
                    ?>
                </div>

                <div class="form-input">
<!--                    <label class="label"><b>Email Address</b></label>-->
<!--                    <input type="email" id="email" name="email">-->
                    <?php
                    FormItem::render(
                        id: "email",
                        label: "Email Address",
                        name: "email",
                        hasError: $hasEmailError,
                        error: $hasEmailError ? $errors['email'] : "",
                        value: $body['email'] ?? null,
//                        additionalAttributes: "pattern='^[\p{L} ]+$'"
                    );
                    ?>
                </div>

                <div class="line">
                    <div class="form-input-small">
<!--                        <label class="label"><b>Password</b></label>-->
<!--                        <input type="password" id="pw" name="pw" class="lbl2">-->
                        <?php
                        FormItem::render(
                            id: "password",
                            label: "Password",
                            name: "password",
                            hasError: $hasPasswordError,
                            error: $hasPasswordError ? $errors['password'] : "",
                            value: $body['password'] ?? null,
                        );
                        ?>
                    </div>

                    <div class="form-input-small">
<!--                        <label ><b>Confirm Password</b></label>-->
<!--                        <input type="password" id="cpw" name="cpw" class="lbl2" >-->
                        <?php
                        FormItem::render(
                            id: "cpw",
                            label: "Confirm Password",
                            name: "cpw",
                            hasError: $hasCPWError,
                            error: $hasCPWError ? $errors['cpw'] : "",
                            value: $body['cpw'] ?? null,
                        );
                        ?>
                    </div>

                </div>
                <button type="reset" id="rst" class="btn1">Reset</button>
            </div>
            <div class="part2">
                <div class="form-input">
                    <b>Photo</b>
                    <input type="file" name="image">
                </div>
                <button type="submit" id="sm" class="btn2">Create Account</button>
            </div>
        </div>
    </form>
</main>