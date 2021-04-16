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
        <title>Trading tanks...</title>
    </head>
    <body>	
		<p>
                    <?php
					session_start();
					echo "Trading Tank: " . $_SESSION["sell_tid"] . "...<br>";
                                
                    try {
						$_POST["uid"] = $_SESSION["uid"];
						$_POST["tid"] = $_SESSION["sell_tid"];
                        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					 
					 
                                        
                        // OUTSIDE IN
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        #$conn->exec($sql_start_txn);
						#$conn->exec($commit);

						$conn->exec($start_txn);
						
						$check_balance1 = $conn->query('SELECT ubalance FROM users WHERE uid1="' . $_POST["uid"] . '"');
						$check_price1 = $conn->query('SELECT price FROM tanks WHERE tid="' . $_POST["tid"] . '"');
						$check_balance1->setFetchMode(PDO::FETCH_ASSOC);
						$check_price1->setFetchMode(PDO::FETCH_ASSOC);

						$check_balance2 = $conn->query('SELECT ubalance FROM users WHERE uid2="' . $_POST["uid"] . '"');
						$check_price2 = $conn->query('SELECT price FROM tanks WHERE tid="' . $_POST["tid"] . '"');
						$check_balance2->setFetchMode(PDO::FETCH_ASSOC);
						$check_price2->setFetchMode(PDO::FETCH_ASSOC);

						#CHECK VALID IDs
						if ($check_price1->rowCount() == 0) {
      						   throw new InvalidInputException('ERROR: Invalid attachment id!');
      						}
      					if ($check_balance1->rowCount() == 0) {
      						throw new InvalidInputException('ERROR: Invalid user id!');
							  }
						if ($check_price2->rowCount() == 0) {
								throw new InvalidInputException('ERROR: Invalid attachment id!');
							 }
						 if ($check_balance2->rowCount() == 0) {
							 throw new InvalidInputException('ERROR: Invalid user id!');
							 }
						

						$check_ownership1 = $conn->query('SELECT * FROM inventory_attachments WHERE uid1='. $_POST["uid"] . ' AND aid=' . $_POST["aid"]);
						$check_ownership2 = $conn->query('SELECT * FROM inventory_attachments WHERE uid2='. $_POST["uid"] . ' AND aid=' . $_POST["aid"]);

						#Check if user already owns an item
						if ($check_ownership1->rowCount() > 0){
						   throw new OwnershipException('ERROR: You already own this attachment!');
						}	
						if ($check_ownership2->rowCount() > 0){
							throw new OwnershipException('ERROR: You already own this attachment!');
						 }

						#TRADE
		                $update_tank1 = 'INSERT INTO inventory_attachments (uid1, aid) ';
						$update_tank1 = $update_tank1 . 'VALUES ("'.$_POST["uid"] . '","' . $_POST["aid"] . '")';

		                $update_tank2 = 'INSERT INTO inventory_attachments (uid2, aid) ';
						$update_tank2 = $update_tank2 . 'VALUES ("'.$_POST["uid"] . '","' . $_POST["aid"] . '")';
							
						$conn->exec($update_tank1);
						$conn->exec($update_tank2);
						
						#CHECK VALUES 
						$check_new_tank1 = $conn->query('SELECT tid FROM tanks WHERE uid2=' . $_POST["uid"]);
						$check_new_tank1->setFetchMode(PDO::FETCH_ASSOC);
						
						$check_new_tank2 = $conn->query('SELECT tid FROM tanks WHERE uid1=' . $_POST["uid"]);
						$check_new_tank2->setFetchMode(PDO::FETCH_ASSOC);						

						if($check_new_tank1->rowCount() == 0){
							throw new Exception('Tank was not traded for unknown reason');
						}
						if($check_new_tank2->rowCount() == 0){
							throw new Exception('Tank was not traded for unknown reason');
						}
						
						#SUCCESS
						echo "purchase successful, committing...";	
						$conn->exec($commit);

                        ?>
                                      
                                       
                                        
                                         
                                          

                         <?php
                                
                }
                catch(PDOException $e){
                    echo "Error logging into SQL: " . $e->getMessage();

                }
                catch(InsufficientFundsException $e){
					echo "Insufficient Funds Exception: ". $e->getMessage;
					$conn->exec($rollback);

                }
                catch(InvalidInputException $e){
					echo "Invalid Input Exception: " . $e->getMessage();
					$conn->exec($rollback);
				
                }
                catch(OwnershipException $e){
					echo "Ownership Exception: " . $e->getMessage();
					$conn->exec($rollback);
					
                }
                catch(Exception $e){
                    echo "Error: " . $e->getMessage();
                    $conn->exec($rollback);
				
				}
				$conn = null;




			?>

                <p>You will be redirected in 3 seconds</p>
                <script>
                    var timer = setTimeout(function() {
                        window.location='../inventory_management.php'
                    }, 10000);
                </script>

                </p>
    </body>
</div>


