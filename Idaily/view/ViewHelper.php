<?php

class ViewHelper
{
    public static function GetModel()
    {
        $list=[];
        $list= unserialize($_SESSION["model"]);
        $_SESSION["model"] = "";
        return $list;
    }
}
