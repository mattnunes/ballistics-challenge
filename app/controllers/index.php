<?php

$app->get('/', function($req, $res){
  $res->redirect('index.html');
});

?>