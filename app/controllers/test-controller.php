<?php

$app->get('/test', function($req, $res){
  $res->json($req);
});

?>