<?php

class Index_Model extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ImageBackgroundRemove()
    {
        $img = json_decode(file_get_contents('php://input'));
        var_dump($img); exit;
        $cmdResult = shell_exec($img);
        $result = json_decode($cmdResult);
        print_r($result);
    }
}