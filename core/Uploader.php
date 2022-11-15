<?php

namespace app\core;

abstract class Uploader
{
    // abstract method that uploads the file and returns the public url
    // Have to be implemented in the child class
    abstract public static function upload(): string | array;

}