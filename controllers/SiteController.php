<?php

namespace app\controllers;

use app\core\Request;
use app\core\Response;

class SiteController
{

    public  function  getHomePage(Request $req, Response $res) : string {
        return $res->render(view: "home", layout: "landing");
    }
}