<?php
	include "db.inc.php";
	$db = DB::getInstance();

/**
 * Performs user authentication
 *
 * @param String    $username username of the user
 * @param String 	$password Sha1 encrypted password of the user 
 * @throws PDOException 	invalid input or database disconnection
 * @return Integer 	
 */

    function login($username, $password){
	    try{    
	        $stmt = $db->prepare("SELECT * FROM `Users` WHERE `username` = username AND `password` = password");
	        $stmt->bindParam(':username', $username);
	        $stmt->bindParam(':password', $password);
	        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);   
	        $stmt->execute();
        }
	    catch(PDOException $e) {
	    	 echo "Error: " . $e->getMessage();
	    	 return;
	    }

        foreach($result as $row){
        	return $row['id'];
        }
        return 0;
    }

/**
 * Registers a user
 *
 * @param String    $name name of the user
 * @param String    $email email of the user
 * @param String    $username username of the user
 * @param String 	$password Sha1 encrypted password of the user 
 * @throws PDOException 	invalid input or database disconnection
 * @return Integer 	0 if the user is succesfully registered, -1 if exception is caught
 */


    function register($name, $email, $username, $password){
	    try{
	    	$password = sha1($password);
	    	$stmt = $db->prepare("INSERT INTO `Users`(`name`, `email`, `username`, `password`) VALUES(name, email, username, password)");
	    	$stmt->bindParam(':name', $name);
	    	$stmt->bindParam(':email', $email);
	    	$stmt->bindParam(':username', $username);
	    	$stmt->bindParam(':password', $password);
	    	$stmt->execute();
	    }
	    catch(PDOException $e) {
	    	 echo "Error: " . $e->getMessage();
	    	 return -1;
	    }
	    return 0;
    }
?>

