<?php

namespace app\utils;

use app\core\Application;
use app\core\Uploader;

class FSUploader extends Uploader
{
    // property to hold the path /uploads
    private static string $uploadPath = Application::$rootDir . "/public/uploads";



    /**
     * @param string $fieldName
     * @param float $limit
     * @param bool $multiple
     * @param string $innerDir
     * @return string | array[string]
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
                $urls[] = self::uploadFile($file, $limit, $innerDir);
            }
            return $urls;
        } else {
            $file = $_FILES[$fieldName];
            echo "<pre>";
            var_dump($file);
            echo "</pre>";
            //            $file = $_FILES[$fieldName];
//            return $this->uploadFile($file, $limit, $innerDir);
        }
        //        else {}
        return "string";

    }

    static private function uploadFile(array $file, float|int $limit, string $innerDir)
    {
        $fileName = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $fileType = $file['type'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        $allowed = ['jpg', 'jpeg', 'png', 'pdf'];

        if (in_array($fileActualExt, $allowed)) {
            if ($fileError === 0) {
                if ($fileSize < $limit * 1024 * 1024) {
                    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
                    $fileDestination = self::$uploadPath . "/" . $innerDir . "/" . $fileNameNew;
                    if (!file_exists(self::$uploadPath . "/" . $innerDir)) {
                        mkdir(self::$uploadPath . "/" . $innerDir, 0777, true);
                    }
                    move_uploaded_file($fileTmpName, $fileDestination);
                    return "/uploads/" . $innerDir . "/" . $fileNameNew;
                } else {
                    return "Your file is too big!";
                }
            } else {
                return "There was an error uploading your file!";
            }
        } else {
            return "You cannot upload files of this type!";
        }
    }
}