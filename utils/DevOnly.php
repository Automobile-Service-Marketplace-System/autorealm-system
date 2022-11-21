<?php

namespace app\utils;

class DevOnly
{
    /**
     * @throws \JsonException
     */
    public static function printToBrowserConsole(mixed $data) : void {
        $output = $data;
        if (is_array($output)) {
            $output = implode(',', $output);
            $output = json_encode($output, JSON_THROW_ON_ERROR);
        }

        echo "<script>console.log(`From php: " . "`\$\{JSON.parse($output)\}\`" . "' );</script>";
    }
}