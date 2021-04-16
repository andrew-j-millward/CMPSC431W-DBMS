<?php

include 'user_info.php';


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = '431W_project';

try {
  session_start();
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $check_tank = $pdo->query('SELECT * FROM tanks WHERE tid="' . $_SESSION["tid2"] . '"');
  $check_tank->setFetchMode(PDO::FETCH_ASSOC);
  if ($check_tank->rowCount() == 0) {
      throw new Exception('Error: Invalid tank id!');
  }
  $sql1 = 'SELECT sid FROM system WHERE sname="' . $_SESSION['sid2'] . '"';
  $sid = $pdo->query($sql1);
  $sid->setFetchMode(PDO::FETCH_ASSOC);
  $r1 = $sid->fetch();
  $select = 'SELECT attachments.aname, attachments.price FROM attachments, linked ';
  $select = $select . 'WHERE attachments.aid=linked.aid AND linked.tid='. $_SESSION["tid2"] .' AND attachments.sid='. $r1['sid'];
  $q = $pdo->query($select);
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
        <title>Available Attachments</title>
    </head>
    <body>
        <div id="container">
       <h2>Attachments that fit on a specified tank</h2>
            <table border=1 cellspacing=5 cellpadding=5>
                <thead>
                    <tr>
                        <th> Attachment Name</th>
                        <th> Attachment Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $q->fetch()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['aname']) ?></td>
                            <td><?php echo htmlspecialchars($row['price']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
      <br><br><br>
    </body>
</div>
</html>

