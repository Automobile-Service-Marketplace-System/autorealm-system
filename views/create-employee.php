<!--<style>-->
<!--    .type {-->
<!--        height: 0.6cm;-->
<!--        width: 3.7cm;-->
<!--        background-color: white;-->
<!--        border-radius: .1cm;-->
<!--        display: inline-block;-->
<!--        accent-color: blue;-->
<!--        text-align-all: center;-->
<!--        margin-right: 3.0cm;-->
<!---->
<!--    }-->
<!---->
<!--    .lbl{-->
<!--        width: 25cm;-->
<!--        height: 0.6cm;-->
<!--        border-radius: .1cm;-->
<!--        background-color: white;-->
<!--    }-->
<!---->
<!--    .lbl2{-->
<!--        width: 10.5cm;-->
<!--        height: 0.6cm;-->
<!--        border-radius: .1cm;-->
<!--        background-color: white;-->
<!--    }-->
<!---->
<!--    .line{-->
<!--        display: inline-block;-->
<!--        margin-right: 3.7cm;-->
<!--    }-->
<!---->
<!--    img{-->
<!--        float:right;-->
<!--        width:100px;-->
<!--        height: 300px;-->
<!--        margin-right: 2cm;-->
<!--    }-->
<!---->
<!--    #rst{-->
<!--        width: 2cm;-->
<!--        height: 0.8cm;-->
<!--        color: white;-->
<!--        background-color: red;-->
<!--        border-radius: .2cm;-->
<!--        border-color: red;-->
<!--    }-->
<!---->
<!--    #sm{-->
<!--        float: right;-->
<!--        width: 5.5cm;-->
<!--        height: 0.8cm;-->
<!--        text-align: center;-->
<!--        color: white;-->
<!--        background-color: blue;-->
<!--        border-radius: .2cm;-->
<!--        border-color: blue;-->
<!--        margin-right: 2.8cm;-->
<!---->
<!--    }-->
<!---->
<!--    body{-->
<!--        var -->
<!--        background-color: ;-->
<!--        margin-left: 2cm;-->
<!--        margin-right: 2cm;-->
<!---->
<!--    }-->
<!---->
<!--    .pic{-->
<!--        float: right;-->
<!---->
<!--    }-->
<!--</style>-->

<main class="admin-dashboard__content">
    <h2>Add a new staff account, these accounts will allow your employees to access their respective dashboards</h2>
    <form action="/employee-register" method="post">
        <h3>Choose the account type</h3>
        <div class="role-input">
            <div class="role-input__item">
                <input type="radio" id="job-role-1" name="job_role1" value="Security Officer">
                <label>Security Officer</label>
            </div>
            <div class="role-input__item">
                <input type="radio" id="radio2" name="job_role2">
                <label>Office Staff</label>
            </div>
            <div class="role-input__item">
                <input type="radio" id="radio3" name="job_role3">
                <label>Foreman</label>
            </div>
            <div class="role-input__item">
                <input type="radio" id="radio4" name="job_role4">
                <label>Technician</label>
            </div>
            <div class="role-input__item">
                <input type="radio" id="radio5" name="job_role5">
                <label>Stock Manager</label>

            </div>
        </div>

        <label><b>Full Name</b></label>
        <img src="/images/Add-employee.png" class="pic">

        <br><input type="text" id="f_name" name=f_name class="lbl"><br><br>


        <label><b>Full Name with Initials</b></label><br>
        <input type="text" id="fi" name=fi class="lbl"><br><br>

        <div class="form-item">
            <label><b>Date of Birth</b></label><br>
            <input type="date" id="dob" name="dob" class="lbl2"><br><br>
        </div>
        <div class="form-item">
            <label><b>National Identity Card No</b></label><br>
            <input type="text" id="nic" name="nic" class="lbl2"><br><br>
        </div><br><br>

        <label><b>Address</b></label><br>
        <input type="text" id="add" name=add class="lbl"><br><br>

        <label><b>Contact numbers (Primary first, then any other seperated with commas)</b></label><br>
        <input type="text" id="con_no" name='con_no' class="lbl"><br><br>

        <div class="form-item">
            <label><b>Password</b></label><br>
            <input type="password" id="pw" name="pw" class="lbl2"><br><br>
        </div>
        <div class="form-item">
            <label><b>Confirm Password</b></label><br>
            <input type="password" id="cpw" name="cpw" class="lbl2"><br><br>
        </div>

        <br><br><button type="reset" id="rst" class="btn btn--danger">Reset</button>
        <button type="submit" id="sm" class="btn">Create Account</button>
    </form>
</main>