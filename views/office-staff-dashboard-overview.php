<div class=office-overview-page>
        
    </div><div class="office-overview-wrapper">
        <div class="office-overview-card">
            <span>Total Customers</span><br> 
            <p><?= $customerCount ?></p>
        </div>

        <div class="office-overview-card">
            <span>Todays appointment</span><br> 
            <p><?= $appointmentCount ?></p>
        </div>

        <div class="office-overview-card">
            <span>Ongoing jobs</span><br> 
            <p><?= $ongoingJobsCount ?></p>
        </div>
    </div>

    <div class="office-overview-foremen-details">
        <div class="office-overview-foremen">
            <p>Foremen availability</p>
        <?php 
            foreach ($foremenDetails as $foremenDetail) {
                if ($foremenDetail["Availability"] == 1) {
                  echo "<span>" . $foremenDetail["Name"] . "</span><span style='color:green'> Available</span><br><br>";
                } else {
                  echo "<span>" . $foremenDetail["Name"] . "</span><span style='color:red'> Busy</span><br><br>";
                }
              }
              
        ?>              
            
        </div>

        <div class="office-overview-foremen-analytics">
            <h3>Weekly job details</h3>
            <p>New - <?= isset($weeklyJobStatus['new']) ? $weeklyJobStatus['new'] : 0 ?></p> <br>
            <p>In-progress - <?= isset($weeklyJobStatus['in-progress']) ? $weeklyJobStatus['in-progress'] : 0 ?></p> <br>
            <p>Completed - <?= isset($weeklyJobStatus['completed']) ? $weeklyJobStatus['completed'] : 0 ?></p> <br>
            <p>Finished - <?= isset($weeklyJobStatus['finished']) ? $weeklyJobStatus['finished'] : 0 ?></p> <br>
        </div>
    </div>

</div>



