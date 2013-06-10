<?php

class Router
{
  private $routing_table;

  private function map_handler($method, $route, $handler)
  {
    $route_pattern = $this->parse_route($route);
    $this->routing_table[$method][$route_pattern] = array('route' => $route,
                                                          'handler' => $handler);
  }

  private function parse_route($route_string)
  {
    $route_string = preg_replace("/\:([^\/]+)/", "(?<$1>[^/]+)", $route_string);
    $route_string = preg_replace("/\//", "\/", $route_string);
    $route_string = '/^' . $route_string . '$/';
    return $route_string;
  }

  public function get($route, $handler)
  {
    $this->map_handler('GET', $route, $handler);
  }

  public function post($route, $handler)
  {
    $this->map_handler('POST', $route, $handler);
  }

  public function del($route, $handler)
  {
    $this->map_handler('DELETE', $route, $handler);
  }

  public function put($route, $handler)
  {
    $this->map_handler('PUT', $route, $handler);
  }

  public function route(Request $request, Response $response)
  {
    $routes = $this->routing_table[$request->method];

    if (count($routes) < 1) {
      throw new Exception('No Routes Found', 404);
    }

    foreach ($routes as $pattern => $handler) {
      $result = preg_match($pattern, $request->path, $matches);
      if ($result == 1) {
        $request->pattern = $pattern;
        $request->path_matches = $matches;
        $request->route = $handler['route'];
        call_user_func($handler['handler'], $request, $response);
      }
    }

    if (!$request->pattern) {
      throw new Exception('No Routes Found', 404);
    }
  }
}

?>