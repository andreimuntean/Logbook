<?php
include 'logbook.inc.php';
include 'db.inc.php';
include 'user.inc.php';

/**
 * Performs user authentication
 *
 * @param String    $username username of the user
 * @param String 	$password    password of the user 
 * @throws PDOException 	invalid input or database disconnection
 * @return Integer 	
 */

    function login($username, $password){
	    try{    
	    	$password = sha1($password);
			$db = DB::getInstance();
	        $stmt = $db->prepare("SELECT * FROM `users` WHERE `username` = ? AND `password` = ?");
	        $stmt->bindParam(1, $username);
	        $stmt->bindParam(2, $password);
	        $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);   
	        $stmt->execute();
        }
	    catch(PDOException $e) {
	    	 echo "Error: " . $e->getMessage();
	    	 return 0;
	    }
        foreach($stmt->fetchAll() as $row){
        	return $row['id'];
        }
        return 0;
    }

/**
 * Registers a user
 *
 * @param String    $email email of the user
 * @param String    $username username of the user
 * @param String 	$password Sha1 encrypted password of the user 
 * @throws PDOException 	invalid input or database disconnection
 * @return Integer 	0 if the user is succesfully registered, -1 if exception is caught
 */


    function register($email, $username, $password){
	    try{
	    	if(!checkEmail($email))
	    		return -2;
	    	if(!checkUsername($username))
	    		return -3;
	    	$db = DB::getInstance();
	    	//encrypting password
	    	$password = sha1($password);
			$registerDate = date('Y-m-d H:i:s');
			//generating user specific password
			$token = md5($email.$username.$password.$registerDate);
			$tokenID = insertToken($token);
	    	$stmt = $db->prepare("INSERT INTO `users`(`email`, `username`, `password`, `confirm_token_id`, `register_date`) VALUES(?, ?, ?, ?, ?)");
	    	$stmt->bindParam(1, $email);
	    	$stmt->bindParam(2, $username);
	    	$stmt->bindParam(3, $password);
	    	$stmt->bindParam(4, $tokenID);
	    	$stmt->bindParam(5, $registerDate);
	    	$stmt->execute();
	    	return $db->lastInsertID();
	    }
	    catch(PDOException $e) {
	    	 echo "Error: " . $e->getMessage();
	    	 return -1;
	    }
	    return -1;
    }


    function insertToken($token){
    	$db = DB::getInstance();
    	//one week later
		$expire_date = date(time()+604800);
		$stmt = $db->prepare("INSERT INTO `confirm_tokens`(`token`, `expire_date`) VALUES(?, ?)");
    	$stmt->bindParam(1, $token);
    	$stmt->bindParam(2, $expire_date);
    	$stmt->execute();
    	return $db->lastInsertID();
    }

    function checkEmail($email){
    	$db = DB::getInstance();
    	$stmt = $db->prepare("SELECT * FROM `users` WHERE `email` = ?");
    	$stmt->bindParam(1, $email);
    	$stmt->execute();
    	if($data = $stmt->fetch())
    		return false;
    	return true;
    }

    function checkUsername($username){
    	$db = DB::getInstance();
    	$stmt = $db->prepare("SELECT * FROM `users` WHERE `username` = ?");
    	$stmt->bindParam(1, $username);
    	$stmt->execute();
    	if($data = $stmt->fetch())
    		return false;
    	return true;
    }

	$action = isset($_POST['action'])?$_POST['action']:"";
	if($action == "search"){
		echo User::search($_POST['token']);
	}

?>
