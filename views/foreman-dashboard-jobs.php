<?php


/**
 * @var  array $jobs
 */

use app\components\CompletedJobCard;
use app\components\InProgressJobCard;
use app\components\NewJobCard;

//class Job
//{
//    public int $id;
//    public string $regNo;
//    public int $serviceCount;
//    public int $productCount;
//    public int $technicianCount;
//    public int $done;
//    public int $all;
//
//    public function __construct(int $id, string $regNo, int $serviceCount, int $productCount, int $technicianCount, int $done, int $all)
//    {
//        $this->id = $id;
//        $this->regNo = $regNo;
//        $this->serviceCount = $serviceCount;
//        $this->productCount = $productCount;
//        $this->technicianCount = $technicianCount;
//        $this->done = $done;
//        $this->all = $all;
//    }
//}
//
//$inProgressJobs = [];
//$inProgressJobs[] = new Job(id: 1, regNo: 'QL 9904', serviceCount: 2, productCount: 3, technicianCount: 1, done: 7, all: 8);
//$inProgressJobs[] = new Job(id: 2, regNo: 'AK 2954', serviceCount: 3, productCount: 7, technicianCount: 1, done: 5, all: 8);
//$inProgressJobs[] = new Job(id: 3, regNo: 'WE 3444', serviceCount: 4, productCount: 2, technicianCount: 1, done: 2, all: 9);
//$inProgressJobs[] = new Job(id: 4, regNo: 'PI 2564', serviceCount: 2, productCount: 1, technicianCount: 1, done: 9, all: 10);
//$inProgressJobs[] = new Job(id: 5, regNo: 'QK 9994', serviceCount: 5, productCount: 5, technicianCount: 1, done: 3, all: 11);
//$inProgressJobs[] = new Job(id: 6, regNo: 'IL 9884', serviceCount: 7, productCount: 2, technicianCount: 1, done: 0, all: 4);
//$inProgressJobs[] = new Job(id: 7, regNo: 'FV 8884', serviceCount: 4, productCount: 4, technicianCount: 1, done: 3, all: 4);
//$inProgressJobs[] = new Job(id: 8, regNo: 'AS 7774', serviceCount: 6, productCount: 6, technicianCount: 1, done: 10, all: 12);
//
//$newJobs = [];
//$newJobs[] = new Job(id: 9, regNo: 'QW 6664', serviceCount: 0, productCount: 0, technicianCount: 0, done: 0, all: 0);
//$newJobs[] = new Job(id: 10, regNo: 'ER 5554', serviceCount: 0, productCount: 0, technicianCount: 0, done: 0, all: 0);
//$newJobs[] = new Job(id: 11, regNo: 'TY 4444', serviceCount: 0, productCount: 0, technicianCount: 0, done: 0, all: 0);
//$newJobs[] = new Job(id: 12, regNo: 'UI 3334', serviceCount: 0, productCount: 0, technicianCount: 0, done: 0, all: 0);
//$newJobs[] = new Job(id: 13, regNo: 'OP 2224', serviceCount: 0, productCount: 0, technicianCount: 0, done: 0, all: 0);
//$newJobs[] = new Job(id: 14, regNo: 'AS 1114', serviceCount: 0, productCount: 0, technicianCount: 0, done: 0, all: 0);
//
//$completedJobs = [];
//$completedJobs[] = new Job(id: 15, regNo: 'QW 0004', serviceCount: 4, productCount: 3, technicianCount: 7, done: 9, all: 9);
//$completedJobs[] = new Job(id: 16, regNo: 'ER 9994', serviceCount: 3, productCount: 2, technicianCount: 6, done: 8, all: 8);
//$completedJobs[] = new Job(id: 17, regNo: 'TY 8884', serviceCount: 2, productCount: 1, technicianCount: 5, done: 7, all: 7);
//$completedJobs[] = new Job(id: 18, regNo: 'UI 7774', serviceCount: 1, productCount: 0, technicianCount: 4, done: 6, all: 6);
//$completedJobs[] = new Job(id: 19, regNo: 'OP 6664', serviceCount: 0, productCount: 0, technicianCount: 3, done: 5, all: 5);
//$completedJobs[] = new Job(id: 20, regNo: 'AS 5554', serviceCount: 0, productCount: 0, technicianCount: 2, done: 4, all: 4);
//

?>

<main class="jobs-grid">
    <section class="jobs-col">
        <h2 class="jobs-col__heading">
            <span class="job-status-indicator job-status-indicator--todo">

            </span>
            New Jobs
            <span><?php echo count($jobs['new']) ?></span>
        </h2>
        <?php
        foreach ($jobs['new'] as $job) {
            NewJobCard::render($job);
        }
        ?>

    </section>
    <section class="jobs-col">
        <h2 class="jobs-col__heading">
            <span class="job-status-indicator job-status-indicator--in-progress">

            </span>
            In Progress
            <span><?php echo count($jobs['in-progress']) ?></span>
        </h2>
        <?php
        foreach ($jobs['in-progress'] as $job) {
            InProgressJobCard::render($job);
        }
        ?>
    </section>
    <section class="jobs-col">
        <h2 class="jobs-col__heading">
            <span class="job-status-indicator job-status-indicator--completed">

            </span>
            Completed
            <span><?php echo count($jobs['completed']) ?></span>
        </h2>
        <?php
        foreach ($jobs['completed'] as $job) {
            CompletedJobCard::render($job);
        }
        ?>
    </section>
</main>