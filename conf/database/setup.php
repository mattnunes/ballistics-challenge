<?php
  
  try {
    $dbh = new PDO('mysql:host=localhost;dbname=ballistics', 'test', 'test');
  } catch (Exception $e) {
    die('Could not connect to MySql');
  }

  try {
    $dbh->beginTransaction();
    $dbh->exec("CREATE TABLE IF NOT EXISTS sessions
               (
                id int NOT NULL AUTO_INCREMENT,
                user_agent varchar(255),
                PRIMARY KEY(id)
               )");
    $dbh->exec("CREATE TABLE IF NOT EXISTS trajectories
           (
            id int NOT NULL AUTO_INCREMENT,
            session_id int,
            launch_velocity float(12, 2),
            launch_angle float(12, 2),
            distance_to_target float(12, 2),
            target_size float(12, 2),
            hit_target int,
            time_to_target float(12, 2),
            PRIMARY KEY(id),
            FOREIGN KEY (session_id) REFERENCES sessions(id)
           )");
    $dbh->commit();

  } catch (Exception $e) {
    $dbh->rollback();
    die($e->getMessage());
  }
  
?>