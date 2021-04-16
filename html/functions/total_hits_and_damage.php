<?php

include 'user_info.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//$username = 'abc123';   <---- MAKE THESE IN 'user_infor.php'
//$password = 'SOME_PASSWORD';   <---- MAKE THESE IN 'user_info.php'
$host = 'localhost';
$dbname = '431W_project';

try {
  session_start();
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $check_user = $pdo->query('SELECT * FROM users WHERE uid="' . $_SESSION["uid"] . '"');
  $check_user->setFetchMode(PDO::FETCH_ASSOC);
  if ($check_user->rowCount() == 0) {
      throw new Exception('Error: Invalid user id!');
  }
  $select_sum = 'SELECT U.uname as uname, SUM(T.hit_points) as hit_points, SUM(T.dpm) as dpm FROM tanks T, inventory_tanks IT, users U ';
  $sql_cond = $select_sum . 'WHERE U.uid='. $_SESSION["uid"] . ' AND U.uid=IT.uid AND IT.tid=T.tid';
  $q = $pdo->query($sql_cond);
  $q->setFetchMode(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Could not connect to the database $dbname :" . $e->getMessage());
} catch (Exception $e) {
   echo '<script type="text/javascript">',
     '(function () {',
     'setTimeout(function() {window.history.back();}, 3000)',
     '})();',
     '</script>'
   ;
    die($e->getMessage() . '.. Redirecting in 3 sec.');
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Total Hit point and Damage</title>
    </head>
    <body>
        <div id="container">
       <h2>User-wide hitpoint and damage statistic</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th> Username</th>
                        <th> Hit Points</th>
                        <th> Damage per minute</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['uname']) ?></td>
                            <td><?php echo htmlspecialchars($row['hit_points']) ?></td>
                            <td><?php echo htmlspecialchars($row['dpm']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
      <br><br><br>
    </body>
</div>
</html>
