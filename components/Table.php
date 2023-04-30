<?php

namespace app\components;

class Table
{

    public  static function render(array $items, array $columns, array $keyColumns = [], array $ommitedColumns = []) : void {


        $keyColumnsLength = count($keyColumns);
        $columnsLength = count($columns);
        $tableStickClass = $keyColumnsLength === 1 ? "" : "table--end";
        $template = "<div class='employee-dashboard__table-wrapper'><table class='employee-dashboard__table $tableStickClass'><thead><tr>";
        foreach ($columns as $index=>$column) {

            if(!in_array($column, $ommitedColumns, true)) {
                $isSticky = $index === 0 || $index === $columnsLength - 1;
                $stickyClass = $isSticky ? "sticky" : "";
                $template .= "<th class='$stickyClass'>$column</th>";
            }
            
        }
        $template .= "</tr></thead><tbody>";
        foreach ($items as $item) {
            $tr = "<tr>";
            foreach ($item as $key => $part) {

                //isSticky $key is in $keyColumns

                if(!in_array($key, $ommitedColumns, true)){
                    $isSticky = in_array($key, $keyColumns, true);
                    $stickyClass = $isSticky ? "sticky" : "";
                    $tr = $tr."<td class='$stickyClass'>$part</td>";
                }

            }
            $tr .= "</tr>";
            $template .= $tr;
        }
        $template .= "</tbody></table></div>";
        echo $template;
    }
}