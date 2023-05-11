<?php

namespace app\utils;

use app\core\Application;
use app\core\Uploader;
use Exception;
use RuntimeException;

class FSUploader extends Uploader
{

    /**
     * @param string $fieldName
     * @param float $limit
     * @param bool $multiple
     * @param string $innerDir
     * @param array $allowed
     * @return string|array
     * @throws Exception
     */
    public static function upload(string $fieldName = "image", float $limit = 5, bool $multiple = false, string $innerDir = "", array $allowed = ["jpg", "jpeg", "png", "webp"]): string|array
    {
        if ($multiple) {
            $files = $_FILES[$fieldName];
            $urls = [];
            foreach ($files['name'] as $key => $value) {
                $file = [
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key],
                ];
                $urls[] = self::uploadFile(file: $file, limit: $limit, innerDir: $innerDir, allowed: $allowed);
            }
            return $urls;
        }

        $file = $_FILES[$fieldName];
        echo "<pre>";
        var_dump($file);
        echo "</pre>";
        return self::uploadFile(file: $file, limit: $limit, innerDir: $innerDir, allowed: $allowed);
    }

    /**
     * @param array $file
     * @param float|int $limit
     * @param string $innerDir
     * @param array $allowed
     * @return string
     * @throws Exception
     */
    private static function uploadFile(array $file, float|int $limit, string $innerDir, array $allowed): string
    {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));


        if (in_array($fileActualExt, $allowed, true)) {
            if ($fileError === 0) {
                if ($fileSize < $limit * 1024 * 1024) {
                    $fileNameNew = uniqid(prefix: true, more_entropy: true) . "." . $fileActualExt;
                    $fileDestination = Application::$rootDir . "/public/uploads" . "/" . $innerDir . "/" . $fileNameNew;
                    if (!file_exists(filename: Application::$rootDir . "/public/uploads" . "/" . $innerDir) && !mkdir($concurrentDirectory = Application::$rootDir . "/public/uploads" . "/" . $innerDir, 0777, true) && !is_dir($concurrentDirectory)) {
                        throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
                    }
                    move_uploaded_file($fileTmpName, $fileDestination);
                    return "/uploads/" . $innerDir . "/" . $fileNameNew;
                }

                throw new RuntimeException("Your file is too big!");
            }

            throw new RuntimeException("There was an error uploading your file!");
        }

        throw new RuntimeException("You cannot upload files of this type!");
    }


    public static function saveDataURLFile(string $dataURL, string $innerDir = "", string $ext = "png") : string {
        $dataURL = explode(",", $dataURL);
        $dataURL = $dataURL[1];
        $dataURL = base64_decode($dataURL);
        $fileNameNew = uniqid(prefix: true, more_entropy: true) . ".$ext";
        $fileDestination = Application::$rootDir . "/public/uploads" . "/" . $innerDir . "/" . $fileNameNew;
        if (!file_exists(filename: Application::$rootDir . "/public/uploads" . "/" . $innerDir) && !mkdir($concurrentDirectory = Application::$rootDir . "/public/uploads" . "/" . $innerDir, 0777, true) && !is_dir($concurrentDirectory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $concurrentDirectory));
        }
        file_put_contents($fileDestination, $dataURL);
        return "/uploads/" . $innerDir . "/" . $fileNameNew;
    }
}