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
  $select_sum = 'SELECT SUM(A.price) as a_cost, SUM(T.price) as t_cost, U.uname as u_name FROM inventory_tanks IT, linked L, attachments A , tanks T, users U ';
  $sql_cond = $select_sum . 'WHERE U.uid='. $_SESSION["uid"] . ' AND U.uid=IT.uid AND IT.tid=T.tid AND T.tid=L.tid AND L.aid=A.aid';
  $q = $pdo->query($sql_cond);
  $q->setFetchMode(PDO::FETCH_ASSOC);
//
//  $attachment_money = $q->fetch()['a_cost'];
//  $tanks_money = $q->fetch()['t_cost'];
//  $username = $q->fetch()['u_name'];
//  echo $potential_money;
//  echo $tanks_money;
//  echo $u_name;
//
} catch (PDOException $e) {
   echo "bad";
  #die("Could not connect to the database $dbname :" . $e->getMessage());
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
        <title>Potentially available tanks</title>
    </head>
    <body>
        <div id="container">
       <h2>Available tanks after selling all attachments</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th> Username</th>
                        <th> Gross Buying Power</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['u_name']) ?></td>
                            <td><?php echo htmlspecialchars($row['a_cost'] + $row['t_cost']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
      <br><br><br>
    </body>
</div>
</html>
