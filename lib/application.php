<?php

class Application
{
  private $router;
  private static $dbh;

  function __construct()
  {
    $this->router = new Router();
  }

  public static function getPDO() {
    if (!self::$dbh) {
      self::$dbh = new PDO('mysql:host=localhost;dbname=ballistics', 'test', 'test');
      self::$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    return self::$dbh;
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