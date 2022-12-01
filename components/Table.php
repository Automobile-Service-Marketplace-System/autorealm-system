<?php

namespace app\components;

class Table
{
    public  static function render(array $items, array $columns, array $keyColumns = []) : void {

        $keyColumnsLength = count($keyColumns);
        $columnsLength = count($columns);
        $tableStickClass = $keyColumnsLength === 1 ? "" : "table--end";
        $template = "<div class='employee-dashboard__table-wrapper'><table class='employee-dashboard__table $tableStickClass'><thead><tr>";
        foreach ($columns as $index=>$column) {
            $isSticky = $index === 0 || $index === $columnsLength - 1;
            $stickyClass = $isSticky ? "sticky" : "";
            $template = $template."<th class='$stickyClass'>$column</th>";
        }
        $template = $template."</tr></thead><tbody>";
        foreach ($items as $item) {
            $tr = "<tr>";
            foreach ($item as $key => $part) {
                //isSticky $key is in $keyColumns
                $isSticky = in_array($key, $keyColumns);
                $stickyClass = $isSticky ? "sticky" : "";
                $tr = $tr."<td class='$stickyClass'>$part</td>";
            }
            $tr = $tr."</tr>";
            $template = $template.$tr;
        }
        $template = $template."</tbody></table><div>";
        echo $template;
    }
}