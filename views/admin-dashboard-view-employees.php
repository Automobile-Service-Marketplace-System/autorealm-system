<style>
    .employee{
        background-color: var(--color-white);
        box-shadow: 1px 2px 5px rgba(0, 0, 0, 0.2); 
        padding: 1rem;
        border-radius: 0.5rem;
        width: 75%;
        max-width: 450px;
        gap:0.5cm;
        display: flex;
        margin:1cm;
    }
    .grid{
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;     
    }

    .line{
        display: flex;
        flex-direction: column;
    }

    .dot1{
        height: 12px;
        width: 12px;
        background-color: aqua;
        border-radius: 50%;
        display: inline-block;
    }

    .dot2{
        height: 12px;
        width: 12px;
        border-radius: 50%;
        display: inline-block;
        background-color:darkorange;
    }

    .line2{
        align-items: center;
        border-radius: 100px;
        padding-left:1.3cm;
    }

    .job_role{
        background-color:darkgray;
        border-radius: 8px; 
        text-align:center;
        padding: 0.25rem;
        width: 4cm;
    }

    .line3{
        padding-left:1cm;
        text-align:center;       
    }

</style>

<?php


/**
 * @var array $employees
 */

?>

<div class="admin-add-button-set">
    <div class="add-button">
        <a class="btn" href="/employees/add">
            <i class="fa-solid fa-plus"></i>
            Add Employee</a>
    </div>
</div>

<div class="grid">
    <?php
        foreach($employees as $employee){ ?>
            <div class="employee">
                <div class="line">
                    <div class="line1">
                        <?php if($employee["isActive"]===1){ ?>
                            <span class="dot1"></span>
                            <b> Available</b>
                        <?php } 
                        else{ ?>
                            <span class="dot2"></span>
                            <b> Busy</b>
                        <?php } ?>
                    </div>
                    <div class="line2">
                        <?php echo "<img src='{$employee['Image']}' style='width:128px;height:128px;border-radius: 100px;'>"; ?>
                    </div>
                    <div class="line3">
                        <b><?php echo $employee["Name"]?></b>
                        <div class="job_role">
                            <?php 
                                if($employee["JobType"]==="stock_manager"){?>
                                    Stock Manager
                                <?php }
                                else if($employee["JobType"]==="office_staff_member"){?>
                                    Office Staff
                                <?php }
                                else if($employee["JobType"]==="security_officer"){?>
                                    Security Officer
                                <?php }
                                else if($employee["JobType"]==="technician"){?>
                                    Technician
                                <?php }
                                else if($employee["JobType"]==="foreman"){?>
                                    Security Officer
                                <?php }
                                else if($employee["JobType"]==="admin"){?>
                                    Admin
                                <?php } 
                            ?>
                        </div>
                        <div class="line4">
                            <?php echo $employee["Contact No"]?>
                        </div>
                        <div class="line5">
                            <p style="color:blue;"><?php echo $employee["Email"]?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
</div>