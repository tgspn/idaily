<?php

class ViewHelper
{
  public static function GetCurrentUser()
  {
    return unserialize($_SESSION["current_user"]);
  }
  public static function GetModel()
  {
    $list = [];
    $list = unserialize($_SESSION["model"]);
    unset($_SESSION["model"]);
    return $list;
  }

  public static function GetViewBag($key)
  {
    if (!isset($_SESSION[$key]))
      return null;
    $return = unserialize($_SESSION[$key]);
    unset($_SESSION[$key]);
    return $return;
  }

  public static function InPapel($expected)
  {
    $currentUser = ViewHelper::GetCurrentUser();
    return strtolower($currentUser->getPapel()->getNome()) === strtolower($expected);
  }
}
