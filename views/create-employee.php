<style>
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

</style>

<main class="create-employee">
    <p>Add a new staff account, these accounts will allow your employees to<br> access their respective dashboards</p>
    <form action="/employee-register" method="post">
        <b>Choose the account type</b>
        <div class="role-input">
            <div class="role-input-item">
                <input type="radio" id="job-role-1" name="job_role1" value="Security Officer">
                <label>Security Officer</label>
            </div>
            <div class="role-input-item">
                <input type="radio" id="radio2" name="job_role2">
                <label>Office Staff</label>
            </div>
            <div class="role-input-item">
                <input type="radio" id="radio3" name="job_role3">
                <label>Foreman</label>
            </div>
            <div class="role-input-item">
                <input type="radio" id="radio4" name="job_role4">
                <label>Technician</label>
            </div>
            <div class="role-input-item">
                <input type="radio" id="radio5" name="job_role5">
                <label>Stock Manager</label>

            </div>
        </div>

        <div class="part">
            <div class="part1">
                <div class="form-input">
                    <label><b>Full Name</b></label>
                    <input type="text" id="f_name" name=f_name class="lbl">
                </div>
        
                <div class="form-input">
                    <label><b>Full Name with Initials</b></label>
                    <input type="text" id="fi" name=fi class="lbl">
                </div>
        
                <div class="line">
                    <div class="form-input-small">
                        <label><b>Date of Birth</b></label>
                        <input type="date" id="dob" name="dob" class="lbl2">
                    </div>
        
                    <div class="form-input-small">
                        <label><b>National Identity Card No</b></label>
                        <input type="text" id="nic" name="nic" class="lbl2">
                    </div>
                </div>
        
                <div class="form-input">
                    <label><b>Address</b></label>
                    <input type="text" id="add" name=add class="lbl">
                </div>
        
                <div class="form-input">
                    <label><b>Contact numbers (Primary first, then any other seperated with commas)</b></label>
                    <input type="text" id="con_no" name='con_no' class="lbl">
                </div>
        
                <div class="form-input">
                    <label><b>Email Address</b></label>
                    <input type="email" >
                </div>
                <div class="line">
                    <div class="form-input-small">
                        <label><b>Password</b></label>
                        <input type="password" id="pw" name="pw" class="lbl2">
                    </div>
            
                    <div class="form-input-small">
                        <label><b>Confirm Password</b></label>
                        <input type="password" id="cpw" name="cpw" class="lbl2">
                    </div>
                </div>
                <button type="reset" id="rst" class="btn1">Reset</button>
            </div>
            <div class="part2">
                <div class="form-input">
                    <b>Photo</b>
                    <img src="/images/Add-employee.png" class="pic">
                </div>
                <button type="submit" id="sm" class="btn2">Create Account</button>
            </div>
        </div>
    </form>
</main>