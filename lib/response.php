<?php

class Response
{
  public function redirect($to)
  {
    header('Location: ' . $to);
  }

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