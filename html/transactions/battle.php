<?php

include '../user_info.php';
include '../globals.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$dbname = '431W_project';





?>
<!DOCTYPE html>
<html>
    <head>
        <title>Battling Tanks...</title>
    </head>
    <body>	
		<p>
                        <?php
				session_start();
				echo "Battling with  Tank: " . $_SESSION["battle_tid"] . "...<br>";
                                
                                try {
						$_POST["uid"] = $_SESSION["uid"];
						$_POST["tid"] = $_SESSION["battle_tid"];
						$conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					 
					 
                                        
                                                // OUTSIDE IN
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                #$conn->exec($sql_start_txn);
						#$conn->exec($commit);

						$conn->exec($start_txn);
						
					        $check_user = $conn->query('SELECT * FROM users WHERE uid="' . $_POST["uid"] . '"');
						$check_tank = $conn->query('SELECT * FROM tanks WHERE tid="' . $_POST["tid"] . '"');
						$check_user->setFetchMode(PDO::FETCH_ASSOC);
						$check_tank->setFetchMode(PDO::FETCH_ASSOC);

						#CHECK VALID IDs
						if ($check_tank->rowCount() == 0) {
      						   throw new InvalidInputException('ERROR: Invalid tank id!');
      						}
      						if ($check_user->rowCount() == 0) {
      						   throw new InvalidInputException('ERROR: Invalid user id!');
      					        }
						

						$check_ownership = $conn->query('SELECT * FROM inventory_tanks WHERE uid='. $_POST["uid"] . ' AND tid=' . $_POST["tid"]);

						#Check if user  owns an item
						if ($check_ownership->rowCount() == 0){
						   throw new OwnershipException('ERROR: You do not own this tank!');
						}	
						
						$is_repaired = $check_ownership->fetch()["ready_to_battle"];

						if($is_repaired != 0){
							throw new Exception("This tank needs to be repaired to be used in battle!");
						}

						
						$update_IT = 'UPDATE inventory_tanks SET ready_to_battle=1, tbc=tbc+1 WHERE uid=' . $_POST["uid"] . ' AND tid=' . $_POST["tid"];

						$update_user = 'UPDATE users SET ubc=ubc+1 WHERE uid=' . $_POST["uid"];

						$conn->exec($update_IT);
						$conn->exec($update_user);
						$random_val = random_int(0, 10);
						

						
						if($random_val > 5){
?>
							<h2> Congratulations, you win! </h2>
							<h3> You won <?php echo ($random_val * 100000) ?> in prizes. </h3>
<?php
							$win_update_user = 'UPDATE users SET uwc = uwc+1, ubalance = ubalance+ ('. $random_val . '*100000) WHERE uid=' . $_POST["uid"];
							$win_update_IT = 'UPDATE inventory_tanks SET twc = twc+1 WHERE uid=' . $_POST["uid"] . ' AND tid=' . $_POST["tid"];
													
							$conn->exec($win_update_user);
							$conn->exec($win_update_IT);

						}


						else{
							
?>
							<h2> Sorry, you lost.  </h2>
							<h3> You didn't earn anything. </h3>	
<?php
						}

						echo "Battle complete, committing...";	
						$conn->exec($commit);

                                        ?>
                                      
                                       
                                        
                                         
                                          

                         <?php
                                
				}catch(PDOException $e){
                                        echo "Error logging into SQL: " . $e->getMessage();

                                }catch(InsufficientFundsException $e){
					echo "Insufficient Funds Exception: ". $e->getMessage();
					$conn->exec($rollback);

				}catch(InvalidInputException $e){
					echo "Invalid Input Exception: " . $e->getMessage();
					$conn->exec($rollback);
				
				}catch(OwnershipException $e){
					echo "Ownership Exception: " . $e->getMessage();
					$conn->exec($rollback);
					
				}catch(Exception $e){
                                        echo "Error: " . $e->getMessage();
                                        $conn->exec($rollback);
				
				}
				$conn = null;




			?>

                                        <p>You will be redirected in 10 seconds</p>
                                        <script>
                                                var timer = setTimeout(function() {
                                                        window.location='../inventory_management.php'
                                            }, 10000);
                                        </script>

                </p>
    </body>
</div>


