<?php

namespace app\components;

class Table
{
    public  static function render(array $items, array $columns) : void {
        $template = "<table class='employee-dashboard__table'><tr>";
        foreach ($columns as $column) {
            $template = $template."<th>$column</th>";
        }
        $template = $template."</tr>";
        foreach ($items as $item) {
            $tr = "<tr>";
            foreach ($item as $part) {
                $tr = $tr."<td>$part</td>";
            }
            $tr = $tr."</tr>";
            $template = $template.$tr;
        }
        $template = $template."</table>";
        echo $template;
    }
}