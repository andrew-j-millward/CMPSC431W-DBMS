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
        <title>Deleting attachment...</title>
    </head>
    <body>	
		<p>
<?php
				session_start();
                                echo "Purchasing attachment: " . $_SESSION["purchase_aid"] . "...<br>";
                                
                                try {
                                        	 $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
					 	 $_POST["uid"] = $_SESSION["uid"];
						 $_POST["aid"] = $_SESSION["purchase_aid"];
					 
                                        
                                                // OUTSIDE IN
                                                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                                #$conn->exec($sql_start_txn);
						#$conn->exec($commit);

						$conn->exec($start_txn);
						
					        $check_balance = $conn->query('SELECT ubalance FROM users WHERE uid="' . $_POST["uid"] . '"');
						$check_price = $conn->query('SELECT price FROM attachments WHERE aid="' . $_POST["aid"] . '"');
						$check_balance->setFetchMode(PDO::FETCH_ASSOC);
						$check_price->setFetchMode(PDO::FETCH_ASSOC);

						#CHECK VALID IDs
						if ($check_price->rowCount() == 0) {
      						   throw new InvalidInputException('ERROR: Invalid attachment id!');
      						}
      						if ($check_balance->rowCount() == 0) {
      						   throw new InvalidInputException('ERROR: Invalid user id!');
      					        }
						

						$check_ownership = $conn->query('SELECT * FROM inventory_attachments WHERE uid='. $_POST["uid"] . ' AND aid=' . $_POST["aid"]);

						#Check if user already owns an item
						if ($check_ownership->rowCount() > 0){
						   throw new OwnershipException('ERROR: You already own this attachment!');
						}	

						$bal = $check_balance->fetch()["ubalance"];
						$price = $check_price->fetch()["price"];
						if($bal < $price){
							throw new InsufficientFundsException("You do not have enough money for that attachment!");
						}

						#SUBTRACT AND UPDATE
						
						$subtract_price = 'UPDATE users SET ubalance= '. $bal . '-' . $price . ' WHERE uid=' . $_POST["uid"];
						
		                                $update_attachments = 'INSERT INTO inventory_attachments (uid, aid) ';
						$update_attachments = $update_attachments . 'VALUES ("'.$_POST["uid"] . '","' . $_POST["aid"] . '")';
							
						$conn->exec($subtract_price);
						$conn->exec($update_attachments);
						
						#CHECK VALUES 
						$check_new_balance = $conn->query('SELECT ubalance FROM users WHERE uid=' . $_POST["uid"]);
						$check_new_balance->setFetchMode(PDO::FETCH_ASSOC);
						$new_bal = $check_new_balance->fetch()["ubalance"];

						if($new_bal != ($bal - $price)){
							throw new Exception("Exit price does not match");
						}
						
						
						$check_new_attach = $conn->query('SELECT * FROM inventory_attachments WHERE aid=' . $_POST["aid"] . ' AND uid=' . $_POST["uid"]);
						$check_new_attach->setFetchMode(PDO::FETCH_ASSOC);

						if($check_new_attach->rowCount() == 0){
							throw new Exception('Attachment was not added for unknown reason');
						}
						
						#SUCCESS
						echo "purchase successful, committing...";	
						$conn->exec($commit);

                                        ?>
                                      
                                       
                                        
                                         
                                          

                         <?php
                                
				}catch(PDOException $e){
                                        echo "Error logging into SQL: " . $e->getMessage();

                                }catch(InsufficientFundsException $e){
					echo "Insufficient Funds Exception: ". $e->getMessage;
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


