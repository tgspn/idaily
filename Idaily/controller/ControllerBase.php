<?php

/**
 *
 */
class ControllerBase
{
  public function __construct()
  {
  }
  protected function IsPost()
  {
    return $_SERVER['REQUEST_METHOD'] === "POST";
  }
  protected function RenderView($view)
  {
    require_once 'view/diaria/' . $view . '.php';
  }

  protected function RedirectTo($view, $controller)
  {
    header("Location:" . join("/", array($controller, $view)));
  }
  protected function SetModel($obj)
  {
    $_SESSION["model"] = serialize($obj);
  }
}
