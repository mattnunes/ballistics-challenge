<?php

class Application
{
  private $router;

  function __construct()
  {
    $this->router = new Router();
  }

  public function get($route, $handler)
  {
    $this->router->get($route, $handler);
  }

  public function post($route, $handler)
  {
    $this->router->post($route, $handler);
  }

  public function del($route, $handler)
  {
    $this->router->del($route, $handler);
  }

  public function put($route, $handler)
  {
    $this->router->put($route, $handler);
  }

  public function handle($_server, $response = null)
  {
    if (!isset($response)) {
      $response = new Response();
    }
    $request = new Request($_server);

    $this->router->route($request, $response);
  }
}

?>