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

    public function getAdmittingReports(): array
    {

        return $this->pdo->query("
            SELECT 
            concat(c.f_name,' ',c.l_name) as Name,
            a.vehicle_reg_no as RegNo,
            a.admitting_date as Date
            from admitingreport a
            inner join vehicle v on a.vehicle_reg_no=v.reg_no
            inner join customer c on v.customer_id=c.customer_id")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validated_byAdmittingReport():array{
        $errors=[];

        if (strlen($this->body['vehicle_reg_no']) == 0) {
            $errors['vehicle_reg_no'] = 'Registration No must not be empty.';
        }

        if ($this->body['lights_lf'] !== 'good' && $this->body['lights_lf'] !== 'scratched' && $this->body['lights_lf'] !== 'cracked' && $this->body['lights_lf'] !== 'damaged' && $this->body['lights_lf'] !== 'not working') {
            $errors['lights_lf'] = 'You must select LF of lights.';
        }

        if ($this->body['lights_rf'] !== 'good' && $this->body['lights_rf'] !== 'scratched' && $this->body['lights_rf'] !== 'cracked' && $this->body['lights_rf'] !== 'damaged' && $this->body['lights_rf'] !== 'not working') {
            $errors['lights_rf'] = 'You must select RF of lights.';
        }  
        
        if ($this->body['lights_lr'] !== 'good' && $this->body['lights_lr'] !== 'scratched' && $this->body['lights_lr'] !== 'cracked' && $this->body['lights_lr'] !== 'damaged' && $this->body['lights_lr'] !== 'not working') {
            $errors['lights_lr'] = 'You must select LR of lights.';
        }         

        if ($this->body['lights_rr'] !== 'good' && $this->body['lights_rr'] !== 'scratched' && $this->body['lights_rr'] !== 'cracked' && $this->body['lights_rr'] !== 'damaged' && $this->body['lights_rr'] !== 'not working') {
            $errors['lights_rr'] = 'You must select RR of lights.';
        }

        if ($this->body['seat_lf'] !== 'good' && $this->body['seat_lf'] !== 'worn' && $this->body['seat_lf'] !== 'burnholes' && $this->body['seat_lf'] !== 'torn' && $this->body['seat_lf'] !== 'stained') {
            $errors['seat_lf'] = 'You must select LF of seat.';
        }

        if ($this->body['seat_rf'] !== 'good' && $this->body['seat_rf'] !== 'worn' && $this->body['seat_rf'] !== 'burnholes' && $this->body['seat_rf'] !== 'torn' && $this->body['seat_rf'] !== 'stained') {
            $errors['seat_rf'] = 'You must select RF of seat.';
        }

        if ($this->body['seat_rear'] !== 'good' && $this->body['seat_rear'] !== 'worn' && $this->body['seat_rear'] !== 'burnholes' && $this->body['seat_rear'] !== 'torn' && $this->body['seat_rear'] !== 'stained') {
            $errors['seat_rear'] = 'You must select REAR of seat.';
        }

        if ($this->body['carpet_lf'] !== 'good' && $this->body['carpet_lf'] !== 'worn' && $this->body['carpet_lf'] !== 'burnholes' && $this->body['carpet_lf'] !== 'torn' && $this->body['carpet_lf'] !== 'stained' && $this->body['carpet_lf'] !== 'missing') {
            $errors['carpet_lf'] = 'You must select LF of carpet.';
        }

        if ($this->body['carpet_rf'] !== 'good' && $this->body['carpet_rf'] !== 'worn' && $this->body['carpet_rf'] !== 'burnholes' && $this->body['carpet_rf'] !== 'torn' && $this->body['carpet_rf'] !== 'stained' && $this->body['carpet_rf'] !== 'missing') {
            $errors['carpet_rf'] = 'You must select RF of carpet.';
        }

        if ($this->body['carpet_rear'] !== 'good' && $this->body['carpet_rear'] !== 'worn' && $this->body['carpet_rear'] !== 'burnholes' && $this->body['carpet_rear'] !== 'torn' && $this->body['carpet_rear'] !== 'stained' && $this->body['carpet_rear'] !== 'missing') {
            $errors['carpet_rear'] = 'You must select REAR of carpet.';
        }

        if ($this->body['rim_lf'] !== 'good' && $this->body['rim_lf'] !== 'scratched'  && $this->body['rim_lf'] !== 'cracked' && $this->body['rim_lf'] !== 'damaged' && $this->body['rim_lf'] !== 'missing') {
            $errors['rim_lf'] = 'You must select LF of rim.';
        }

        if ($this->body['rim_rf'] !== 'good' && $this->body['rim_rf'] !== 'scratched'  && $this->body['rim_rf'] !== 'cracked' && $this->body['rim_rf'] !== 'damaged' && $this->body['rim_rf'] !== 'missing') {
            $errors['rim_rf'] = 'You must select RF of rim.';
        }

        if ($this->body['rim_lr'] !== 'good' && $this->body['rim_lr'] !== 'scratched'  && $this->body['rim_lr'] !== 'cracked' && $this->body['rim_lr'] !== 'damaged' && $this->body['rim_lr'] !== 'missing') {
            $errors['rim_lr'] = 'You must select LR of rim.';
        }

        if ($this->body['rim_rr'] !== 'good' && $this->body['rim_rr'] !== 'scratched'  && $this->body['rim_rr'] !== 'cracked' && $this->body['rim_rr'] !== 'damaged' && $this->body['rim_rr'] !== 'missing') {
            $errors['rim_rr'] = 'You must select RR of rim.';
        }
        
        if ($this->body['current_fuel_level'] !== 'full' && $this->body['current_fuel_level'] !== 'empty' && $this->body['current_fuel_level'] !== 'half' && $this->body['current_fuel_level'] !== '3/4' && $this->body['current_fuel_level'] !== '1/4') {
            $errors['current_fuel_level'] = 'You must select capacity';
        }

        if (trim($this->body['milage']) === "") {
            $errors['milage'] = "Milage must not be empty";
        } else if (!preg_match('/^[0-9]*[1-9][0-9]*$/', $this->body['milage'])) {
            $errors['milage'] = "Milage must be a positive";
        }

        if (strlen($this->body['admiting_time']) == 0) {
            $errors['admiting_time'] = 'Admitting time must not be empty.';
        }

        if (strlen($this->body['departing_time']) == 0) {
            $errors['departing_time'] = 'Department time must not be empty.';
        }

        if (strlen($this->body['customer_belongings']) == 0) {
            $errors['customer_belongings'] = 'Customer belongings must not be empty.';
        }

        if (strlen($this->body['additional_note']) == 0) {
            $errors['additional_note'] = 'Additional note must not be empty.';
        }

        if ($this->body['dashboard'] !== 'good' && $this->body['dashboard'] !== 'scratched'  && $this->body['dashboard'] !== 'damaged' && $this->body['dashboard'] !== 'burnt' && $this->body['dashboard'] !== 'stained') {
            $errors['dashboard'] = 'You must select option of dashboard.';
        }

        if ($this->body['windshield'] !== 'good' && $this->body['windshield'] !== 'scratched' && $this->body['windshield'] !== 'cracked' && $this->body['windshield'] !== 'damaged') {
            $errors['windshield'] = 'You must select windsheild';
        }

        if ($this->body['toolkit'] !== 'have' && $this->body['toolkit'] !== 'missing') {
            $errors['toolkit'] = 'You must select toolkit';
        }

        if ($this->body['sparewheel'] !== 'have' && $this->body['sparewheel'] !== 'missing') {
            $errors['sparewheel'] = 'You must select sparewheel';
        }

        return $errors;
    }

 
    public function addAdmittingReport(int $id){
        $errors = $this->validated_byAdmittingReport();
        // var_dump($id);
        if(empty($errors)){
            $query="insert into admitingreport 
                (
                    vehicle_reg_no, milage, current_fuel_level, current_fuel_level_description, admiting_time, departing_time, windshield, windshield_description, 
                    lights_lf, light_lf_description, lights_rf, light_rf_description, lights_lr, light_lr_description, lights_rr, light_rr_description, toolkit, sparewheel, rim_lf, rim_lf_description, 
                    rim_rf, rim_rf_description, rim_lr, rim_lr_description, rim_rr, rim_rr_description, seat_lf, seat_lf_description, seat_rf, seat_rf_description, seat_rear, seat_rear_description, 
                    carpet_lf, carpet_lf_description, carpet_rf, carpet_rf_description, carpet_rear, carpet_rear_description, dashboard, dashboard_description, customer_belongings, additional_note, employee_id
                )
                values
                (
                    :vehicle_reg_no, :milage, :current_fuel_level,:current_fuel_level_description, :admiting_time, :departing_time, :windshield, :windshield_description, 
                    :lights_lf, :light_lf_description, :lights_rf, :light_rf_description, :lights_lr, :light_lr_description, :lights_rr, :light_rr_description, :toolkit, :sparewheel, :rim_lf, :rim_lf_description,
                    :rim_rf, :rim_rf_description, :rim_lr, :rim_lr_description, :rim_rr, :rim_rr_description, :seat_lf, :seat_lf_description, :seat_rf, seat_rf_description, :seat_rear, :seat_rear_description,
                    :carpet_lf, :carpet_lf_description, :carpet_rf, :carpet_rf_description, :carpet_rear, :carpet_rear_description, :dashboard, :dashboard_description, :customer_belongings, :additional_note, :id
                )";
            var_dump($query);
            $statement=$this->pdo->prepare($query);
            $statement->bindvalue(":vehicle_reg_no", $this->body["vehicle_reg_no"]);
            $statement->bindvalue(":milage", $this->body["milage"]);
            $statement->bindvalue(":current_fuel_level", $this->body["current_fuel_level"]);
            $statement->bindvalue(":current_fuel_level_description", $this->body["current_fuel_level_description"]);
            $statement->bindvalue(":admiting_time", $this->body["admiting_time"]);
            $statement->bindvalue(":departing_time", $this->body["departing_time"]);
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
            // $statement->bindvalue(":employee_id", $id);
            $statement->execute();
            return true;   
        }
        else{
            return $errors;
        }
    }
}
?>