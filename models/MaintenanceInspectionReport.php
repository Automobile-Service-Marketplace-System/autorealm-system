<?php

namespace app\models;

use app\core\Database;
use app\utils\DevOnly;
use JetBrains\PhpStorm\ArrayShape;
use PDO;
use PDOException;

class MaintenanceInspectionReport
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->pdo;
    }

    public function getJobCardInspectionReportStatus(int $jobId): bool|array
    {

        try {

            $statement = $this->pdo->prepare("SELECT report_id, is_draft FROM maintenance_inspection_report WHERE job_card_id = :jobId");
            $statement->bindValue(":jobId", $jobId);
            $statement->execute();

            if ($statement->rowCount() === 0) {
                return false;
            }

            return $statement->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return false;
        }

    }

    public function  getSavedConditions(
        #[ArrayShape([
            "category_less" => "array",
            "Lights" => "array",
            "Fluid levels" => "array",
            "Filters" => "array",
            "Tyre pressure" => "array",
            "Hybrid Services" => "array",
            "Suspension" => "array",
        ])] array $body,
        int       $jobId): array
    {

        /**
         * @var string[] $conditionsWithoutCategories
         */
        $conditionsWithoutCategories = $body['category_less'];


        $categories = array_diff_key($body, ['category_less' => []]);
        $savedConditions = array_merge(["category_less" => []], array_fill_keys(array_keys($categories), []));
        try {
            foreach ($conditionsWithoutCategories as $conditionWithoutCategory) {
                $statement = $this->pdo->prepare("SELECT condition_id FROM inspectioncondition WHERE condition_name = :conditionName");
                $statement->bindValue(":conditionName", $conditionWithoutCategory);
                $statement->execute();
                if ($statement->rowCount() === 0) {
                    $savedConditions["category_less"][] = [
                        "condition_name" => $conditionWithoutCategory,
                        "condition_status" => "not-passed",
                        "condition_remarks" => "No remarks",
                    ];
                } else {
                    $conditionId = $statement->fetch(PDO::FETCH_ASSOC)['condition_id'];

                    $statement = $this->pdo->prepare("SELECT status, note FROM inspectionreporthascondition WHERE condition_id = :conditionId AND job_card_id = :jobId");
                    $statement->bindValue(":conditionId", $conditionId);
                    $statement->bindValue(":jobId", $jobId);
                    $statement->execute();

                    if ($statement->rowCount() === 0) {
                        $savedConditions["category_less"][] = [
                            "condition_name" => $conditionWithoutCategory,
                            "condition_status" => "not-passed",
                            "condition_remarks" => "No remarks",
                        ];
                    } else {
//                        DevOnly::prettyEcho("$conditionWithoutCategory was saved before \n");
                        $condition = $statement->fetch(PDO::FETCH_ASSOC);
                        $savedConditions["category_less"][] = [
                            "condition_name" => $conditionWithoutCategory,
                            "condition_status" => $condition['status'],
                            "condition_remarks" => $condition['note'],
                        ];
                    }

                }
            }

            foreach ($categories as $category => $conditionsOfCategory) {
                foreach ($conditionsOfCategory as $conditionOfCategory) {
                    $completeConditionName = "$conditionOfCategory - $category";
                    $statement = $this->pdo->prepare("SELECT condition_id FROM inspectioncondition WHERE condition_name = :conditionName");
                    $statement->bindValue(":conditionName", $completeConditionName);
                    $statement->execute();
                    if ($statement->rowCount() === 0) {
                        $savedConditions[$category][] = [
                            "condition_name" => $conditionOfCategory,
                            "condition_status" => "not-passed",
                            "condition_remarks" => "No remarks",
                        ];
                    } else {
//                        DevOnly::prettyEcho("$conditionOfCategory found in database \n");
                        $conditionId = $statement->fetch(PDO::FETCH_ASSOC)['condition_id'];

                        $statement = $this->pdo->prepare("SELECT status, note FROM inspectionreporthascondition WHERE condition_id = :conditionId AND job_card_id = :jobId");
                        $statement->bindValue(":conditionId", $conditionId);
                        $statement->bindValue(":jobId", $jobId);
                        $statement->execute();

                        if ($statement->rowCount() === 0) {
                            $savedConditions[$category][] = [
                                "condition_name" => $conditionOfCategory,
                                "condition_status" => "not-passed",
                                "condition_remarks" => "No remarks",
                            ];
                        } else {
//                            DevOnly::prettyEcho("$conditionOfCategory was saved before \n");
                            $condition = $statement->fetch(PDO::FETCH_ASSOC);
                            $savedConditions[$category][] = [
                                "condition_name" => $conditionOfCategory,
                                "condition_status" => $condition['status'],
                                "condition_remarks" => $condition['note'],
                            ];
                        }

                    }
                }
            }
            return $savedConditions;
        } catch (PDOException $e) {
            return $savedConditions;
        }

    }

    public function saveInspectionReport(int $jobId, array $body, bool $isDraft = true): string|array|bool
    {
        try {
            $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare("SELECT report_id FROM maintenance_inspection_report WHERE job_card_id = :jobId");
            $statement->bindValue(param: ":jobId", value: $jobId);
            $statement->execute();

            if ($statement->rowCount() === 0) {
                // already report created, so just need to update each condition
                $statement = $this->pdo->prepare(query: "INSERT INTO maintenance_inspection_report (job_card_id, is_draft) VALUES (:jobId, :is_draft)");
                $statement->bindValue(param: ":jobId", value: $jobId);
                $statement->bindValue(param: ":is_draft", value: $isDraft);
                $statement->execute();

                $maintenanceInspectionReportId = $this->pdo->lastInsertId();
            } else {
                $maintenanceInspectionReportId = $statement->fetch(mode: PDO::FETCH_ASSOC)['report_id'];
            }

            $conditions = [];
            foreach ($body as $key => $value) {
                $keyParts = explode(separator: "-", string: $key);
                if (count($keyParts) === 3) {
                    [$conditionCategory, $conditionName, $conditionType] = $keyParts;
                    $conditionNameParts = explode(separator: "_", string: $conditionName);
                    $storedConditionName = join(separator: " ", array: $conditionNameParts);

                    if (!isset($conditions[$storedConditionName])) {
                        $conditions[$storedConditionName] = [];
                    }

                    if (!isset($conditions[$storedConditionName][$conditionType])) {
                        $conditions[$storedConditionName][$conditionType] = $value;
                        $conditions[$storedConditionName]["category"] = $conditionCategory;
                    }

                }
            }

            foreach ($conditions as $conditionName => $values) {
                $name = $values['category'] === "category_less" ? $conditionName : $conditionName . " - " . $this->getPrettyConditionCategory($values['category']);
                $statement = $this->pdo->prepare("SELECT condition_id FROM inspectioncondition WHERE condition_name = :conditionName");
                $statement->bindValue(param: ":conditionName", value: $name);
                $statement->execute();
                $reportCondition = $statement->fetch(mode: PDO::FETCH_ASSOC);
                if ($reportCondition) {

                    // first checking if the condition is already recorded for this report
                    $statement = $this->pdo->prepare("SELECT * FROM inspectionreporthascondition WHERE condition_id = :conditionId AND job_card_id = :jobId AND report_id = :reportId");
                    $statement->bindValue(param: ":conditionId", value: $reportCondition['condition_id']);
                    $statement->bindValue(param: ":jobId", value: $jobId);
                    $statement->bindValue(param: ":reportId", value: $maintenanceInspectionReportId);
                    $statement->execute();
                    $status = $this->getConditionStatus($values['status']);
                    if ($statement->rowCount() === 0) {
                        // if not, then insert
                        $statement = $this->pdo->prepare("INSERT INTO inspectionreporthascondition (condition_id, job_card_id, report_id, note, status) VALUES (:conditionId, :jobId, :reportId, :note, :status)");
                    } else {
                        // if already recorded, then update
                        $statement = $this->pdo->prepare("UPDATE inspectionreporthascondition SET note = :note, status = :status WHERE condition_id = :conditionId AND job_card_id = :jobId AND report_id = :reportId");
                    }
                    $statement->bindValue(param: ":conditionId", value: $reportCondition['condition_id']);
                    $statement->bindValue(param: ":jobId", value: $jobId);
                    $statement->bindValue(param: ":reportId", value: $maintenanceInspectionReportId);
                    $statement->bindValue(param: ":note", value: $values['remark']);

                    $statement->bindValue(param: ":status", value: $this->getConditionStatus($values['status']));
                    $statement->execute();

                }
            }
            if (!$isDraft) {
                $statement = $this->pdo->prepare("UPDATE maintenance_inspection_report SET is_draft = FALSE WHERE report_id = :reportId");
                $statement->bindValue(param: ":reportId", value: $maintenanceInspectionReportId);
                $statement->execute();
            }
            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return $e->getMessage();
        }

    }

    private function getPrettyConditionCategory(string $category): string
    {
        $categoryParts = explode("_", $category);
        if (count($categoryParts) > 0) {
            return join(" ", $categoryParts);
        }
        return $category;
    }

    private function getConditionStatus(string $status): string
    {
        return match ($status) {
            "Passed" => "passed",
            default => "not-passed",
        };
    }


}