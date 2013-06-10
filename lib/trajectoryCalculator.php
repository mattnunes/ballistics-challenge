<?php

class TrajectoryCalculator
{
  public $launchVelocity;
  public $launchAngle;
  public $gravity;
  public $precision;

  function __construct() {
    $this->gravity = 9.8;
    $this->precision = 2;
  }

  public function getRange(){
    $velSquared = pow($this->launchVelocity, 2);
    $range = ($velSquared * sin(2 * $this->launchAngle));
    $range /= $this->gravity;

    return round($range, $this->precision);
  }

  public function intersectsTarget($targetDist, $targetSize = 1) {
    $min = 0;
    $max = $targetSize;

    $range = $this->getHeightAtDistance($targetDist);
    return ($range >= $min && $range <= $max);
  }

  private function _getTimeAtDistance($distance) {
    return $distance / ($this->launchVelocity * cos($this->launchAngle));
  }

  public function getTimeAtDistance($distance) {
    return round($this->_getTimeAtDistance($distance), $this->precision);
  }

  public function getHeightAtDistance($distance) {
    $time = $this->_getTimeAtDistance($distance);
    $height = $this->launchVelocity * sin($this->launchAngle) * $time;
    $height += -.5 * $this->gravity * pow($time, 2);
    return round($height, $this->precision);;
  }
}

?>