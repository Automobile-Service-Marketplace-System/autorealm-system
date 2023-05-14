<?php

namespace app\models;

use app\core\Database;
use app\utils\DevOnly;
use PDO;

class InspectionCondition
{

    private PDO $pdo;


    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }


    public function getConditions(): array
    {
        $rawConditions = $this->pdo->query("SELECT * FROM inspectioncondition")->fetchAll(PDO::FETCH_ASSOC);

        $conditions = [];
        $conditions["category_less"] = [];
        foreach ($rawConditions as $rawCondition) {

            $condition_parts = explode(" - ", $rawCondition['condition_name']);
//            check id condition_parts array length is 2
            if (count($condition_parts) === 2) {
                [$condition_name, $condition_section] = $condition_parts;
                if (!isset($conditions[$condition_section])) {
                    $conditions[$condition_section] = [];
                }

                $conditions[$condition_section][] = $condition_name;
            } else {
                $conditions["category_less"][] = $condition_parts[0];
            }
        }

        return $conditions;
    }
}