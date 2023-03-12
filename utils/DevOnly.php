<?php

namespace app\utils;

use JsonException;

class DevOnly
{
    /**
     * @throws JsonException
     */
    public static function printToBrowserConsole(mixed $data): void
    {
        $mode = $_ENV['MODE'];
        if ($mode === "development") {
            $output = $data;
            if (is_array($output)) {
                $output = json_encode($output, JSON_THROW_ON_ERROR);
            }
            $stmt = "'$output'";
            echo "<script>
                let value = JSON.parse($stmt)
                console.log('%c[PHP]: ',
                'color: rgb(0, 83, 243);font-weight: bold;', value)
             </script>";
        }

    }

    public static function prettyEcho(mixed $data): void {
        $mode = $_ENV['MODE'];
        if ($mode === "development") {
            echo "<pre>";
            var_dump($data);
            echo "</pre>";
        }
    }
}