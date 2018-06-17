<?php

/**
 *
 */
class ControllerBase
{
  protected $controller;
  public function __construct($controller)
  {
    $this->controller = $controller;
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
    $url = join("/", array($controller, $view));
    header("Location:" . $url);
  }
  protected function SetModel($obj)
  {
    $_SESSION["model"] = serialize($obj);
  }
}
