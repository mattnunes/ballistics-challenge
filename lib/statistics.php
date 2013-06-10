<?php

class Statistics
{
  public static function getTop5() {
    $dbh = Application::getPDO();
    $stmt = $dbh->prepare('SELECT *,
                                  ROUND(sub.totalHits/sub.totalShots, 4) as accuracy,
                                  ROUND(sub.totalShots/sub.totalHits, 2) as shotsPerHit,
                                  @row_num := @row_num + 1 as rank 
                                  FROM 
                                  (SELECT session_id, 
                                          SUM(1) as totalShots, 
                                          SUM(hit_target) as totalHits 
                                        FROM trajectories
                                        GROUP BY session_id 
                                        ORDER BY (SUM(hit_target)/SUM(1)) DESC) sub LIMIT 5;');

    $dbh->exec('SET @row_num = 0;');
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }

  public static function getCurrent() {
    $dbh = Application::getPDO();
    $stmt = $dbh->prepare('SELECT * FROM (SELECT *,
                                  ROUND(sub.totalHits/sub.totalShots, 4) as accuracy,
                                  ROUND(sub.totalShots/sub.totalHits, 2) as shotsPerHit,
                                  @row_num := @row_num + 1 as rank 
                                  FROM 
                                  (SELECT session_id, 
                                          SUM(1) as totalShots, 
                                          SUM(hit_target) as totalHits 
                                        FROM trajectories
                                        GROUP BY session_id 
                                        ORDER BY (SUM(hit_target)/SUM(1)) DESC) sub) t WHERE session_id = ?;');
    $current_session = Session::currentSession();
    $stmt->bindValue(1, $current_session->id);
    $dbh->exec('SET @row_num = 0;');
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public static function getUserCount() {
    $dbh = Application::getPDO();
    $stmt = $dbh->prepare('SELECT COUNT(id) as userCount FROM sessions');
    
    if ($stmt->execute()) {
      $val = $stmt->fetch(PDO::FETCH_ASSOC);
      return $val['userCount'];
    }
    else {
      return 0;
    }
  }

  public static function getShotCount() {
    $dbh = Application::getPDO();
    $stmt = $dbh->prepare('SELECT COUNT(id) as shotCount FROM trajectories');
    
    if ($stmt->execute()) {
      $val = $stmt->fetch(PDO::FETCH_ASSOC);
      return $val['shotCount'];
    }
    else {
      return 0;
    }
  }
}

?>