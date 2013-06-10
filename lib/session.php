<?php

class Session
{
  public $id;
  public $userAgent;
  public $trajectories;

  function __construct() {
    $this->trajectories = $this->getTrajectories();
  }

  public static function currentSession() {
    if ($_SESSION['id'] != null) {
      return Session::sessionWithId($_SESSION['id']);
    }
    else {
      return Session::newSession();
    }
  }

  public static function newSession() {
    $dbh = Application::getPDO();
    $stmt = $dbh->prepare('INSERT INTO sessions (user_agent) VALUES (?);');
    $stmt->bindValue(1, $_SERVER['HTTP_USER_AGENT']);

    if ($stmt->execute()) {
      $_SESSION['id'] = $dbh->lastInsertId('id');
      return Session::sessionWithId($_SESSION['id']);
    }
    else {
      print_r($dbh->errorInfo());
      throw new Exception('Unable to create session.');
      return null;
    }
  }

  public static function sessionWithId($id) {
    $dbh = Application::getPDO();
    $stmt = $dbh->prepare('SELECT * FROM sessions WHERE id = ?');
    $stmt->bindValue(1, $id);
    
    if ($stmt->execute() && $stmt->rowCount() >= 1) {
      $session = new Session();

      while($row = $stmt->fetch()){
        $session->id = $row['id'];
        $session->userAgent = $row['user_agent'];
      }

      return $session;
    }
    else {
      return Session::newSession();
    }
  }

  public function getTrajectories() {
    $dbh = Application::getPDO();
    $stmt = $dbh->prepare('SELECT * FROM trajectories WHERE session_id = 1');
    $stmt->bindValue(1, $this->id);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public function logTrajectory($params) {
    $dbh = Application::getPDO();
    $stmt = $dbh->prepare('INSERT INTO trajectories
                            (session_id, launch_velocity, launch_angle, distance_to_target, target_size, hit_target, time_to_target)
                            VALUES (?, ?, ?, ?, ?, ?, ?)');
    $stmt->bindValue(1, $this->id);
    $stmt->bindValue(2, $params['launchVelocity']);
    $stmt->bindValue(3, $params['launchAngle']);
    $stmt->bindValue(4, $params['targetDistance']);
    $stmt->bindValue(5, $params['targetSize']);
    $stmt->bindValue(6, $params['hit_target']);
    $stmt->bindValue(7, $params['time_to_target']);

    $stmt->execute();

    # refresh list
    $this->trajectories = $this->getTrajectories();
  }
}

?>