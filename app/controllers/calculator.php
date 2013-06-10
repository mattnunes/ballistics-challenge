<?php

$app->post('/calculators/range', function($req, $res){
  $params = array(
    'launchVelocity' => floatval($req->params->launchVelocity),
    'launchAngle' => floatval($req->params->launchAngle),
  );

  $calculator = new TrajectoryCalculator();
  $calculator->launchVelocity = $params['launchVelocity'];
  $calculator->launchAngle = deg2rad($params['launchAngle']);
  $range = $calculator->getRange();

  $res->json(array(
    'params' => $params,
    'results' => array(
      'range' => $range
    )
  ));
});

$app->post('/calculators/intersects-target', function($req, $res){
  $params = array(
    'launchVelocity' => floatval($req->params->launchVelocity),
    'launchAngle' => floatval($req->params->launchAngle),
    'targetDistance' => floatval($req->params->targetDistance),
    'targetSize' => floatval($req->params->targetSize)
  );

  $calculator = new TrajectoryCalculator();
  $calculator->launchVelocity = $params['launchVelocity'];
  $calculator->launchAngle = deg2rad($params['launchAngle']);

  $targetDist = $params['targetDistance'];
  $targetSize = $params['targetSize'];
  $height = $calculator->getHeightAtDistance($targetDist);
  $intersectsTarget = $calculator->intersectsTarget($targetDist, $targetSize);
  $intersectionTime = $calculator->getTimeAtDistance($targetDist);

  $res->json(array(
    'params' => $params,
    'results' => array(
      'height' => $height,
      'intersects' => $intersectsTarget,
      'intersects_in' => $intersectionTime
    )
  ));
});

?>