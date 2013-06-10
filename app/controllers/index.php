<?php

$app->get('/', function($req, $res){
  $res->redirect('index.html');
});

$app->get('/session', function($req, $res){
  $session = Session::currentSession();
  $res->json($session);
});

?>