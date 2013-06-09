<?php

include "autoload.php";

class ApplicationTest extends PHPUnit_Framework_TestCase
{
  protected function setUp() {
    $this->app = new Application();
  }

  public function request($path, $type) {
    return array('REDIRECT_URL' => $path, 'REQUEST_METHOD' => $type);
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
    $this->app->get('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->app->handle($this->request('/', 'GET'), $response);
  }

  /**
   * @dataProvider response_provider
   */
  public function testPostMethod($response) {
    $this->app->post('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->app->handle($this->request('/', 'POST'), $response);
  }

  /**
   * @dataProvider response_provider
   */
  public function testDelMethod($response) {
    $this->app->del('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->app->handle($this->request('/', 'DELETE'), $response);
  }

  /**
   * @dataProvider response_provider
   */
  public function testPutMethod($response) {
    $this->app->put('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->app->handle($this->request('/', 'PUT'), $response);
  }

  /**
   * @dataProvider response_provider
   * @expectedException Exception
   * @expectedExceptionCode 404
   */
  public function testFailure($response) {
    $this->app->get('/', function($req, $res){
      $res->send('Hello, World!');
    });

    $this->app->handle($this->request('/hello', 'GET'), $response);
  }

  public function testVariablesInUrl() {
    $response = $this->response('world');

    $this->app->get('/hello/:name', function($req, $res){
      $res->send($req->path_matches['name']);
    });

    $this->app->handle($this->request('/hello/world', 'GET'), $response);
  }
}

?>