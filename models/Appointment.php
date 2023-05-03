<?php

namespace app\models;

use app\core\Database;
use PDO;
use PDOException;

class Appointment
{
    private PDO $pdo;
    // PDO is a database access layer that provides a fast and
    // consistent interface for accessing and managing databases in PHP applications
    private array $body;

    public function __construct(array $registerBody = [])
    {
        $this->pdo = Database::getInstance()->pdo;
        $this->body = $registerBody;
    }

    public function getOwnerInfo(int $vin): array
    {

        return $this->pdo->query(
            "SELECT
                CONCAT(c.f_name, ' ', c.l_name) as full_name,
                c.contact_no,
                c.email,
                v.reg_no,
                v.engine_no,
                m.model_name,
                b.brand_name
            FROM vehicle v 
                RIGHT JOIN model m ON m.model_id = v.model_id
                RIGHT JOIN brand b ON b.brand_id = v.brand_id
                RIGHT JOIN customer c ON c.customer_id = v.customer_id
            WHERE
                v.vin = $vin"
        )->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllAppointments(int|null $count = null, int|null $page = 1): array
    {
        $limitClause = $count ? "LIMIT $count" : "";
        $pageClause = $page ? "OFFSET " . ($page - 1) * $count : "";

        $appointments = $this->pdo->query(
            "SELECT
                appointment_id as 'Appointment ID',
                vehicle_reg_no as 'Vehicle Reg No',
                CONCAT(c.f_name, ' ', c.l_name) as 'Customer Name',
                mileage as 'Mileage',
                remarks as 'Remarks',
                a.date as 'Date',
                a.time_id as 'Time ID',
                t.from_time as 'From Time',
                t.to_time as 'To Time',
                a.customer_id as 'Customer ID'            
            FROM 
                appointment a
            INNER JOIN 
                customer c 
            ON  
                c.customer_id = a.customer_id
            INNER JOIN  
                timeslot t 
            ON 
                t.time_id = a.time_id
            ORDER BY
                a.appointment_id $limitClause $pageClause"
        )->fetchAll(PDO::FETCH_ASSOC);
        
        $totalAppointments = $this->pdo->query(
            "SELECT COUNT(*) as total FROM appointment"
        )->fetch(PDO::FETCH_ASSOC);

        return [
            "total" => $totalAppointments['total'],
            "appointments" => $appointments
        ];
    }

    public function getAppointmentInfo(int $appointment_id): array | string
    {
        try{
            $statement = $this->pdo->prepare(
                "SELECT
                    CONCAT(c.f_name, ' ', c.l_name) as 'Customer Name',
                    vehicle_reg_no,
                    a.appointment_id,
                    a.mileage,
                    a.vehicle_reg_no,
                    a.customer_id
                FROM 
                    appointment a 
                INNER JOIN 
                    customer c 
                ON  
                    a.customer_id = c.customer_id
                WHERE 
                    a.appointment_id = :appointment_id");
            $statement->bindValue(":appointment_id", $appointment_id);
            $statement->execute();
            return $statement->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return "Internal Server Error";
    }

    public function getAppointments(): array
    {

        return $this->pdo->query("
            SELECT 
            concat(c.f_name,' ',c.l_name) as Name,
            a.vehicle_reg_no as RegNo,
            t.date as Date,
            t.from_time as FromTime,
            t.to_time as ToTime
            from appointment a
            inner join customer c on a.customer_id=c.customer_id
            inner join timeslot t on t.time_id=a.time_id")->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTimeslotsByDate(string $date): string|array
    {
        try {
            $statement = $this->pdo->prepare(
                query: "SELECT
                            time_id,
                            from_time,
                            to_time
                        FROM
                            timeslot
                        WHERE 
                            date = :date 
                        AND 
                            remaining_count > 0");
            $statement->execute(['date' => $date]);
            $timeslots = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$timeslots) {
                return "No timeslots available for this date";
            }
            return $timeslots;

        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }
  
    public function officeCreateAppointment()
    {
        try {
            $query = "  INSERT INTO 
                            appointment(
                                vehicle_reg_no,
                                mileage,
                                remarks,
                                date,
                                customer_id,
                                time_id)
                        VALUES(
                                :vehicle_reg_no,
                                :mileage,
                                :remarks,
                                :date,
                                :customer_id,
                                :time_id)
                            ";

            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":vehicle_reg_no", $this->body["vehicle_reg_no"]);
            $statement->bindValue(":mileage", $this->body["mileage"]);
            $statement->bindValue(":remarks", $this->body["remarks"]);
            $statement->bindValue(":date", $this->body["date"]); 
            $statement->bindValue(":customer_id", $this->body["customerID"]);                       
            $statement->bindValue(":time_id", $this->body["timeslot"]);            
            $statement-> execute();
            return true;
        } catch (PDOException $e) {
            var_dump($e->getMessage());
            return $e->getMessage();
        }
    }
  
    /**
     * @return array
     */
    public function getAppointmentsByCustomerID(int $customer_id): array | string
    {
        try {
            $statement = $this->pdo->prepare(
                query: "SELECT
                            a.appointment_id,
                            a.vehicle_reg_no,                       
                            a.remarks,
                            a.service_type,
                            a.date_and_time as 'created_date',
                            t.date as 'appointment_date',
                            t.from_time as 'appointment_time'
                        FROM
                            appointment a
                        INNER JOIN timeslot t ON t.time_id = a.time_id
                        
                        WHERE 
                            customer_id = :customer_id");
            $statement->execute(['customer_id' => $customer_id]);
            $appointments = $statement->fetchAll(PDO::FETCH_ASSOC);
            if (!$appointments) {
                return "No appointments available for this customer";
            }
            return $appointments;    
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return "Internal Server Error";
    }

    public function deleteAppointmentById(int $id):bool|string
    {
        try {
            $query ="DELETE FROM appointment WHERE appointment_id = :id";
            $statement = $this->pdo->prepare($query);
            $statement->bindValue(":id", $id);
            $statement->execute();
            return true;
        }
        catch (PDOException $e){
            return "Error deleting Supplier";

        }
    }
}

