<?php

namespace app\utils;

class DocumentHead
{
    /**
     * @param array $css
     * @param array $js
     * @param string $title
     * @return void
     */
    public static function createHead(array $css = [], array $js = [], string $title = "AutoRealm", array $cdnJS = []): void
    {

        $isDev = $_ENV["MODE"] === "development";

        $cssIncludes = "";
        if ($isDev) {
            $cssIncludes = "<style id='dev'>@import \"/css/style.css\";</style>";
        } else {
            foreach ($css as $cssFile) {
                $cssIncludes .= "<link rel='stylesheet' href='$cssFile'>";
            }
        }



        $jsIncludes = "";
        foreach ($js as $jsFile) {
            $jsIncludes .= "<script src='$jsFile'></script>";
        }

        foreach ($cdnJS as $jsFile) {
            $jsIncludes .= $jsFile;
        }




        $injectedSocket = $isDev ? "<script src='/__DEV__/ar.js' type='module'></script>" : "";

        echo "
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0'>
                <meta http-equiv='X-UA-Compatible' content='ie=edge'>
                <link rel='shortcut icon' href='/favicon.ico' type='image/x-icon'>
                <script src='https://kit.fontawesome.com/115370f697.js' crossorigin='anonymous'></script>
                $jsIncludes
                $injectedSocket
                <link rel='preconnect' href='https://fonts.googleapis.com'>
                <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
                <link href='https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&display=swap' rel='stylesheet'>
                $cssIncludes
                <title>$title</title>
            </head>
            ";
    }
}