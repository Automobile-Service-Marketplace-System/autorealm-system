<?php
namespace app\utils;
//require_once __DIR__ . "/../vendor/aws/aws-sdk-php/src/S3/S3Client.php";
//require_once __DIR__ . "/../vendor/aws/aws-sdk-php/src/S3/Exception/S3Exception.php";

use app\core\Uploader;
//use \Aws\Result;
//use \Aws\S3\Exception\S3Exception;
//use \AWS\S3\S3Client;
//use \Aws\S3\S3Client;
use Exception;
use RuntimeException;


class S3Uploader extends Uploader
{
    private static S3Uploader $instance;
    private static \Aws\S3\S3Client $s3Client;

    private static string $bucketName;


    final private function __construct()
    {
        self::$s3Client = new \Aws\S3\S3Client([
            'version' => 'latest',
            'region' => $_ENV['AWS_REGION'],
            'credentials' => [
                'key' => $_ENV['AWS_ACCESS_KEY_ID'],
                'secret' => $_ENV['AWS_ACCESS_KEY'],
            ]
        ]);

        self::$bucketName = $_ENV['AWS_S3_BUCKET_NAME'];
    }


    private static function getInstance(): S3Uploader
    {
        if (!isset(self::$instance)) {
            self::$instance = new S3Uploader();
        }
        return self::$instance;
    }

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
                $urls[] = self::getInstance()->uploadFile(file: $file, limit: $limit, innerDir: $innerDir, allowed: $allowed);
            }
            return $urls;
        }

        $file = $_FILES[$fieldName];
//        echo "<pre>";
//        var_dump($file);
//        echo "</pre>";
        return self::getInstance()->uploadFile(file: $file, limit: $limit, innerDir: $innerDir, allowed: $allowed);
    }

    /**
     * @param array $file
     * @param float|int $limit
     * @param string $innerDir
     * @param array $allowed
     * @return string
     * @throws Exception
     */
    private function uploadFile(array $file, float|int $limit, string $innerDir, array $allowed): string
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
                    $fileDestination = "/uploads" . "/" . $innerDir . "/" . $fileNameNew;

                    /**
                     * @var array|null $result
                     */
                    $result = null;
                    try {
                        $result = self::$s3Client->putObject([
                            'Bucket' => self::$bucketName,
                            'Key' => $fileDestination,
                            'Body' => fopen($fileTmpName, 'r'),
                            'ContentType' => mime_content_type($fileTmpName),
                            'ACL' => 'public-read'
                        ]);
                    } catch (\Aws\S3\Exception\S3Exception $e) {
                        throw new RuntimeException("There was an error uploading your file!");
                    }

                    return $result['ObjectURL'];
//                    return "https://" . $bucketName . ".s3." . $_ENV['AWS_REGION'] . ".amazonaws.com/" . $fileDestination;
                }

                throw new RuntimeException("Your file is too big!");
            }

            throw new RuntimeException("There was an error uploading your file!");
        }

        throw new RuntimeException("You cannot upload files of this type!");
    }


    /**
     * @param string $dataURL
     * @param string $innerDir
     * @param string $ext
     * @return string
     * @throws S3Exception
     */
    public static function saveDataURLFile(string $dataURL, string $innerDir = "", string $ext = "png"): string
    {
//        global $s3Client, $bucketName;
//        $dataURL = explode(",", $dataURL);
//        $dataURL = $dataURL[1];
//        $dataURL = base64_decode($dataURL);
//        $fileNameNew = uniqid(prefix: true, more_entropy: true) . ".$ext";
//
//        try {
//            $result = $s3Client->putObject([
//                'Bucket' => $bucketName,
//                'Key' => "uploads/$innerDir/$fileNameNew",
//                'Body' => $dataURL,
//                'ACL' => 'public-read'
//            ]);
//
//            return $result['ObjectURL'];
//        } catch (S3Exception $e) {
//            throw new RuntimeException($e->getMessage());
//        }
        return self::getInstance()->_saveDataURLFile(dataURL: $dataURL, innerDir: $innerDir, ext: $ext);
    }

    private function _saveDataURLFile(string $dataURL, string $innerDir = "", string $ext = "png"): string
    {
        $dataURL = explode(",", $dataURL);
        $dataURL = $dataURL[1];
        $dataURL = base64_decode($dataURL);
        $fileNameNew = uniqid(prefix: true, more_entropy: true) . ".$ext";

        try {
            $result = self::$s3Client->putObject([
                'Bucket' => self::$bucketName,
                'Key' => "uploads/$innerDir/$fileNameNew",
                'Body' => $dataURL,
//                'ACL' => 'public-read'
            ]);

            return $result['ObjectURL'];
        } catch (\AWS\S3\Exception\S3Exception $e) {
            throw new RuntimeException($e->getMessage());
        }
    }

    public static function deleteFile(string $url): string
    {
        return self::getInstance()->_deleteFile(url: $url);
    }

    private function _deleteFile(string $url): string
    {
        $parsedUrl = parse_url($url);
        $path = $parsedUrl['path'];
        $objectKey = ltrim($path, '/');
        try {
            self::$s3Client->deleteObject([
                'Bucket' => self::$bucketName,
                'Key' => $objectKey
            ]);
            return "File deleted successfully";
        } catch (\AWS\S3\Exception\S3Exception $e) {
            return  $e->getMessage();
        }
    }

}