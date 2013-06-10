<?php

  define("DEBUG", true);

  spl_autoload_register(function($className){
    include "lib/" . $className . ".php";
  });

  if (!DEBUG) {
    include "lib/error-handling.php";
  }

  $app = new Application();

  foreach (glob("app/*/*.php") as $filename)
  {
    include $filename;
  }

  $app->handle($_SERVER);

?>