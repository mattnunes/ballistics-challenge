<?php

class Response
{
  public function send($string)
  {
    header('Content-type: text/plain');
    echo $string;
  }

  public function json($object)
  {
    header('Content-type: application/json');
    echo json_encode($object);
  }
}

?>