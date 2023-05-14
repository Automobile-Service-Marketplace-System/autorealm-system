<?php
use app\utils\DevOnly;
/**
 * @var array $foremanJobs
 * @var array $customerCount
 * @var array $orderStatus
 */
// DevOnly::prettyEcho($orderStatus)

?>

<!-- <div class='overview'>
    <div class='jobcard-orderstatus'>
        <div class='overview-card-wrapper'>
            <div class='admin-overview__container__title'>
                Jobs Card in this month
                <div class='admin-overview__container'>
                    <?php
                        // foreach ($foremanJobs as $job) {
                        //     if($job['status'] !== 'completed'){
                        //         $status = $job['status'];
                        //         $count = $job['count'];
                        //         echo "<br>$status: $count";
                        //     }
                        // }
                    ?>
                </div>
            </div>
        </div>

        <div class="analytic-revenue-details">
            <div class="revenue-chart">
                <canvas id="orderstatus-revenue-canvas"></canvas>
            </div>
        </div>
    </div>

    <div class='employee-chart overview-card-wrapper'>
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
</div> -->

<div class='overview'>
    <div class='jobcard-orderstatus'>
        <div class='overview-card-wrapper'>
            <div class='admin-overview__container__title'>
                Jobs Card in this month
                <div class='admin-overview__container'>
                    <?php
                        foreach ($foremanJobs as $job) {
                            if($job['status'] !== 'completed'){
                                $status = $job['status'];
                                $count = $job['count'];
                                if($status == 'new'){
                                    echo "<br>New: $count";
                                }
                                elseif($job['status']=='in-progress'){
                                    echo "<br>In Progress: $count";
                                }
                                else{
                                    echo "<br>Finished: $count";
                                }
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="admin-overview__container__title overview-card-wrapper">    
        <h2>Order Status</h2>
            <div class="analytic-revenue-details">
                <div class="revenue-chart">
                    <canvas id="orderstatus-revenue-canvas"></canvas>
                </div>
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