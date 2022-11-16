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

<form action="/employee-register" method="post" >
    <lable><br><b>Choose the account type</b></lable><br><br>
    <div >
        <input type="radio" id="radio1" name="job_role1" value="Security Officer">
        <lable>Security Officer</lable>
    </div>
    <div>
        <input type="radio" id="radio2" name="job_role2">
        <lable>Office Staff</lable>
    </div>
    <div>
        <input type="radio" id="radio3" name="job_role3">
        <lable>Foreman</lable>
    </div>
    <div>
        <input type="radio" id="radio4" name="job_role4">
        <lable>Technician</lable>
    </div>
    <div>
        <input type="radio" id="radio5" name="job_role5" >
        <lable>Stock Manager</lable>
    </div><br><br><br>

    <lable><b>Full Name</b></lable>
    <img src="/images/Add-employee.png" class="pic">

    <br><input type="text" id="f_name" name=f_name class="lbl" ><br><br>


    <lable><b>Full Name with Initials</b></lable><br>
    <input type="text" id="fi" name=fi class="lbl" ><br><br>

    <div class="form-item">
        <lable><b>Date of Birth</b></lable><br>
        <input type="date" id="dob" name="dob" class="lbl2" ><br><br>
    </div>
    <div class="form-item">
        <lable><b>National Identity Card No</b></lable><br>
        <input type="text" id="nic" name="nic" class="lbl2" ><br><br>
    </div><br><br>

    <lable><b>Address</b></lable><br>
    <input type="text" id="add" name=add class="lbl" ><br><br>

    <lable><b>Contact numbers (Primary first, then any other seperated with commas)</b></lable><br>
    <input type="text" id="con_no" name='con_no' class="lbl" ><br><br>

    <div class="form-item">
        <lable><b>Password</b></lable><br>
        <input type="password" id="pw" name="pw" class="lbl2" ><br><br>
    </div>
    <div class="form-item">
        <lable><b>Confirm Password</b></lable><br>
        <input type="password" id="cpw" name="cpw" class="lbl2" ><br><br>
    </div>

    <br><br><button type="reset" id="rst" class="btn btn--danger">Reset</button>
    <button type="submit" id="sm" class="btn">Create Account</button>
</form>
