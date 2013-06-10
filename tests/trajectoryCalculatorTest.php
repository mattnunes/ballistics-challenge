<?php

include_once 'lib/trajectoryCalculator.php';

class TrajectoryCalculatorTest extends PHPUnit_Framework_TestCase
{
  protected function setUp() {
    $this->calculator = new TrajectoryCalculator();
  }

  public function testRangeCalculation() {
    $calculator = $this->calculator;
    $calculator->launchVelocity = 10; #meters/second
    $calculator->launchAngle = deg2rad(45); #radians

    $this->assertEquals(10.20, $calculator->getRange());
  }

  public function testRangeCalculation2() {
    $calculator = $this->calculator;
    $calculator->launchVelocity = 45; #meters/second
    $calculator->launchAngle = deg2rad(90); #radians

    $this->assertEquals(0.00, $calculator->getRange());
  }

  public function testRangeCalculation3() {
    $calculator = $this->calculator;
    $calculator->launchVelocity = 0; #meters/second
    $calculator->launchAngle = deg2rad(45); #radians

    $this->assertEquals(0.00, $calculator->getRange());
  }

  public function testRangeCalculation4() {
    $calculator = $this->calculator;
    $calculator->launchVelocity = 40; #meters/second
    $calculator->launchAngle = deg2rad(75); #radians

    $this->assertEquals(81.63, $calculator->getRange());
  }

  public function testRangeCalculation5() {
    $calculator = $this->calculator;
    $this->assertEquals(0.00, $calculator->getRange());
  }

  public function testTimeAtDistance(){
    $calculator = $this->calculator;
    $calculator->launchVelocity = 25; #meters/second
    $calculator->launchAngle = deg2rad(45); #radians

    $this->assertEquals(0.68, $calculator->getTimeAtDistance(12));
  }

  public function testHeightAtDistance(){
    $calculator = $this->calculator;
    $calculator->launchVelocity = 25; #meters/second
    $calculator->launchAngle = deg2rad(45); #radians

    $this->assertEquals(9.74, $calculator->getHeightAtDistance(12));
  }

  public function testHitsTarget() {
    $calculator = $this->calculator;
    $calculator->launchVelocity = 25; #meters/second
    $calculator->launchAngle = deg2rad(45); #radians

    $this->assertTrue($calculator->intersectsTarget(12, 10));
  }

  public function testMissesTarget() {
    $calculator = $this->calculator;
    $calculator->launchVelocity = 20; #meters/second
    $calculator->launchAngle = deg2rad(75); #radians

    $this->assertFalse($calculator->intersectsTarget(80, 2));
  }
}

?>