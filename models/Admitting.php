<?php

namespace app\models;

use app\core\Database;
use app\utils\FSUploader;
use app\utils\Util;
use Exception;
use PDOException;
use PDO;


class Admitting
{    
    private PDO $pdo;
    private array $body;

    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }

    public function getAdmittingReportById(int $report_no): bool|object
    {
        $stmt = $this->pdo->prepare("SELECT * FROM admittingreport WHERE report_no = :report_no");
        $stmt->execute([
            ":report_no" => $report_no,

        ]);
        return $stmt->fetchObject();
    }

    public function getAdmittingReports(
        int|null $count=null,
        int|null $page=1,
        string|null $searchTermRegNo=null,
        array $options = [
            'admitting_date' => null,
            'approve' => null,
        ]
    ): array|string
    {

        $whereClause = null;
        $conditions = [];
        $dateFrom = null;
        $dateTo = null;

        foreach ($options as $option_key => $option_value){
            if($option_value !== null){
                switch ($option_key){
                    case "admitting_date":
                        switch ($option_value) {
                            case 'all':
                                break;
                            case 'Today':
                                $dateFrom = date('Y-m-d', strtotime('today'));
                                $dateTo = date('Y-m-d', strtotime('today'));
                                break;
                            case 'Yesterday':
                                $dateFrom = date('Y-m-d', strtotime('yesterday'));
                                $dateTo = date('Y-m-d', strtotime('yesterday'));
                                break;
                            case 'Last 7':
                                $dateFrom = date('Y-m-d', strtotime('-6 days'));
                                $dateTo = date('Y-m-d', strtotime('today'));
                                break;
                            case 'Last 30':
                                $dateFrom = date('Y-m-d', strtotime('-29 days'));
                                $dateTo = date('Y-m-d', strtotime('today'));
                                break;
                            case 'Last 90 Days':
                                $dateFrom = date('Y-m-d', strtotime('-89 days'));
                                $dateTo = date('Y-m-d', strtotime('today'));
                                break;

                        }
                        break;
                    case "approve":
                        switch ($option_value) {
                            case 'all':
                                break;
                            case 'approved':
                                $conditions[] = "is_approved = TRUE";
                                break;
                            case 'not_approved':
                                $conditions[] = "is_approved = FALSE";
                                break;
                        }
                        break;
                }
            }
        }

        if (isset($dateFrom) && isset($dateTo)) {
            $conditions[] = "a.admitting_date BETWEEN :dateFrom AND :dateTo";
        }

        // var_dump($conditions);

        if (!empty($conditions)) {
            $whereClause = "WHERE " . implode(" AND ", $conditions);
        }

        if($searchTermRegNo !== null){
            $whereClause = $whereClause ? $whereClause . " AND a.vehicle_reg_no LIKE :search_term_reg_no" : " WHERE a.vehicle_reg_no LIKE :search_term_reg_no";
        }

        // var_dump($whereClause);
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";

        $quey = "SELECT 
            concat(c.f_name,' ',c.l_name) as Name,
            a.vehicle_reg_no as RegNo,
            a.admitting_date as Date,
            a.report_no as ID

            from admittingreport a
            left join vehicle v on a.vehicle_reg_no=v.reg_no
            left join customer c on v.customer_id=c.customer_id $whereClause $limitClause $pageClause ";

        $statement = $this->pdo->prepare($quey);

        if($searchTermRegNo !== null){
            $statement->bindValue(":search_term_reg_no", "%" . $searchTermRegNo . "%", PDO::PARAM_STR);
        }

        // var_dump(isset($dateTo));
        if(isset($dateTo) && isset($dateFrom)){
            $statement->bindValue(":dateFrom", $dateFrom);
            $statement->bindValue(":dateTo", $dateTo);
        }

        try{
            $statement->execute();
            $admittingReports = $statement->fetchAll(PDO::FETCH_ASSOC);
           
            $statement = $this->pdo->prepare(" SELECT 
                count(*) as total
                from admittingreport a
                left join vehicle v on a.vehicle_reg_no=v.reg_no
                left join customer c on v.customer_id=c.customer_id $whereClause"
            );

            if($searchTermRegNo !== null){
                $statement->bindValue(":search_term_reg_no", "%" . $searchTermRegNo . "%", PDO::PARAM_STR);
            }

            if(isset($dateTo) && isset($dateFrom)){
                $statement->bindValue(":dateFrom", $dateFrom);
                $statement->bindValue(":dateTo", $dateTo);
            }

            $statement->execute();
            $totalAdmittingReports = $statement->fetch(PDO::FETCH_ASSOC);

            return [
                'total' => $totalAdmittingReports['total'],
                "admittingReports" => $admittingReports
            ];
        }
        catch(PDOException $e){
            return $e->getMessage();
        }

    }

    public function validated_byAdmittingReport():array{
        $errors=[];

        if(trim($this->body["vehicle_reg_no"] === " ")){
            $errors['vehicle_reg_no'] = 'Registraion number must not be empty';
        }

        if ($this->body['lights_lf'] !== 'good' && $this->body['lights_lf'] !== 'scratched' && $this->body['lights_lf'] !== 'cracked' && $this->body['lights_lf'] !== 'damaged' && $this->body['lights_lf'] !== 'not working') {
            $errors['lights_lf'] = 'You must select the state of  LF lights.';
        }

        if ($this->body['lights_rf'] !== 'good' && $this->body['lights_rf'] !== 'scratched' && $this->body['lights_rf'] !== 'cracked' && $this->body['lights_rf'] !== 'damaged' && $this->body['lights_rf'] !== 'not working') {
            $errors['lights_rf'] = 'You must select the state of  RF lights.';
        }  
        
        if ($this->body['lights_lr'] !== 'good' && $this->body['lights_lr'] !== 'scratched' && $this->body['lights_lr'] !== 'cracked' && $this->body['lights_lr'] !== 'damaged' && $this->body['lights_lr'] !== 'not working') {
            $errors['lights_lr'] = 'You must select the state of  LR lights.';
        }         

        if ($this->body['lights_rr'] !== 'good' && $this->body['lights_rr'] !== 'scratched' && $this->body['lights_rr'] !== 'cracked' && $this->body['lights_rr'] !== 'damaged' && $this->body['lights_rr'] !== 'not working') {
            $errors['lights_rr'] = 'You must select the state of  RR lights.';
        }

        if ($this->body['seat_lf'] !== 'good' && $this->body['seat_lf'] !== 'worn' && $this->body['seat_lf'] !== 'burnholes' && $this->body['seat_lf'] !== 'torn' && $this->body['seat_lf'] !== 'stained') {
            $errors['seat_lf'] = 'You must select the state of  LF seat.';
        }

        if ($this->body['seat_rf'] !== 'good' && $this->body['seat_rf'] !== 'worn' && $this->body['seat_rf'] !== 'burnholes' && $this->body['seat_rf'] !== 'torn' && $this->body['seat_rf'] !== 'stained') {
            $errors['seat_rf'] = 'You must select the state of  RF seat.';
        }

        if ($this->body['seat_rear'] !== 'good' && $this->body['seat_rear'] !== 'worn' && $this->body['seat_rear'] !== 'burnholes' && $this->body['seat_rear'] !== 'torn' && $this->body['seat_rear'] !== 'stained') {
            $errors['seat_rear'] = 'You must select the state of  REAR seat.';
        }

        if ($this->body['carpet_lf'] !== 'good' && $this->body['carpet_lf'] !== 'worn' && $this->body['carpet_lf'] !== 'burnholes' && $this->body['carpet_lf'] !== 'torn' && $this->body['carpet_lf'] !== 'stained' && $this->body['carpet_lf'] !== 'missing') {
            $errors['carpet_lf'] = 'You must select the state of  LF carpet.';
        }

        if ($this->body['carpet_rf'] !== 'good' && $this->body['carpet_rf'] !== 'worn' && $this->body['carpet_rf'] !== 'burnholes' && $this->body['carpet_rf'] !== 'torn' && $this->body['carpet_rf'] !== 'stained' && $this->body['carpet_rf'] !== 'missing') {
            $errors['carpet_rf'] = 'You must select the state of  RF carpet.';
        }

        if ($this->body['carpet_rear'] !== 'good' && $this->body['carpet_rear'] !== 'worn' && $this->body['carpet_rear'] !== 'burnholes' && $this->body['carpet_rear'] !== 'torn' && $this->body['carpet_rear'] !== 'stained' && $this->body['carpet_rear'] !== 'missing') {
            $errors['carpet_rear'] = 'You must select the state of  REAR carpet.';
        }

        if (!isset($this->body['rim_lf']) ||($this->body['rim_lf'] !== 'good' && $this->body['rim_lf'] !== 'scratched'  && $this->body['rim_lf'] !== 'cracked' && $this->body['rim_lf'] !== 'damaged' && $this->body['rim_lf'] !== 'missing')) {
            $errors['rim_lf'] = 'You must select the state of  LF rim.';
        }

        if ($this->body['rim_rf'] !== 'good' && $this->body['rim_rf'] !== 'scratched'  && $this->body['rim_rf'] !== 'cracked' && $this->body['rim_rf'] !== 'damaged' && $this->body['rim_rf'] !== 'missing') {
            $errors['rim_rf'] = 'You must select the state of  RF rim.';
        }

        if ($this->body['rim_lr'] !== 'good' && $this->body['rim_lr'] !== 'scratched'  && $this->body['rim_lr'] !== 'cracked' && $this->body['rim_lr'] !== 'damaged' && $this->body['rim_lr'] !== 'missing') {
            $errors['rim_lr'] = 'You must select the state of  LR rim.';
        }

        if ($this->body['rim_rr'] !== 'good' && $this->body['rim_rr'] !== 'scratched'  && $this->body['rim_rr'] !== 'cracked' && $this->body['rim_rr'] !== 'damaged' && $this->body['rim_rr'] !== 'missing') {
            $errors['rim_rr'] = 'You must select the state of  RR rim.';
        }
        
        if ($this->body['current_fuel_level'] !== 'full' && $this->body['current_fuel_level'] !== 'empty' && $this->body['current_fuel_level'] !== 'half' && $this->body['current_fuel_level'] !== '3/4' && $this->body['current_fuel_level'] !== '1/4') {
            $errors['current_fuel_level'] = 'You must select the state of  capacity';
        }

        if (trim($this->body['mileage']) === "") {
            $errors['mileage'] = "Mileage must not be empty";
        } else if (!preg_match('/^[0-9]*[1-9][0-9]*$/', $this->body['mileage'])) {
            $errors['mileage'] = "Mileage must be a positive";
        }

        if (strlen($this->body['admitting_time']) == 0) {
            $errors['admitting_time'] = 'Admitting time must not be empty.';
        }

        // if (strlen($this->body['departing_time']) == 0) {
        //     $errors['departing_time'] = 'Department time must not be empty.';
        // }

        if (trim($this->body["customer_belongings"] === " ")) {
            $errors['customer_belongings'] = 'Customer belongings must not be empty.';
        }

        if (trim($this->body["additional_note"] === " ")) {
            $errors['additional_note'] = 'Additional note must not be empty.';
        }

        if ($this->body['dashboard'] !== 'good' && $this->body['dashboard'] !== 'scratched'  && $this->body['dashboard'] !== 'damaged' && $this->body['dashboard'] !== 'burnt' && $this->body['dashboard'] !== 'stained') {
            $errors['dashboard'] = 'You must select the state of  dashboard.';
        }

        if ($this->body['windshield'] !== 'good' && $this->body['windshield'] !== 'scratched' && $this->body['windshield'] !== 'cracked' && $this->body['windshield'] !== 'damaged') {
            $errors['windshield'] = 'You must select the state of  windsheild';
        }

        if ($this->body['toolkit'] !== 'have' && $this->body['toolkit'] !== 'missing') {
            $errors['toolkit'] = 'You must select the state of  toolkit';
        }

        if ($this->body['sparewheel'] !== 'have' && $this->body['sparewheel'] !== 'missing') {
            $errors['sparewheel'] = 'You must select the state of  sparewheel';
        }

        return $errors;
    }

 
    public function addAdmittingReport(int $id) : array | int{
        $errors = $this->validated_byAdmittingReport();
        if(empty($errors)){
            $query="insert into admittingreport 
                (
                    vehicle_reg_no, mileage, current_fuel_level, current_fuel_level_description, admitting_time, windshield, windshield_description, 
                    lights_lf, light_lf_description, lights_rf, light_rf_description, lights_lr, light_lr_description, lights_rr, light_rr_description, toolkit, sparewheel, rim_lf, rim_lf_description, 
                    rim_rf, rim_rf_description, rim_lr, rim_lr_description, rim_rr, rim_rr_description, seat_lf, seat_lf_description, seat_rf, seat_rf_description, seat_rear, seat_rear_description, 
                    carpet_lf, carpet_lf_description, carpet_rf, carpet_rf_description, carpet_rear, carpet_rear_description, dashboard, dashboard_description, customer_belongings, additional_note, employee_id, admitting_date
                )
                values
                (
                    :vehicle_reg_no, :mileage, :current_fuel_level,:current_fuel_level_description, :admitting_time, :windshield, :windshield_description, 
                    :lights_lf, :light_lf_description, :lights_rf, :light_rf_description, :lights_lr, :light_lr_description, :lights_rr, :light_rr_description, :toolkit, :sparewheel, :rim_lf, :rim_lf_description,
                    :rim_rf, :rim_rf_description, :rim_lr, :rim_lr_description, :rim_rr, :rim_rr_description, :seat_lf, :seat_lf_description, :seat_rf, :seat_rf_description, :seat_rear, :seat_rear_description,
                    :carpet_lf, :carpet_lf_description, :carpet_rf, :carpet_rf_description, :carpet_rear, :carpet_rear_description, :dashboard, :dashboard_description, :customer_belongings, :additional_note, :id, :date
                )";
            $statement=$this->pdo->prepare($query);
            $statement->bindvalue(":vehicle_reg_no", $this->body["vehicle_reg_no"]);
            $statement->bindvalue(":mileage", $this->body["mileage"]);
            $statement->bindvalue(":current_fuel_level", $this->body["current_fuel_level"]);
            $statement->bindvalue(":current_fuel_level_description", $this->body["current_fuel_level_description"]);
            $statement->bindvalue(":admitting_time", $this->body["admitting_time"]);
            // $statement->bindvalue(":departing_time", $this->body["departing_time"]);
            $statement->bindvalue(":windshield", $this->body["windshield"]);
            $statement->bindvalue(":windshield_description", $this->body["windshield_description"]);
            $statement->bindvalue(":lights_lf", $this->body["lights_lf"]);
            $statement->bindvalue(":light_lf_description", $this->body["light_lf_description"]);
            $statement->bindvalue(":lights_rf", $this->body["lights_rf"]);
            $statement->bindvalue(":light_rf_description", $this->body["light_rf_description"]);
            $statement->bindvalue(":lights_lr", $this->body["lights_lr"]);      
            $statement->bindvalue(":light_lr_description", $this->body["light_lr_description"]);
            $statement->bindvalue(":lights_rr", $this->body["lights_rr"]);
            $statement->bindvalue(":light_rr_description", $this->body["light_rr_description"]);
            $statement->bindvalue(":toolkit", $this->body["toolkit"]);
            $statement->bindvalue(":sparewheel", $this->body["sparewheel"]);
            $statement->bindvalue(":rim_lf", $this->body["rim_lf"]);
            $statement->bindvalue(":rim_lf_description", $this->body["rim_lf_description"]);
            $statement->bindvalue(":rim_rf", $this->body["rim_rf"]);
            $statement->bindvalue(":rim_rf_description", $this->body["rim_rf_description"]);
            $statement->bindvalue(":rim_lr", $this->body["rim_lr"]);
            $statement->bindvalue(":rim_lr_description", $this->body["rim_lr_description"]);
            $statement->bindvalue(":rim_rr", $this->body["rim_rr"]);
            $statement->bindvalue(":rim_rr_description", $this->body["rim_rr_description"]);
            $statement->bindvalue(":seat_lf", $this->body["seat_lf"]);
            $statement->bindvalue(":seat_lf_description", $this->body["seat_lf_description"]);
            $statement->bindvalue(":seat_rf", $this->body["seat_rf"]);
            $statement->bindvalue(":seat_rf_description", $this->body["seat_rf_description"]);
            $statement->bindvalue(":seat_rear", $this->body["seat_rear"]);
            $statement->bindvalue(":seat_rear_description", $this->body["seat_rear_description"]);
            $statement->bindvalue(":carpet_lf", $this->body["carpet_lf"]);
            $statement->bindvalue(":carpet_lf_description", $this->body["carpet_lf_description"]);
            $statement->bindvalue(":carpet_rf", $this->body["carpet_rf"]);  
            $statement->bindvalue(":carpet_rf_description", $this->body["carpet_rf_description"]);
            $statement->bindvalue(":carpet_rear", $this->body["carpet_rear"]);
            $statement->bindvalue(":carpet_rear_description", $this->body["carpet_rear_description"]);
            $statement->bindvalue(":dashboard", $this->body["dashboard"]);
            $statement->bindvalue(":dashboard_description", $this->body["dashboard_description"]);
            $statement->bindvalue(":customer_belongings", $this->body["customer_belongings"]);
            $statement->bindvalue(":additional_note", $this->body["additional_note"]);
            $statement->bindvalue(":id", $id);
            $statement->bindvalue(":date", date('Y-m-d'));
            $statement->execute();
            return $this->pdo->lastInsertId();
        }
        else{
            return $errors;
        }
    }

    public function approveReport(int $id){
        //get current date and time and save it in $departing_time
        $departing_time = date('H:i:s');

        //update query
        $query = "UPDATE admittingreport SET departing_time = :departing_time WHERE report_no = :id";
            $statement=$this->pdo->prepare($query);
            $statement->bindvalue(":departing_time", date('H:i:s'));
            $statement->bindvalue(":id", $id);
        
        try{           
            $statement->execute();
            return $statement->rowCount() > 0;
        }
        catch (PDOException $e){
            var_dump($e->getMessage());
            return "Error deleting Employee";
        }
    }
}
?>