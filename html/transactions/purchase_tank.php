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
        <title>Purchasing Tank...</title>
    </head>
    <body>	
		<p>
				<?php
				session_start();
                                echo "Purchasing Tank: " . $_SESSION["purchase_tid"] . "...<br>";
                                
                                try {
                                        	 $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					 
					 
                                        
                                                // OUTSIDE IN
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                #$conn->exec($sql_start_txn);
						#$conn->exec($commit);

						$conn->exec($start_txn);
						
					        $check_balance = $conn->query('SELECT ubalance FROM users WHERE uid="' . $_SESSION["uid"] . '"');
						$check_price = $conn->query('SELECT price FROM tanks WHERE tid="' . $_SESSION["purchase_tid"] . '"');
						$check_balance->setFetchMode(PDO::FETCH_ASSOC);
						$check_price->setFetchMode(PDO::FETCH_ASSOC);

						#CHECK VALID IDs
						if ($check_price->rowCount() == 0) {
      						   throw new InvalidInputException('ERROR: Invalid tank id!');
      						}
      						if ($check_balance->rowCount() == 0) {
      						   throw new InvalidInputException('ERROR: Invalid user id!');
      					        }
						

						$check_ownership = $conn->query('SELECT * FROM inventory_tanks WHERE uid='. $_SESSION["uid"] . ' AND tid=' . $_SESSION["purchase_tid"]);

						#Check if user already owns an item
						if ($check_ownership->rowCount() > 0){
						   throw new OwnershipException('ERROR: You already own this tank!');
						}	

						$bal = $check_balance->fetch()["ubalance"];
						$price = $check_price->fetch()["price"];
						if($bal < $price){
							throw new InsufficientFundsException("You do not have enough money for that tank!");
						}

						#SUBTRACT AND UPDATE
						
						$subtract_price = 'UPDATE users SET ubalance= '. $bal . '-' . $price . ' WHERE uid=' . $_SESSION["uid"];
						
		                                #$update_tanks = 'INSERT INTO inventory_tanks (uid, tid, pid, twc, tbc, ready_to_battle) ';
						#$update_tanks = $update_tanks . 'VALUES ('.$_POST["uid"] . ',' . $_POST["tid"] . ', pid=0, twc=0, tbc=0, ready_to_battle=0)';

						
						$update_tanks = 'INSERT INTO inventory_tanks (uid, tid, pid, twc, tbc, ready_to_battle) ';
						$update_tanks = $update_tanks . 'VALUES ("'.$_SESSION["uid"] . '","' . $_SESSION["purchase_tid"] . '","' . "0" . '","' . "0" . '","' . "0"  . '","' . "0" . '")';
	
						$conn->exec($subtract_price);
						$conn->exec($update_tanks);
						
						#CHECK VALUES 
						$check_new_balance = $conn->query('SELECT ubalance FROM users WHERE uid=' . $_SESSION["uid"]);
						$check_new_balance->setFetchMode(PDO::FETCH_ASSOC);
						$new_bal = $check_new_balance->fetch()["ubalance"];

						if($new_bal != ($bal - $price)){
							throw new Exception("Exit price does not match");
						}
						
						
						$check_new_attach = $conn->query('SELECT * FROM inventory_tanks WHERE tid=' . $_SESSION["purchase_tid"] . ' AND uid=' . $_SESSION["uid"]);
						$check_new_attach->setFetchMode(PDO::FETCH_ASSOC);

						if($check_new_attach->rowCount() == 0){
							throw new Exception('Tank was not added for unknown reason');
						}
						
						#SUCCESS
						echo "purchase successful, committing...";	
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


