<?php

namespace app\components;

class Table
{
    public  static function render(array $items, array $columns) : void {
        $template = "<div class='employee-dashboard__table-wrapper'><table class='employee-dashboard__table'><thead><tr>";
        foreach ($columns as $column) {
            $template = $template."<th>$column</th>";
        }
        $template = $template."</tr></thead><tbody>";
        foreach ($items as $item) {
            $tr = "<tr>";
            foreach ($item as $part) {
                $tr = $tr."<td>$part</td>";
            }
            $tr = $tr."</tr>";
            $template = $template.$tr;
        }
        $template = $template."</tbody></table><div>";
        echo $template;
    }
}