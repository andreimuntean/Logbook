<?php
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
		$db = DB::getInstance();
	        $stmt = $db->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
	        $stmt->bindParam(1, $username);
	        $stmt->bindParam(2, $password);
	        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);   
	        $stmt->execute();
        }
	    catch(PDOException $e) {
	    	 echo "Error: " . $e->getMessage();
	    	 return;
	    }

        foreach($stmt->fetchAll() as $row){
        	return $row['username'];
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
		$db = DB::getInstance();
	    	$stmt = $db->prepare("INSERT INTO `users`(`name`, `email`, `username`, `password`) VALUES(?, ?, ?, ?)");
	    	$stmt->bindParam(1, $name);
	    	$stmt->bindParam(2, $email);
	    	$stmt->bindParam(3, $username);
	    	$stmt->bindParam(4, $password);
	    	$stmt->execute();
	    }
	    catch(PDOException $e) {
	    	 echo "Error: " . $e->getMessage();
	    	 return -1;
	    }
	    return 0;
    }

?>
