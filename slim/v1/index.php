<?php

ini_set('display_errors', true);
ini_set('date.timezone', 'Europe/London');

require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '.././libs/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

// User id from db - Global Variable
$user_id = NULL;

function authenticate(\Slim\Route $route) {
    // Getting request headers
    $headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();

    // Verifying Authorization Header
    if (isset($headers['Authorization'])) {
        $db = new DbHandler();

        // get the access key
        $access_key = $headers['Authorization'];
        // validating access key
        if (!$db->isValidAccessKey($access_key)) {
            // access key is not present in users table
            $response["error"] = true;
            $response["message"] = "Access Denied. Invalid Access key";
            echoRespnse(401, $response);
            $app->stop();
        } else {
            global $user_id;
            // get user primary key id
            $user_id = $db->getUserId($access_key);
        }
    } else {
        // access key is missing in header
        $response["error"] = true;
        $response["message"] = "Access key is misssing";
        echoRespnse(400, $response);
        $app->stop();
    }
}

$app->get('/', function() use ($app) {

    $request = $app->request;

    if( $request->isGet() )
    {
        $headers = $request->headers;

        $app->response->setStatus(200);
        $app->response->headers->set('Content-Type', 'application/json');
        $app->response->headers->set('API-Confirm', true);

        if($headers['Accesskey'])
        {
            include('../data/auth-home.php');
        }
        else
        {
            include('../data/home.php');
        }

        $app->response->setBody(json_encode($data));

        $app->response->finalize();

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-Type: application/json');

        echo json_encode($data);

        exit;
    }
    else
    {
        notImplemented();
    }

});

// Registration
$app->post('/register', function() use ($app) {

	verifyRequiredParams(array('first_name', 'last_name', 'nickname', 'email', 'password'));
	$response = array();

	// reading post params
	$first_name = $app->request->post('first_name');
	$last_name = $app->request->post('last_name');
	$nickname = $app->request->post('nickname');
	$email = $app->request->post('email');
	$password = $app->request->post('password');
	$facebook = $app->request->post('facebook');
	$twitter = $app->request->post('twitter');
	$postcode = $app->request->post('postcode');
	$age_group = $app->request->post('age_group');

            // validating email address
            validateEmail($email);

            $db = new DbHandler();
            $res = $db->createUser($first_name, $last_name, $nickname, $email, $password, $facebook, $twitter, $postcode, $age_group);

            if ($res == USER_CREATED_SUCCESSFULLY) {
                $response["error"] = false;
                $response["message"] = "You are successfully registered";
            } else if ($res == USER_CREATE_FAILED) {
                $response["error"] = true;
                $response["message"] = "Oops! An error occurred while registereing";
            } else if ($res == USER_ALREADY_EXISTED) {
                $response["error"] = true;
                $response["message"] = "Sorry, this email already in use";
            }
            // echo json response
            echoRespnse(201, $response);
        });

// Log the user in
$app->post('/login', function() use ($app) {
            // check for required params
            verifyRequiredParams(array('email', 'password'));

            // reading post params
            $email = $app->request()->post('email');
            $password = $app->request()->post('password');
            $response = array();

            $db = new DbHandler();
            // check for correct email and password
            if ($db->checkLogin($email, $password)) {
                // get the user by email
                $user = $db->getUserByEmail($email);

                if ($user != NULL) {
                    $response["error"] = false;
                    $response['USER_FIRST_NAME'] = $user['USER_FIRST_NAME'];
                    $response['USER_LAST_NAME'] = $user['USER_LAST_NAME'];
					$response['USER_NICKNAME'] = $user['USER_NICKNAME'];
                    $response['USER_EMAIL'] = $user['USER_EMAIL'];
                    $response['ACCESS_KEY'] = $user['ACCESS_KEY'];
					$response['USER_FACEBOOK_LINK'] = $user['USER_FACEBOOK_LINK'];
					$response['USER_TWITTER_LINK'] = $user['USER_TWITTER_LINK'];
					$response['USER_POSTCODE'] = $user['USER_POSTCODE'];
					$response['USER_GEO_LAT'] = $user['USER_GEO_LAT'];
					$response['USER_GEO_LON'] = $user['USER_GEO_LON'];
					$response['USER_GEO_AREA'] = $user['USER_GEO_AREA'];
					$response['USER_GEO_AGE_GROUP'] = $user['USER_GEO_AGE_GROUP'];
                    $response['USER_SIGNUP_DATE_TIME'] = $user['USER_SIGNUP_DATE_TIME'];
					$response['USER_SIGNUP_IP'] = $user['USER_SIGNUP_IP'];
					$response['USER_LAST_LOGIN_DATE_TIME'] = $user['USER_LAST_LOGIN_DATE_TIME'];
					$response['USER_LAST_LOGIN_IP'] = $user['USER_LAST_LOGIN_IP'];
					$response['IS_ACTIVE'] = $user['IS_ACTIVE'];
					$response['IS_DELETED'] = $user['IS_DELETED'];

                } else {
                    // unknown error occurred
                    $response['error'] = true;
                    $response['message'] = "An error occurred. Please try again";
                }
            } else {
                // user credentials are wrong
                $response['error'] = true;
                $response['message'] = 'Login failed. Incorrect credentials';

            }
echoRespnse(200, $response);

        });

/*
 * ------------------------ METHODS WITH AUTHENTICATION ------------------------
 */

/**
 * GET ALL ARTICLES
 * method GET
 * url /article
 */
$app->get('/article', 'authenticate', function() {
            global $user_id;
            $response = array();
            $db = new DbHandler();

            // fetching all user tasks
            $result = $db->getAllArticles($user_id);

            $response["error"] = false;
            $response["articles"] = array();

            // looping through result and preparing tasks array
            while ($article = $result->fetch_assoc()) {
                $tmp = array();
                $tmp["ID"] = $article["ID"];
                $tmp["ARTICLE_GEN_NUMBER"] = $article["ARTICLE_GEN_NUMBER"];
                $tmp["UPLOAD_DATE_TIME"] = $article["UPLOAD_DATE_TIME"];
                $tmp["PUBLISH_DATE_TIME"] = $article["PUBLISH_DATE_TIME"];
                $tmp["AUTHOR"] = $article["AUTHOR"];
				$tmp["NICE_LINK"] = $article["NICE_LINK"];
				$tmp["TITLE"] = $article["TITLE"];
				$tmp["SUB_HEADING"] = $article["SUB_HEADING"];
				$tmp["MAIN_CONTENT"] = $article["MAIN_CONTENT"];
				$tmp["GEO_POSTCODE"] = $article["GEO_POSTCODE"];
				$tmp["GEO_LAT"] = $article["GEO_LAT"];
				$tmp["GEO_LON"] = $article["GEO_LON"];
				$tmp["GEO_AREA"] = $article["GEO_AREA"];
				$tmp["IMPRESSIONS"] = $article["IMPRESSIONS"];
				$tmp["CONTENT_TYPE"] = $article["CONTENT_TYPE"];
				$tmp["SPONSOR_GEN_NUMBER"] = $article["SPONSOR_GEN_NUMBER"];
				$tmp["HAS_VENUE"] = $article["HAS_VENUE"];
				$tmp["VENUE_GEN_NUMBER"] = $article["VENUE_GEN_NUMBER"];
				$tmp["HAS_SHOWING_DATES"] = $article["HAS_SHOWING_DATES"];
				$tmp["SHOWING_DATES_GEN_NUMBER"] = $article["SHOWING_DATES_GEN_NUMBER"];
				$tmp["IS_ACTIVE"] = $article["IS_ACTIVE"];
				$tmp["IS_FEATURED"] = $article["IS_FEATURED"];
				$tmp["IS_PICKED"] = $article["IS_PICKED"];
				$tmp["IS_DELETED"] = $article["IS_DELETED"];
				$tmp["IS_COMMENTS"] = $article["IS_COMMENTS"];
				$tmp["IS_APPROVED"] = $article["IS_APPROVED"];

                array_push($response["articles"], $tmp);
            }

            echoRespnse(200, $response);

        });

/**
 * GRAB AN INDIVIDUAL ARTICLE
 */
$app->get('/article/:id', 'authenticate', function($article_gen_number) {
            $response = array();
            $db = new DbHandler();

            // fetch task
            $result = $db->getArticle($article_gen_number);

            if ($result != NULL) {
                $response["error"] = false;
                $response["ID"] = $result["ID"];
                $response["ARTICLE_GEN_NUMBER"] = $result["ARTICLE_GEN_NUMBER"];
                $response["UPLOAD_DATE_TIME"] = $result["UPLOAD_DATE_TIME"];
                $response["PUBLISH_DATE_TIME"] = $result["PUBLISH_DATE_TIME"];
                $response["AUTHOR"] = $result["AUTHOR"];
				$response["NICE_LINK"] = $result["NICE_LINK"];
				$response["TITLE"] = $result["TITLE"];
				$response["SUB_HEADING"] = $result["SUB_HEADING"];
				$response["MAIN_CONTENT"] = $result["MAIN_CONTENT"];
				$response["GEO_POSTCODE"] = $result["GEO_POSTCODE"];
				$response["GEO_LAT"] = $result["GEO_LAT"];
				$response["GEO_LON"] = $result["GEO_LON"];
				$response["GEO_AREA"] = $result["GEO_AREA"];
				$response["IMPRESSIONS"] = $result["IMPRESSIONS"];
				$response["CONTENT_TYPE"] = $result["CONTENT_TYPE"];
				$response["SPONSOR_GEN_NUMBER"] = $result["SPONSOR_GEN_NUMBER"];
				$response["HAS_VENUE"] = $result["HAS_VENUE"];
				$response["VENUE_GEN_NUMBER"] = $result["VENUE_GEN_NUMBER"];
				$response["HAS_SHOWING_DATES"] = $result["HAS_SHOWING_DATES"];
				$response["SHOWING_DATES_GEN_NUMBER"] = $result["SHOWING_DATES_GEN_NUMBER"];
				$response["IS_ACTIVE"] = $result["IS_ACTIVE"];
				$response["IS_FEATURED"] = $result["IS_FEATURED"];
				$response["IS_PICKED"] = $result["IS_PICKED"];
				$response["IS_DELETED"] = $result["IS_DELETED"];
				$response["IS_COMMENTS"] = $result["IS_COMMENTS"];
				$response["IS_APPROVED"] = $result["IS_APPROVED"];

                echoRespnse(200, $response);
            } else {
                $response["error"] = true;
                $response["message"] = "The requested resource doesn't exists";
                echoRespnse(404, $response);
            }
        });



// Verifying required params posted or not
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;

    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Validating email address
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = true;
        $response["message"] = 'Email address is not valid';
        echoRespnse(400, $response);
        $app->stop();
    }
}

/**
 * Echoing json response to client
 * @param String $status_code Http response code
 * @param Int $response Json response
 */
function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

function notImplemented()
{
    exit('not implemented');
}

function showData($data)
{
    echo "<pre>";
        print_r($data);
    echo "</pre>";
    exit;
}

$app->run();
?>
