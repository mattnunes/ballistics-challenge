<?php

include "autoload.php";

class RouterTest extends PHPUnit_Framework_TestCase
{
  protected function setUp() {
    $this->router = new Router();
  }

  private function request($path, $type) {
    $_server = array('REDIRECT_URL' => $path, 'REQUEST_METHOD' => $type);
    $request = new Request($_server);
    return $request;
  }

  private function response($expected) {
    $response = $this->getMock('Response', array('send'));
    $response->expects($this->once())
             ->method('send')
             ->with($this->equalTo($expected));
    return $response;
  }

  public function response_provider() {
    return array(array($this->response('Hello, World!')));
  }

  /**
   * @dataProvider response_provider
   */
  public function testGetMethod($response) {
    $this->router->get('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->router->route($this->request('/', 'GET'), $response);
  }

  /**
   * @dataProvider response_provider
   */
  public function testPostMethod($response) {
    $this->router->post('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->router->route($this->request('/', 'POST'), $response);
  }

  /**
   * @dataProvider response_provider
   */
  public function testDelMethod($response) {
    $this->router->del('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->router->route($this->request('/', 'DELETE'), $response);
  }

  /**
   * @dataProvider response_provider
   */
  public function testPutMethod($response) {
    $this->router->put('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->router->route($this->request('/', 'PUT'), $response);
  }

  /**
   * @dataProvider response_provider
   * @expectedException Exception
   * @expectedExceptionCode 404
   */
  public function testFailure($response) {
    $this->router->get('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->router->route($this->request('/hello', 'GET'), $response);
  }

  public function testVariablesInUrl() {
    $response = $this->response('world');

    $this->router->get('/hello/:name', function($req, $res){
      $res->send($req->path_matches['name']);
    });

    $this->router->route($this->request('/hello/world', 'GET'), $response);
  }
}

?>