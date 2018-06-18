<?php

/**
 *
 */
class ControllerBase
{
  protected $controller;
  protected $currentUser;
  public function __construct($controller)
  {
    $this->controller = $controller;
    if (isset($_SESSION["current_user"])) {
      $this->currentUser = unserialize($_SESSION["current_user"]);
    }
  }
  protected function InPapel($expected)
  {
    return strtolower($this->currentUser->getPapel()->getNome()) === strtolower($expected);
  }
  protected function IsPost()
  {
    return $_SERVER['REQUEST_METHOD'] === "POST";
  }
  protected function RenderView($view)
  {
    require_once 'view/' . $this->controller . '/' . $view . '.php';
  }

  protected function RedirectTo($view, $controller = "")
  {
    $url = StringHelper::Join("/", array($controller, $view)); //join("/", array($controller, $view));
    header("Location:" . $url);
  }
  protected function SetModel($obj)
  {
    $_SESSION["model"] = serialize($obj);
  }

  protected function SetViewBag($key, $obj)
  {
    $_SESSION[$key] = serialize($obj);
  }
}
