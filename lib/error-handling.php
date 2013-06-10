<?php
  
  if (!DEBUG) {
    set_error_handler(function($errno, $errstr){
      header("HTTP/1.0 500 Server Error");
    });

    set_exception_handler(function($exception){
      switch ($exception->getCode()) {
        case 400:
          header("HTTP/1.0 400 Bad Request");
          break;

        case 404:
          header("HTTP/1.0 403 Resource Not Found");
          break;
        
        default:
          header("HTTP/1.0 500 Server Exception");
          break;
      }
    });
  }

?>