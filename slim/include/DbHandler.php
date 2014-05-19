<?php

class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->conn = $db->connect();
    }


// Create the user
public function createUser($first_name, $last_name, $nickname, $email, $password, $facebook, $twitter, $postcode, $age_group) {
	require_once 'PassHash.php';
	$response = array();

	// First check if user already existed in db
	if (!$this->isUserExists($email)) {
	// Generating password hash
	$password_hash = PassHash::hash($password);
	
	// Generating access key
	$access_key = $this->generateAccessKey();

	// insert query
	$stmt = $this->conn->prepare("INSERT INTO users(USER_FIRST_NAME, USER_LAST_NAME, USER_NICKNAME, USER_EMAIL, PASSWORD_HASH, ACCESS_KEY, USER_FACEBOOK_LINK, USER_TWITTER_LINK, USER_POSTCODE, USER_GEO_AGE_GROUP, IS_ACTIVE ) values(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
	$stmt->bind_param("ssssssssss", $first_name, $last_name, $nickname, $email, $password_hash, $access_key, $facebook, $twitter, $postcode, $age_group);

	$result = $stmt->execute();

	$stmt->close();

	// Check for successful insertion
	if ($result) {
	// User successfully inserted
	return USER_CREATED_SUCCESSFULLY;
	} else {
	// Failed to create user
	return USER_CREATE_FAILED;
	}
	} else {
	// User with same email already existed in the db
	return USER_ALREADY_EXISTED;
	}
	return $response;
    }

// Check the login details
public function checkLogin($email, $password) {
	// fetching user by email
	$stmt = $this->conn->prepare("SELECT PASSWORD_HASH FROM users WHERE USER_EMAIL = ?");
	$stmt->bind_param("s", $email);
	$stmt->execute();
    $stmt->bind_result($password_hash);
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
    // Found user with the email
    // Now verify the password
    $stmt->fetch();
    $stmt->close();
    if (PassHash::check_password($password_hash, $password)) {
    // User password is correct
    return TRUE;
    } else {
    // user password is incorrect
    return FALSE;
    }
    } else {
    $stmt->close();
    // user not existed with the email
    return FALSE;
    }
    }

// Check duplicate user
private function isUserExists($email) {
	$stmt = $this->conn->prepare("SELECT id from users WHERE USER_EMAIL = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    return $num_rows > 0;
}

// Grab the user by email
public function getUserByEmail($email) {
$stmt = $this->conn->prepare("SELECT USER_FIRST_NAME, USER_LAST_NAME, USER_NICKNAME, USER_EMAIL, ACCESS_KEY, USER_SIGNUP_DATE_TIME, IS_ACTIVE, USER_FACEBOOK_LINK, USER_TWITTER_LINK, USER_POSTCODE, USER_GEO_LAT, USER_GEO_LON, USER_GEO_AREA, USER_GEO_AGE_GROUP, USER_SIGNUP_DATE_TIME, USER_SIGNUP_IP, USER_LAST_LOGIN_DATE_TIME, USER_LAST_LOGIN_IP, IS_ACTIVE, IS_DELETED FROM users WHERE USER_EMAIL = ?");
	$stmt->bind_param("s", $email);
	if ($stmt->execute()) {
		$stmt->bind_result($first_name, $last_name, $nickname, $email, $access_key, $signup_date_time, $is_active, $facebook_link, $twitter_link, $postcode, $geo_lat, $geo_lon, $geo_area, $age_group, $signup_date, $signip, $login_date, $login_ip, $is_active, $is_deleted);
		$stmt->fetch();
        $user = array();
        $user["USER_FIRST_NAME"] = $first_name;
        $user["USER_LAST_NAME"] = $last_name;
        $user["USER_NICKNAME"] = $nickname;
        $user["USER_EMAIL"] = $email;
        $user["ACCESS_KEY"] = $access_key;
        $user["USER_SIGNUP_DATE_TIME"] = $signup_date_time;
        $user["IS_ACTIVE"] = $is_active;
		$user['USER_FACEBOOK_LINK'] = $facebook_link;
		$user['USER_TWITTER_LINK'] = $twitter_link;
		$user['USER_POSTCODE'] = $postcode;
		$user['USER_GEO_LAT'] = $geo_lat;
		$user['USER_GEO_LON'] = $geo_lon;
		$user['USER_GEO_AREA'] = $geo_area;
		$user['USER_GEO_AGE_GROUP'] = $age_group;				
        $user['USER_SIGNUP_DATE_TIME'] = $signup_date;
		$user['USER_SIGNUP_IP'] = $signip;
		$user['USER_LAST_LOGIN_DATE_TIME'] = $login_date;
		$user['USER_LAST_LOGIN_IP'] = $login_ip;
		$user['IS_ACTIVE'] = $is_active;
		$user['IS_DELETED'] = $is_deleted;
        $stmt->close();
        return $user;
        } else {
        return NULL;
        }		
}

// Check the access key
public function getAccessKeyById($user_id) {
        $stmt = $this->conn->prepare("SELECT ACCESS_KEY FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            $stmt->bind_result($access_key);
            $stmt->close();
            return $access_key;
        } else {
            return NULL;
        }
}

// Grab the user id from the access key
public function getUserId($access_key) {
	$stmt = $this->conn->prepare("SELECT id FROM users WHERE ACCESS_KEY = ?");
	$stmt->bind_param("s", $access_key);
	if ($stmt->execute()) {
 		$stmt->bind_result($user_id);
		$stmt->fetch();
		$stmt->close();
		return $user_id;
        } else {
		return NULL;
        }
}

// Validating user access key
public function isValidAccessKey($access_key) {
	$stmt = $this->conn->prepare("SELECT id from users WHERE ACCESS_KEY = ?");
    $stmt->bind_param("s", $access_key);
    $stmt->execute();
    $stmt->store_result();
    $num_rows = $stmt->num_rows;
    $stmt->close();
    return $num_rows > 0;
}

// Generating random Unique MD5 String for user Access key
private function generateAccessKey() {
    return md5(uniqid(rand(), true));
}


// Grab a single Article
public function getArticle($article_gen_number) {
	$stmt = $this->conn->prepare("SELECT * FROM article WHERE ARTICLE_GEN_NUMBER = ?");
	$stmt->bind_param("i", $article_gen_number);
	if ($stmt->execute()) {
		$res = array();
		$stmt->bind_result($ID, $ARTICLE_GEN_NUMBER, $UPLOAD_DATE_TIME, $PUBLISH_DATE_TIME, $AUTHOR, $NICE_LINK, $TITLE, $SUB_HEADING, $MAIN_CONTENT, $GEO_POSTCODE, $GEO_LAT, $GEO_LON,$GEO_AREA,$IMPRESSIONS, $CONTENT_TYPE, $SPONSOR_GEN_NUMBER, $HAS_VENUE, $VENUE_GEN_NUMBER, $HAS_SHOWING_DATES, $SHOWING_DATES_GEN_NUMBER, $IS_ACTIVE, $IS_FEATURED, $IS_PICKED, $IS_DELETED, $IS_COMMENTS, $IS_APPROVED);

		$stmt->fetch();		
		$res["ID"] = $ID; 
		$res["ARTICLE_GEN_NUMBER"] = $ARTICLE_GEN_NUMBER; 
		$res["UPLOAD_DATE_TIME"] = $UPLOAD_DATE_TIME; 
		$res["PUBLISH_DATE_TIME"] = $PUBLISH_DATE_TIME; 
		$res["AUTHOR"] = $AUTHOR; 
		$res["NICE_LINK"] = $NICE_LINK; 
		$res["TITLE"] = $TITLE; 
		$res["SUB_HEADING"] = $SUB_HEADING; 
		$res["MAIN_CONTENT"] = $MAIN_CONTENT; 
		$res["GEO_POSTCODE"] = $GEO_POSTCODE; 
		$res["GEO_LAT"] = $GEO_LAT; 
		$res["GEO_LON"] = $GEO_LON;
		$res["GEO_AREA"] = $GEO_AREA;
		$res["IMPRESSIONS"] = $IMPRESSIONS; 
		$res["CONTENT_TYPE"] = $CONTENT_TYPE; 
		$res["SPONSOR_GEN_NUMBER"] = $SPONSOR_GEN_NUMBER; 
		$res["HAS_VENUE"] = $HAS_VENUE; 
		$res["VENUE_GEN_NUMBER"] = $VENUE_GEN_NUMBER; 
		$res["HAS_SHOWING_DATES"] = $HAS_SHOWING_DATES; 
		$res["SHOWING_DATES_GEN_NUMBER"] = $SHOWING_DATES_GEN_NUMBER; 
		$res["IS_ACTIVE"] = $IS_ACTIVE; 
		$res["IS_FEATURED"] = $IS_FEATURED; 
		$res["IS_PICKED"] = $IS_PICKED; 
		$res["IS_DELETED"] = $IS_DELETED; 
		$res["IS_COMMENTS"] = $IS_COMMENTS; 
		$res["IS_APPROVED"] = $IS_APPROVED;
			
		$stmt->close();
            return $res;
        } else {
            return NULL;
        }
    }

// Grab all articles
public function getAllArticles($user_id) {
	$stmt = $this->conn->prepare("SELECT * FROM article");
    $stmt->execute();
    $article = $stmt->get_result();
	$stmt->close();
    return $article;
    }

// Sign up a user
public function createUserTask($user_id, $task_id) {
    $stmt = $this->conn->prepare("INSERT INTO user_tasks(user_id, task_id) values(?, ?)");
    $stmt->bind_param("ii", $user_id, $task_id);
    $result = $stmt->execute();

    if (false === $result) {
 	   die('execute() failed: ' . htmlspecialchars($stmt->error));
        }
        $stmt->close();
        return $result;
    }

}

?>
