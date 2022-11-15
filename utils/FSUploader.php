<?php

namespace app\utils;

use app\core\Application;
use app\core\Uploader;
use Exception;

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
    static public function upload(string $fieldName = "image", float $limit = 5, bool $multiple = false, string $innerDir = "", array $allowed = ["jpg", "jpeg", "png", "webp"]): string|array
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
        } else {
            $file = $_FILES[$fieldName];
            echo "<pre>";
            var_dump($file);
            echo "</pre>";
            return self::uploadFile(file: $file, limit: $limit, innerDir: $innerDir, allowed: $allowed);
        }
    }

    /**
     * @param array $file
     * @param float|int $limit
     * @param string $innerDir
     * @param array $allowed
     * @return string
     * @throws Exception
     */
    static private function uploadFile(array $file, float|int $limit, string $innerDir, array $allowed): string
    {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));


        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < $limit * 1024 * 1024) {
                    $fileNameNew = uniqid(prefix: '', more_entropy: true) . "." . $fileActualExt;
                    $fileDestination = Application::$rootDir . "/public/uploads" . "/" . $innerDir . "/" . $fileNameNew;
                    if (!file_exists(filename: Application::$rootDir . "/public/uploads" . "/" . $innerDir)) {
                        mkdir(directory: Application::$rootDir . "/public/uploads" . "/" . $innerDir,permissions:  0777, recursive: true);
                    }
                    move_uploaded_file($fileTmpName, $fileDestination);
                    return "/uploads/" . $innerDir . "/" . $fileNameNew;
                } else {
                    throw new Exception("Your file is too big!");
                }
            } else {
                throw new Exception("There was an error uploading your file!");
            }
        } else {
            throw new Exception("You cannot upload files of this type!");
        }
    }
}