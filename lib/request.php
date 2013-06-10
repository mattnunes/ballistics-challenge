<?php

class Request
{
  public $path;
  public $method;
  public $query;
  public $params;
  public $session;
  public $route;
  public $pattern;
  public $path_matches;

  public function __construct($request)
  {
    $this->path = $request['REDIRECT_URL'];
    $this->method = $request['REQUEST_METHOD'];
    $this->query = (object)$_GET;
    $this->params = (object)$_POST;
    $this->session = Session::currentSession();

    if (DEBUG) {
      $this->_SERVER = $request;
    }
  }
}

?>