<?php

$app->get('/statistics', function($req, $res){
  $res->json(array(
             'top5' => Statistics::getTop5(),
             'me' => Statistics::getCurrent(),
             'userCount' => Statistics::getUserCount(),
             'shotCount' => Statistics::getShotCount()
             ));
});

?>