<?php

  define("DEBUG", true);

  foreach (glob("lib/*.php") as $filename)
  {
    include_once $filename;
  }

  if (!DEBUG) {
    include "lib/error-handling.php";
  }

  $app = new Application();

  foreach (glob("app/*/*.php") as $filename)
  {
    include_once $filename;
  }

  $app->handle($_SERVER);

?>