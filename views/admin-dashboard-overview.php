<?php
use app\utils\DevOnly;
/**
 * @var array $foremanJobs
 * @var array $customerCount
 */
// DevOnly::prettyEcho($foremanJobs)

?>

<div class='overview'>
    <!-- <div class='overview-card-wrapper'>
        <div class='admin-overview__container__title'>
            Total Customer of the Current Month
        </div>
        
    </div> -->
    <div class='chart-item-grid'>
        <div class='overview-card-wrapper'>
            <div class='admin-overview__container__title'>
                Jobs Card in this month
                <div class='admin-overview__container'>
                    <?php
                        foreach ($foremanJobs as $job) {
                            if($job['status'] !== 'completed'){
                                $status = $job['status'];
                                $count = $job['count'];
                                echo "<br>$status: $count";
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="admin-overview__container__title overview-card-wrapper">    
            <h2>Employee Count</h2>
            <div class="analytic-revenue-details">
                <div class="revenue-chart">
                    <canvas id="employee-count-canvas"></canvas>
                    <?php
                        // echo "<div id='totalCountContainer'></div>"; 
                    ?> 
                </div>
            </div>
        </div>
    </div>
</div>